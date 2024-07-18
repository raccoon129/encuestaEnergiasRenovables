<?php
include '../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sector = $_POST['sector'];

    // Registra los datos recibidos para depuración
    error_log("Datos recibidos: username=$username, sector=$sector");

    // Si el sector es "admon", obtenemos su id_sector
    if ($sector === 'admon') {
        $sql = "SELECT id_sector FROM Sector WHERE nombre_sector = 'admon'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sector = $row['id_sector'];
        } else {
            echo json_encode(['success' => false, 'message' => 'El sector "admon" no existe.']);
            exit();
        }
    }

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

        // Verifica la consulta SQL
        if ($stmt === false) {
            error_log("Error al preparar la consulta: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
        } else {
            $stmt->bind_param('ssi', $username, $password, $sector);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                error_log("Error al ejecutar la consulta: " . $stmt->error);
                echo json_encode(['success' => false, 'message' => 'Error al crear el usuario: ' . $stmt->error]);
            }
        }
    }
}
?>
