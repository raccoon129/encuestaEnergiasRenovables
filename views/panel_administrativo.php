<?php
session_start();
//require 'includes/session_check.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Encuesta Energías Renovables</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesPanel_Administrativo.css">
</head>

<body>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            Encuesta Energías Renovables - Administrador
        </a>
        <form class="form-inline">
            <a href="includes/logout.php" class="btn btn-danger my-2 my-sm-0">Cerrar Sesión</a>
        </form>
    </nav>

    <div class="sidebar">
        <a href="#inicio" onclick="loadPage('pages/inicioPanelAdministrativo.php')"><i class="fas fa-home"></i> Inicio</a>
        <a href="#gestionUsuarios" onclick="loadPage('pages/gestion_usuarios.php')"><i class="fas fa-users"></i> Gestión de Usuarios</a>
        <a href="#verResultados" onclick="loadPage('pages/ver_resultados.php')"><i class="fas fa-chart-bar"></i> Ver Resultados</a>
    </div>

    <div class="main-content">
        <iframe id="mainFrame" src="pages/inicioPanelAdministrativo.php"></iframe>
    </div>

    <script>
        function loadPage(page) {
            document.getElementById('mainFrame').src = page;
        }
    </script>

</body>

</html>