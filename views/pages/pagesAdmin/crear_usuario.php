<?php
include '../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sector = $_POST['sector'];

    // Comprobar si el usuario ya existe
    $sql = "SELECT * FROM Usuario WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'El usuario ya existe.']);
    } else {
        // Insertar el nuevo usuario
        $sql = "INSERT INTO Usuario (usuario, password, id_sector) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $username, $password, $sector);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el usuario.']);
        }
    }
}
?>
