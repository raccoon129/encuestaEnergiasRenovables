<?php
//session_start();
include 'includes/session_check.php';
// Permitir acceso solo a administradores
check_access(['admon']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Encuesta para evaluar las barreras de la adopción de energía renovable en México</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesPanel_Administrativo.css">
</head>

<body>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            Encuesta para evaluar las barreras de la adopción de energía renovable en México - Administrador
        </a>
        <form class="form-inline">
            <a href="includes/logout.php" class="btn btn-danger my-2 my-sm-0">Cerrar Sesión</a>
        </form>
    </nav>

    <div class="sidebar">
        <a href="#inicio" onclick="loadPage('pages/pagesAdmin/inicioPanelAdministrativo.php')"><i class="fas fa-home"></i> Inicio</a>
        <a href="#gestionUsuarios" onclick="loadPage('pages/pagesAdmin/gestion_usuarios.php')"><i class="fas fa-users"></i> Gestión de Usuarios</a>
        <a href="#verResultados" onclick="loadPage('pages/pagesAdmin/ver_resultados.php')"><i class="fas fa-chart-bar"></i> Ver Resultados</a>
        <a href="#verResultados" onclick="loadPage('pages/pagesAdmin/gestion_factores.php')"><i class="fas fa-window-maximize"></i> Modificar Factores</a>
        <a href="#verResultados" onclick="loadPage('pages/pagesAdmin/gestion_sectores.php')"><i class="fas fa-address-card"></i> Actualizar Sectores</a>
        <a href="#verResultados" onclick="loadPage('pages/pagesAdmin/gestion_categorias.php')"><i class="fas fa-crosshairs"></i> Cambiar Categorías</a>
    </div>

    <div class="main-content">
        <iframe id="mainFrame" src="pages/pagesAdmin/inicioPanelAdministrativo.php"></iframe>
    </div>

    <script>
        function loadPage(page) {
            document.getElementById('mainFrame').src = page;
        }
    </script>

</body>

</html>