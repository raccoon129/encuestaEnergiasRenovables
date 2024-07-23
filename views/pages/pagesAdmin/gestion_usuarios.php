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
                <h2>Gestión de Usuarios</h2>
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
                                <td><?php echo $usuario['nombre_sector'] === 'admon' ? 'Administrador' : ($usuario['ha_iniciado'] > 0 ? 'Sí' : 'No'); ?></td>
                                <td>
                                    <?php if ($usuario['ha_iniciado'] == 0) : ?>
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
                <div class="alert alert-info" role="alert">
                    Los nombres de usuario son generados por un algoritmo externo de forma aleatoria.
                </div>
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
                    <br>
                    <div id="copiadoAlert" class="alert alert-success mt-2" role="alert" style="display: none;">
                        Credenciales copiadas al portapapeles.
                    </div>
                    <br>
                    <div class="alert alert-primary" role="alert">
                        Comparta estas credenciales con el destinatario. Solo aparecerán una única vez.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/Script_gestion_usuarios.js"></script>
</body>

</html>