<?php
include '../../../db.php';
include '../../includes/session_check.php';
check_access(['admon']);

// Obtener todos los sectores
$sql = "SELECT * FROM Sector";
$result = $conn->query($sql);

$sectores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sectores[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sectores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="../../../styles/stylesCategoriasEncuesta.css">
</head>

<body>
    <div class="container mt-2">
        <h2>Actualizar Sectores</h2>
        <div class="alert alert-info" role="alert">
            Añada o elimine sectores a los cuales se tendrán como selección al momento de generar cuentas para encuestados.
        </div>
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#agregarSectorModal">Agregar Sector</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Sector</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sectores as $sector) : ?>
                    <?php if ($sector['nombre_sector'] !== 'admon') : ?>
                        <tr>
                            <td><?php echo $sector['id_sector']; ?></td>
                            <td><?php echo $sector['nombre_sector']; ?></td>
                            <td>
                                <button class="btn btn-info btn-sm editar-sector" data-id="<?php echo $sector['id_sector']; ?>" data-nombre="<?php echo $sector['nombre_sector']; ?>">Editar</button>
                                <button class="btn btn-danger btn-sm eliminar-sector" data-id="<?php echo $sector['id_sector']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Editar Sector -->
    <div class="modal fade" id="editarSectorModal" tabindex="-1" role="dialog" aria-labelledby="editarSectorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarSectorModalLabel">Editar Sector</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarSectorForm">
                        <input type="hidden" id="editar_id_sector" name="id_sector">
                        <div class="form-group">
                            <label for="editar_nombre_sector">Nombre del Sector</label>
                            <input type="text" class="form-control" id="editar_nombre_sector" name="nombre_sector" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Sector -->
    <div class="modal fade" id="agregarSectorModal" tabindex="-1" role="dialog" aria-labelledby="agregarSectorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarSectorModalLabel">Agregar Sector</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agregarSectorForm">
                        <div class="form-group">
                            <label for="agregar_nombre_sector">Nombre del Sector</label>
                            <input type="text" class="form-control" id="agregar_nombre_sector" name="nombre_sector" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="../../../js/Script_gestion_sectores.js"></script>
</body>

</html>
