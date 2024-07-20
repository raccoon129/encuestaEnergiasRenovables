
    $(document).ready(function() {
        $('.editar-sector').on('click', function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');

            $('#editar_id_sector').val(id);
            $('#editar_nombre_sector').val(nombre);

            $('#editarSectorModal').modal('show');
        });

        $('#editarSectorForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'gestion_factores_sectores_categorias.php',
                type: 'POST',
                data: $(this).serialize() + '&action=update_sector',
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        toastr.success('Sector actualizado correctamente');
                        $('#editarSectorModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(result.message || 'Error al actualizar el sector');
                    }
                },
                error: function(jqXHR) {
                    toastr.error(jqXHR.responseText || 'Error en la comunicación con el servidor');
                }
            });
        });

        $('#agregarSectorForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'gestion_factores_sectores_categorias.php',
                type: 'POST',
                data: $(this).serialize() + '&action=add_sector',
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        toastr.success('Sector agregado correctamente');
                        $('#agregarSectorModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(result.message || 'Error al agregar el sector');
                    }
                },
                error: function(jqXHR) {
                    toastr.error(jqXHR.responseText || 'Error en la comunicación con el servidor');
                }
            });
        });

        $('.eliminar-sector').on('click', function() {
            var id = $(this).data('id');

            if (confirm('¿Estás seguro de que deseas eliminar este sector?')) {
                $.ajax({
                    url: 'gestion_factores_sectores_categorias.php',
                    type: 'POST',
                    data: { id_sector: id, action: 'delete_sector' },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            toastr.success('Sector eliminado correctamente');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(result.message || 'Error al eliminar el sector');
                        }
                    },
                    error: function(jqXHR) {
                        toastr.error(jqXHR.responseText || 'Error en la comunicación con el servidor');
                    }
                });
            }
        });
    });
