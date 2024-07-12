<?php
session_start();
include '../../../db.php'; // Incluye tu archivo de conexión a la base de datos

// Consulta para obtener todos los usuarios, sus sectores y el estado de sus encuestas
$sql = "SELECT Usuario.id_usuario, Usuario.usuario, Sector.nombre_sector, Usuario.check_respuesta
        FROM Usuario
        LEFT JOIN Sector ON Usuario.id_sector = Sector.id_sector";

$result = $conn->query($sql);

$usuarios_encuestas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios_encuestas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Resultados - Panel Administrativo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resultadosTable').DataTable();

            // Función para cargar el progreso de la encuesta en el modal
            $('.btn-ver-progreso').click(function() {
                var userId = $(this).data('userid');
                $.ajax({
                    url: 'ver_progreso.php',
                    type: 'GET',
                    data: { id_usuario: userId },
                    success: function(data) {
                        $('#progresoContent').html(data);
                        $('#progresoModal').modal('show');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Ver Resultados de Encuestas</h2>
        <table id="resultadosTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Sector</th>
                    <th>Estado de Encuesta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios_encuestas as $usuario_encuesta): ?>
                <tr>
                    <td><?php echo $usuario_encuesta['usuario']; ?></td>
                    <td><?php echo $usuario_encuesta['nombre_sector']; ?></td>
                    <td><?php echo $usuario_encuesta['check_respuesta'] ? 'Completada' : 'Iniciada'; ?></td>
                    <td>
                        <button class="btn btn-info btn-sm btn-ver-progreso" data-userid="<?php echo $usuario_encuesta['id_usuario']; ?>">Ver Progreso</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para mostrar el progreso de la encuesta -->
    <div class="modal fade" id="progresoModal" tabindex="-1" role="dialog" aria-labelledby="progresoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progresoModalLabel">Progreso de la Encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="progresoContent">
                    <!-- Contenido cargado mediante AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
