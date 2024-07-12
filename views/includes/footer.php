<?php
//session_start();
$id_usuario = $_SESSION['id_usuario'];
$sql_progreso = "SELECT COUNT(*) AS respuestas_contestadas FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario)";
$result_progreso = $conn->query($sql_progreso);
$row_progreso = $result_progreso->fetch_assoc();
$respuestas_contestadas = $row_progreso['respuestas_contestadas'];
$total_respuestas = 17 * 17; // 17 categorías y 17 pares por categoría
$progreso = ($respuestas_contestadas / $total_respuestas) * 100;
?>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">Progreso: <?php echo round($progreso, 2); ?>%</span>
    </div>
</footer>
