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
                        var credenciales = 'Encuesta para evaluar las barreras de la adopción de energía renovable en México.\n\nCredenciales para iniciar sesión y responder la encuesta: \n\nUsuario: ' + username + '\nContraseña: ' + password + '\n\nGracias.';
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
                    toastr.error('Error al eliminar el usuario: ' + response.message);
                }
            }, 'json');
        }
    });
});
