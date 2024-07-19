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
</head>

<body>
    <div class="container mt-2">
        <h2>Gestión de Sectores</h2>
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
                    <tr>
                        <td><?php echo $sector['id_sector']; ?></td>
                        <td><?php echo $sector['nombre_sector']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editar-sector" data-id="<?php echo $sector['id_sector']; ?>">Editar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoSectorModal">Nuevo Sector</button>
    </div>

    <!-- Modal Nuevo Sector -->
    <div class="modal fade" id="nuevoSectorModal" tabindex="-1" role="dialog" aria-labelledby="nuevoSectorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoSectorModalLabel">Nuevo Sector</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="nuevoSectorForm">
                        <div class="form-group">
                            <label for="nombre_sector">Nombre del Sector</label>
                            <input type="text" class="form-control" id="nombre_sector" name="nombre_sector" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/Script_gestion_sectores.js"></script>
</body>

</html>
