<?php
include '../../../db.php';

// Obtener las categorías existentes
$sql = "SELECT * FROM Categoría";
$result = $conn->query($sql);
$categorias = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container mt-2">
        <h2>Cambiar Categorías</h2>
        <div class="alert alert-warning" role="alert">
            Solo puede modificar el nombre de las categorías disponibles previamente establecidos en esta solución.
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria['id_categoria']; ?></td>
                    <td><?php echo $categoria['nombre_categoria']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm editar-categoria" data-id="<?php echo $categoria['id_categoria']; ?>" data-nombre="<?php echo $categoria['nombre_categoria']; ?>">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para editar categoría -->
    <div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editarCategoriaForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editar_id_categoria" name="id_categoria">
                        <div class="mb-3">
                            <label for="editar_nombre_categoria" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="editar_nombre_categoria" name="nombre_categoria" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="../../../js/Script_gestion_categorias.js"></script>
</body>
</html>
