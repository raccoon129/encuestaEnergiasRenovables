<?php
//session_start();
include '../db.php';
$id_usuario = $_SESSION['id_usuario'];
$sql_progreso = "SELECT COUNT(*) AS respuestas_contestadas FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario)";
$result_progreso = $conn->query($sql_progreso);
$row_progreso = $result_progreso->fetch_assoc();
$respuestas_contestadas = $row_progreso['respuestas_contestadas'];
$total_respuestas = 18 * 8.5; // 17 categorías y 17 pares por categoría
$progreso = ($respuestas_contestadas / $total_respuestas) * 100;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Barra de Progreso</title>
</head>
<body>
    <!-- Barra de Progreso -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">Progreso total de la encuesta: <?php echo round($progreso, 2); ?>%</span>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $progreso; ?>%" aria-valuenow="<?php echo $progreso; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
