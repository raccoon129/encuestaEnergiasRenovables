<?php
include '../../includes/session_check.php';
// Permitir acceso solo a administradores
check_access(['admon']);

include '../../../db.php';

// Consultar los usuarios y sectores
$sql = "SELECT Usuario.id_usuario, Usuario.usuario, Sector.nombre_sector, Usuario.check_respuesta
        FROM Usuario
        JOIN Sector ON Usuario.id_sector = Sector.id_sector";
$result = $conn->query($sql);

$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Consultar si el usuario ha iniciado la encuesta
        $sql_encuesta = "SELECT COUNT(*) as count FROM Encuesta WHERE id_usuario = " . $row['id_usuario'];
        $result_encuesta = $conn->query($sql_encuesta);
        $row_encuesta = $result_encuesta->fetch_assoc();

        // Consultar si el usuario tiene respuestas
        $sql_respuesta = "SELECT COUNT(*) as count FROM Respuesta 
                          JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta 
                          WHERE Encuesta.id_usuario = " . $row['id_usuario'];
        $result_respuesta = $conn->query($sql_respuesta);
        $row_respuesta = $result_respuesta->fetch_assoc();

        if ($row['check_respuesta'] == 1) {
            $row['estado_encuesta'] = 'Completado';
        } elseif ($row_encuesta['count'] > 0 && $row_respuesta['count'] > 0) {
            $row['estado_encuesta'] = 'En progreso';
        } else {
            $row['estado_encuesta'] = 'No la ha iniciado';
        }

        // Calcular el progreso del usuario
        $sql_progreso = "SELECT COUNT(*) AS respuestas_contestadas FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = " . $row['id_usuario'] . ")";
        $result_progreso = $conn->query($sql_progreso);
        $row_progreso = $result_progreso->fetch_assoc();
        $respuestas_contestadas = $row_progreso['respuestas_contestadas'];
        $total_respuestas = 18 * 8.5; // 17 categorías y 17 pares por categoría
        $progreso = ($respuestas_contestadas / $total_respuestas) * 100;

        $row['progreso'] = $progreso;

        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <title>Resultados de Encuestas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="../../../styles/stylesCategoriasEncuesta.css">
</head>
<body>
    <div class="container mt-2">
        <h2>Resultados de Encuestas</h2>
        <table id="resultados" class="display">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Usuario</th>
                    <th>Sector</th>
                    <th>Estado de la Encuesta</th>
                    <th>Barra de Progreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id_usuario']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['nombre_sector']; ?></td>
                    <td>
                        <span class="<?php 
                            if ($usuario['estado_encuesta'] == 'Completado') {
                                echo 'text-success';
                            } elseif ($usuario['estado_encuesta'] == 'En progreso') {
                                echo 'text-warning';
                            } else {
                                echo 'text-danger';
                            }
                        ?>">
                            <?php echo $usuario['estado_encuesta']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="progress" style="height: 20px; width: 100px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $usuario['progreso']; ?>%;" aria-valuenow="<?php echo $usuario['progreso']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <button class="btn btn-primary ver-progreso" data-id="<?php echo $usuario['id_usuario']; ?>">
                                <i class="fas fa-eye"></i> Ver Progreso
                            </button>
                            <?php if ($usuario['estado_encuesta'] == 'Completado'): ?>
                                <button class="btn btn-success descargar-excel" data-id="<?php echo $usuario['id_usuario']; ?>">
                                    <i class="fas fa-download"></i> Descargar Excel
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-download"></i> Descargar Excel
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#resultados').DataTable();

            $('.ver-progreso').click(function() {
                var userId = $(this).data('id');
                window.open('ver_progreso.php?id_usuario=' + userId, 'Progreso de la Encuesta', 'width=800,height=600');
            });

            $('.descargar-excel').click(function() {
                var userId = $(this).data('id');
                
                $.ajax({
                    url: 'descargar_respuesta.php',
                    type: 'GET',
                    data: { id_usuario: userId },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data, textStatus, xhr) {
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var fileName = disposition.match(/filename="(.+)"/)[1];
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = fileName;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        toastr.success('El archivo Excel se ha generado y descargado exitosamente.');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error('Hubo un problema al generar o descargar el archivo Excel.');
                    }
                });
            });

            // Mostrar notificaciones basadas en la URL
            <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                toastr.success('El archivo Excel se ha generado y descargado exitosamente.');
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == 0) { ?>
                toastr.error('Hubo un problema al generar o descargar el archivo Excel.');
            <?php } ?>
        
        });
    </script>
</body>
</html>
