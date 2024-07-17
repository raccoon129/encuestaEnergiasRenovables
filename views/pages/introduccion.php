<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducción - Encuesta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/stylesEncuesta.css">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-info" role="alert">
        La realización de esta encuesta tomará aproximadamente 10 minutos. Por favor, asegúrese de tener suficiente tiempo para completarla sin interrupciones.
    </div>
    <div class="alert alert-info" role="alert">
        Aquí podrían ir más indicaciones.
    </div>
    <div class="alert alert-danger" role="alert">
        La encuesta está optimizada para ser respondida desde un entorno de escritorio (PC)
    </div>
    <a href="categoria1.php" class="btn btn-primary">Comenzar Encuesta</a>
</div>
</body>
</html>
