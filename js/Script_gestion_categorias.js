$(document).ready(function() {
    $('.editar-categoria').on('click', function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');

        $('#editar_id_categoria').val(id);
        $('#editar_nombre_categoria').val(nombre);

        $('#editarCategoriaModal').modal('show');
    });

    $('#editarCategoriaForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'gestion_factores_sectores_categorias.php',
            type: 'POST',
            data: $(this).serialize() + '&action=update_categoria',
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    toastr.success('Categoría actualizada correctamente');
                    $('#editarCategoriaModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(result.message || 'Error al actualizar la categoría');
                }
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseText || 'Error en la comunicación con el servidor');
            }
        });
    });
});