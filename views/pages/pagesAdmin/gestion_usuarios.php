<?php
session_start();
include '../../../db.php';

// Obtener los sectores
$sql = "SELECT id_sector, nombre_sector FROM Sector";
$result = $conn->query($sql);

$sectores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['nombre_sector'] !== 'admon') {
            $sectores[] = $row;
        }
    }
}

// Obtener los usuarios
$sql = "SELECT usuario, nombre_sector, check_respuesta FROM Usuario JOIN Sector ON Usuario.id_sector = Sector.id_sector";
$result = $conn->query($sql);

$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesGestionUsuarios.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Usuarios</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Sector</th>
                            <th>Encuesta Respondida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['usuario']; ?></td>
                            <td><?php echo $usuario['nombre_sector']; ?></td>
                            <td><?php echo $usuario['check_respuesta'] ? 'Sí' : 'No'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h2>Crear Nuevo Usuario</h2>
                <form id="crearUsuarioForm">
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        <select id="sector" class="form-control" name="sector">
                            <?php foreach ($sectores as $sector): ?>
                            <option value="<?php echo $sector['id_sector']; ?>"><?php echo $sector['nombre_sector']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="adminCheck">
                        <label class="form-check-label" for="adminCheck">Crear como Administrador</label>
                    </div>
                    <button type="button" class="btn btn-primary" id="crearUsuarioBtn">Crear</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usuarioModalLabel">Credenciales del Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="credencialesTextArea" class="form-control" readonly></textarea>
                    <button class="btn btn-primary mt-2" id="copiarCredenciales">Copiar Credenciales</button>
                    <div id="copiadoAlert" class="alert alert-success mt-2" role="alert" style="display: none;">
                        Credenciales copiadas al portapapeles.
                    </div>
                    <p class="mt-2">Comparta estas credenciales con el usuario encuestado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#adminCheck').change(function() {
                $('#sector').prop('disabled', this.checked);
            });

            $('#crearUsuarioBtn').click(function(event) {
                event.preventDefault(); // Prevenir el envío del formulario

                var sectorId = $('#sector').val();
                var isAdmin = $('#adminCheck').is(':checked');

                var password = Math.random().toString(36).slice(-12);

                // Obtener nombre de usuario aleatorio desde la API
                $.get('https://usernameapiv1.vercel.app/api/random-usernames', function(data) {
                    var username = data.usernames[0];

                    if (username) {
                        var sector = isAdmin ? 'admon' : sectorId;
                        $.post('../../includes/crear_usuario.php', {
                            username: username,
                            password: password,
                            sector: sector
                        }, function(response) {
                            if (response.success) {
                                // Actualizar el contenido del textarea con las credenciales
                                var credenciales = 'Encuesta para la adopción de energía renovable en México.\n\nLe agradecería que contestase nuestra encuesta.\n\nUsuario: ' + username + '\nContraseña: ' + password + '\n\nGracias.';
                                $('#credencialesTextArea').val(credenciales);
                                $('#usuarioModal').modal('show');
                            } else {
                                alert('Error al crear el usuario.');
                            }
                        }, 'json');
                    } else {
                        alert('Error al obtener el nombre de usuario desde la API.');
                    }
                }).fail(function() {
                    alert('Error al conectar con la API de generación de nombres de usuario.');
                });
            });

            // Copiar credenciales al portapapeles
            $('#copiarCredenciales').click(function() {
                var textarea = document.getElementById('credencialesTextArea');
                textarea.select();
                document.execCommand('copy');
                $('#copiadoAlert').fadeIn().delay(2000).fadeOut();
            });

            // Recargar la página al cerrar el modal
            $('#usuarioModal').on('hidden.bs.modal', function (e) {
                location.reload();
            });
        });
    </script>
</body>
</html>
