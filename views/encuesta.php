<?php
include 'includes/session_check.php';
// Permitir acceso solo a encuestados
//check_access(['Gubernamental', 'Académico', 'Empresa de energía renovable', 'Usuario de la tecnología','Otro']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contestando - Encuesta para evaluar las barreras de la adopción de energía renovable en México</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesEncuesta.css">

    </style>
</head>

<body class="d-flex flex-column h-100" scrolling="no"> <!-- evita que haya una barra de desplazamiento en la página principal -->

    <?php include 'includes/header.php'; ?>

    <div class="container-fluid encuesta-container d-flex flex-column h-100">
        <div class="row flex-grow-1">
            <div class="col">
                <iframe src="pages/introduccion.php" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>