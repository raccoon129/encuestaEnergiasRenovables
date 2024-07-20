<?php
include '../../../db.php';
include '../../includes/session_check.php';
check_access(['admon']);

// Obtener todos los factores
$sql = "SELECT * FROM Factor";
$result = $conn->query($sql);

$factores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $factores[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Factores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../styles/stylesCategoriasEncuesta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container mt-2">
        <h2>Modificar Factores</h2>
        <div class="alert alert-warning" role="alert">
            Solo puede modificar el contenido de los factores disponibles previamente establecidos en esta solución.
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Factor</th>
                    <th>Contenido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($factores as $factor) : ?>
                    <tr>
                        <td><?php echo $factor['id_factor']; ?></td>
                        <td><?php echo $factor['nombre_factor']; ?></td>
                        <td><?php echo $factor['contenido_factor']; ?></td>
                        <td>
                            <button class="btn btn-info btn-sm editar-factor" data-id="<?php echo $factor['id_factor']; ?>" data-nombre="<?php echo $factor['nombre_factor']; ?>" data-contenido="<?php echo $factor['contenido_factor']; ?>">Editar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Editar Factor -->
    <div class="modal fade" id="editarFactorModal" tabindex="-1" role="dialog" aria-labelledby="editarFactorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarFactorModalLabel">Editar Factor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarFactorForm">
                        <input type="hidden" id="editar_id_factor" name="id_factor">
                        <div class="form-group">
                            <label for="editar_nombre_factor">Nombre del Factor</label>
                            <input type="text" class="form-control" id="editar_nombre_factor" name="nombre_factor" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editar_contenido_factor">Contenido</label>
                            <textarea class="form-control" id="editar_contenido_factor" name="contenido_factor" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="../../../js/Script_gestion_factores.js"></script>
</body>

</html>