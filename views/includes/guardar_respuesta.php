<?php
session_start();
include '../../db.php';

// Obtener los datos del formulario
$id_factor_1 = $_POST['id_factor_1'];
$id_factor_2 = $_POST['id_factor_2'];
$porcentaje1 = $_POST['porcentaje1'];
$porcentaje2 = $_POST['porcentaje2'];
$id_categoria = $_POST['id_categoria'];
$id_usuario = $_SESSION['id_usuario'];

// Determinar el factor dominante y su porcentaje
if ($porcentaje1 > 0) {
    $factor_dominante = $id_factor_1;
    $porcentaje_incidencia = $porcentaje1;
} else {
    $factor_dominante = $id_factor_2;
    $porcentaje_incidencia = $porcentaje2;
}

// Obtener el id_encuesta del usuario actual
$sql_encuesta = "SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario";
$result_encuesta = $conn->query($sql_encuesta);
$row_encuesta = $result_encuesta->fetch_assoc();
$id_encuesta = $row_encuesta['id_encuesta'];

// Guardar la respuesta
$sql = "INSERT INTO Respuesta (id_encuesta, id_factor_1, id_factor_2, porcentaje_incidencia, factor_dominante) 
        VALUES ($id_encuesta, $id_factor_1, $id_factor_2, $porcentaje_incidencia, '$factor_dominante')
        ON DUPLICATE KEY UPDATE 
        porcentaje_incidencia = $porcentaje_incidencia, 
        factor_dominante = '$factor_dominante'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>