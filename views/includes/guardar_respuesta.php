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
        $factor_dominante = 'Factor ' . chr($id_factor_1 + 64); // Convertir id_factor a letra (1 -> A)
        $porcentaje_incidencia = $porcentaje1;
    } else {
        $factor_dominante = 'Factor ' . chr($id_factor_2 + 64); // Convertir id_factor a letra (2 -> B)
        $porcentaje_incidencia = $porcentaje2;
    }

    // Obtener el id de la encuesta
    $id_usuario = $_SESSION['id_usuario'];

    // Insertar o actualizar la encuesta
    $sql = "INSERT INTO Encuesta (id_usuario, id_categoria) VALUES ($id_usuario, $id_categoria) 
            ON DUPLICATE KEY UPDATE id_encuesta=LAST_INSERT_ID(id_encuesta)";
    if ($conn->query($sql) === TRUE) {
        $id_encuesta = $conn->insert_id;

        // Insertar la respuesta
        $sql = "INSERT INTO Respuesta (id_encuesta, id_factor_1, id_factor_2, factor_dominante, porcentaje_incidencia)
                VALUES ($id_encuesta, $id_factor_1, $id_factor_2, '$factor_dominante', $porcentaje_incidencia)";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al guardar la respuesta: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al crear la encuesta: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no permitido"]);
}
$conn->close();
?>
