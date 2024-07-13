<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta - Energía Renovable</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/stylesEncuesta.css">
</head>
<body class="d-flex flex-column h-100">

<?php include 'includes/header.php'; ?>

<div class="container-fluid encuesta-container d-flex flex-column h-100">
    <div class="row flex-grow-1">
        <div class="col">
            <div class="embed-responsive embed-responsive-16by9 h-100">
                <iframe id="encuestaFrame" class="embed-responsive-item h-100" src="pages/introduccion.php"></iframe>
            </div>
        </div>
    </div>
</div>

<?php //include 'includes/footer.php'; ?>

</body>
</html>
