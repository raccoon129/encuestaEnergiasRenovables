<?php
// guardar_respuesta.php
include '../../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_factor_1 = $_POST['id_factor_1'];
    $id_factor_2 = $_POST['id_factor_2'];
    $porcentaje1 = $_POST['porcentaje1'];
    $porcentaje2 = $_POST['porcentaje2'];
    $id_categoria = $_POST['id_categoria'];

    // Determinar el factor dominante
    if ($porcentaje1 > $porcentaje2) {
        $factor_dominante = $id_factor_1;
        $porcentaje_incidencia = $porcentaje1;
    } else {
        $factor_dominante = $id_factor_2;
        $porcentaje_incidencia = $porcentaje2;
    }

    // Obtener el id de la encuesta
    $id_usuario = $_SESSION['id_usuario'];

    // Comprobar si ya existe una encuesta para este usuario y categoría
    $sql = "SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario AND id_categoria = $id_categoria";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si ya existe, obtener el id_encuesta
        $row = $result->fetch_assoc();
        $id_encuesta = $row['id_encuesta'];
    } else {
        // Si no existe, crear una nueva encuesta
        $sql = "INSERT INTO Encuesta (id_usuario, id_categoria) VALUES ($id_usuario, $id_categoria)";
        if ($conn->query($sql) === TRUE) {
            $id_encuesta = $conn->insert_id;
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear la encuesta: " . $conn->error]);
            $conn->close();
            exit();
        }
    }

    // Insertar la respuesta
    $sql = "INSERT INTO Respuesta (id_encuesta, id_factor_1, id_factor_2, factor_dominante, porcentaje_incidencia)
            VALUES ($id_encuesta, $id_factor_1, $id_factor_2, $factor_dominante, $porcentaje_incidencia)";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al guardar la respuesta: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no permitido"]);
}
$conn->close();
?>
