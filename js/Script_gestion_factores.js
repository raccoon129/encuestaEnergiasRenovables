$(document).ready(function() {
    $('.editar-factor').on('click', function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        var contenido = $(this).data('contenido');

        $('#editar_id_factor').val(id);
        $('#editar_nombre_factor').val(nombre);
        $('#editar_contenido_factor').val(contenido);

        $('#editarFactorModal').modal('show');
    });

    $('#editarFactorForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'gestion_factores_sectores_categorias.php',
            type: 'POST',
            data: $(this).serialize() + '&action=update_factor',
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    toastr.success('Factor actualizado correctamente');
                    $('#editarFactorModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // Espera 1.5 segundos antes de recargar la página
                } else {
                    toastr.error(result.message || 'Error al actualizar el factor');
                }
            },
            error: function() {
                toastr.error('Error en la comunicación con el servidor');
            }
        });
    });
});