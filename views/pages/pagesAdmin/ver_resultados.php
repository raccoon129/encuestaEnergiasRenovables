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

        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Encuestas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                        <button class="btn btn-primary ver-progreso" data-id="<?php echo $usuario['id_usuario']; ?>">Ver Progreso</button>
                        <?php if ($usuario['estado_encuesta'] == 'Completado'): ?>
                            <button class="btn btn-success descargar-excel" data-id="<?php echo $usuario['id_usuario']; ?>">Descargar excel</button>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Descargar excel</button>
                        <?php endif; ?>
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
                window.location.href = 'descargar_respuesta.php?id_usuario=' + userId;
            });
        });
    </script>
</body>
</html>
