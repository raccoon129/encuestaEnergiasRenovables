<?php
include '../../includes/session_check.php';
// Permitir acceso solo a administradores
check_access(['admon']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Inicio Panel</title>
</head>

<body>
    <div class="main-content">
        <div class="container">
            <h1>Panel Administrativo</h1>
            <br>
            <h5>Gestionar encuestas:</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestión de Usuarios</h5>
                            <p class="card-text">Añadir, editar o eliminar usuarios del sistema.</p>
                            <a href="gestion_usuarios.php" class="btn btn-primary">Gestionar Usuarios</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ver Resultados</h5>
                            <p class="card-text">Visualizar y analizar los resultados de las encuestas.</p>
                            <a href="ver_resultados.php" class="btn btn-primary">Ver Resultados</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Responder Encuesta</h5>
                            <p class="card-text">Responda la encuesta como administrador si es requerido.</p>
                            <a onclick="window.open('../../encuesta.php', '_blank')" class="btn btn-success">Ir a la Encuesta</a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <h5>Gestionar detalles:</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Modificar Factores</h5>
                            <p class="card-text">Añadir, editar o eliminar usuarios del sistema.</p>
                            <a href="gestion_factores.php" class="btn btn-info">Realizar Modificaciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Actualizar Sectores</h5>
                            <p class="card-text">Visualizar y analizar los resultados de las encuestas.</p>
                            <a href="gestion_sectores.php" class="btn btn-info">Actualizar Datos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cambiar Categorías</h5>
                            <p class="card-text">Visualizar y analizar los resultados de las encuestas.</p>
                            <a href="gestion_categorias.php" class="btn btn-info">Realizar Cambios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>