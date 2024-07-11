<?php
include '../../db.php';

//Esta es una funcionalidad que se utiliza en gestion_usuarios.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sectorId = $_POST['sector'];

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO Usuario (usuario, password, id_sector) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $password, $sectorId);

    if ($stmt->execute()) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    // Devolver respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Método no permitido
    http_response_code(405); // Método no permitido
    echo json_encode(['error' => 'Método no permitido']);
}
?>
