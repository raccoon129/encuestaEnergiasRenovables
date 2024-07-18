<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['check_respuesta']) || $_SESSION['check_respuesta'] != 1) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Completa - Energías Renovables</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<div class="container">
    <br>
    <h1>Encuesta Completada</h1>
    <p>Su participación ha finalizado. Gracias por contribuir.</p>
    
    <a href="../views/includes/logout.php" class="btn btn-primary">Salir</a>
    
    <div class="text-center">
    <img src="../img/9.png" />
</div>
</div>

</body>
</html>
