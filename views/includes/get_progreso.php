<?php
session_start();
include '../../db.php';

$id_usuario = $_SESSION['id_usuario'];
$sql_progreso = "SELECT COUNT(*) AS respuestas_contestadas FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario)";
$result_progreso = $conn->query($sql_progreso);
$row_progreso = $result_progreso->fetch_assoc();
$respuestas_contestadas = $row_progreso['respuestas_contestadas'];
$total_respuestas = 18 * 8.5; // 17 categorías y 17 pares por categoría
$progreso = ($respuestas_contestadas / $total_respuestas) * 100;

echo json_encode(['progreso' => round($progreso, 2)]);
?>
