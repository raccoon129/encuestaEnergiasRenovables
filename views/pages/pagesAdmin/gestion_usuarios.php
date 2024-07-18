<?php
include '../../../db.php';
include '../../includes/session_check.php';
// Permitir acceso solo a administradores
check_access(['admon']);

// Obtener los sectores, excluyendo el sector 'admon'
$sql = "SELECT id_sector, nombre_sector FROM Sector WHERE nombre_sector != 'admon'";
$result = $conn->query($sql);

$sectores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sectores[] = $row;
    }
}

// Obtener los usuarios, ordenados de forma descendente por ID
$sql = "SELECT Usuario.id_usuario, usuario, nombre_sector, 
               (SELECT COUNT(*) FROM Respuesta 
                JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta 
                WHERE Encuesta.id_usuario = Usuario.id_usuario) AS ha_iniciado 
        FROM Usuario 
        JOIN Sector ON Usuario.id_sector = Sector.id_sector 
        ORDER BY Usuario.id_usuario DESC";
$result = $conn->query($sql);

$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-8">
                <h2>Usuarios</h2>
                <table id="usuariosTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Sector</th>
                            <th>Encuesta Respondida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo $usuario['usuario']; ?></td>
                            <td><?php echo $usuario['nombre_sector']; ?></td>
                            <td><?php echo $usuario['nombre_sector'] === 'admon' ? 'Administrador' : 'No'; ?></td>
                            <td>
                                <?php if ($usuario['nombre_sector'] === 'admon' && $usuario['ha_iniciado'] == 0) : ?>
                                <button class="btn btn-danger btn-sm eliminar-usuario" data-id="<?php echo $usuario['id_usuario']; ?>">Eliminar</button>
                                <?php else : ?>
                                <button class="btn btn-secondary btn-sm" disabled>Eliminar</button>
                                <?php endif; ?>
                            </td>
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
                        <select id="sector" class="form-control" name="sector" disabled>
                            <?php foreach ($sectores as $sector) : ?>
                            <option value="<?php echo $sector['id_sector']; ?>"><?php echo $sector['nombre_sector']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipoUsuario">Tipo de Usuario:</label>
                        <div id="tipoUsuario">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioNormal" value="normal">
                                <label class="form-check-label" for="usuarioNormal">Encuestado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoUsuario" id="usuarioAdmin" value="admin" checked>
                                <label class="form-check-label" for="usuarioAdmin">Administrador</label>
                            </div>
                        </div>
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
            // Inicializar DataTable
            $('#usuariosTable').DataTable();

            // Habilitar/deshabilitar el selector de sector según el tipo de usuario seleccionado
            $('input[name="tipoUsuario"]').change(function() {
                if ($('#usuarioAdmin').is(':checked')) {
                    $('#sector').prop('disabled', true);
                } else {
                    $('#sector').prop('disabled', false);
                }
            });

            // Crear nuevo usuario
            $('#crearUsuarioBtn').click(function(event) {
                event.preventDefault(); // Prevenir el envío del formulario

                var sectorId = $('#sector').val();
                var tipoUsuario = $('input[name="tipoUsuario"]:checked').val();
                var isAdmin = (tipoUsuario === 'admin');

                // Generar contraseña aleatoria
                var password = Math.random().toString(36).slice(-12);

                // Obtener nombre de usuario aleatorio desde la API
                $.get('https://usernameapiv1.vercel.app/api/random-usernames', function(data) {
                    var username = data.usernames[0];

                    if (username) {
                        var sector = isAdmin ? 'admon' : sectorId;
                        console.log({
                            username: username,
                            password: password,
                            sector: sector
                        }); // Agrega esto para depurar
                        $.post('crear_usuario.php', {
                            username: username,
                            password: password,
                            sector: sector
                        }, function(response) {
                            console.log(response); // Agrega esto para depurar
                            if (response.success) {
                                // Actualizar el contenido del textarea con las credenciales
                                var credenciales = 'Encuesta para la adopción de energía renovable en México.\n\nLe agradecería que contestase nuestra encuesta.\n\nUsuario: ' + username + '\nContraseña: ' + password + '\n\nGracias.';
                                $('#credencialesTextArea').val(credenciales);
                                $('#usuarioModal').modal('show');
                                toastr.success('Usuario creado con éxito.');
                            } else {
                                toastr.error('Error al crear el usuario: ' + response.message);
                            }
                        }, 'json');
                    } else {
                        toastr.error('Error al obtener el nombre de usuario desde la API.');
                    }
                }).fail(function() {
                    toastr.error('Error al conectar con la API de generación de nombres de usuario.');
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
            $('#usuarioModal').on('hidden.bs.modal', function(e) {
                location.reload();
            });

            // Eliminar usuario si no ha iniciado la encuesta
            $('.eliminar-usuario').click(function() {
                var userId = $(this).data('id');

                if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    $.post('eliminar_usuario.php', {
                        user_id: userId
                    }, function(response) {
                        if (response.success) {
                            toastr.success('Usuario eliminado con éxito.');
                            location.reload();
                        } else {
                            toastr.error('Error al eliminar el usuario.');
                        }
                    }, 'json');
                }
            });
        });
    </script>
</body>

</html>
