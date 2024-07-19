<?php
include '../../../db.php';
include '../../includes/session_check.php';
check_access(['admon']);

// Obtener todas las categorías
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container mt-2">
        <h2>Gestión de Categorías</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) : ?>
                    <tr>
                        <td><?php echo $categoria['id_categoria']; ?></td>
                        <td><?php echo $categoria['nombre_categoria']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editar-categoria" data-id="<?php echo $categoria['id_categoria']; ?>">Editar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevaCategoriaModal">Nueva Categoría</button>
    </div>

    <!-- Modal Nueva Categoría -->
    <div class="modal fade" id="nuevaCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCategoriaModalLabel">Nueva Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="nuevaCategoriaForm">
                        <div class="form-group">
                            <label for="nombre_categoria">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/Script_gestion_categorias.js"></script>
</body>

</html>
