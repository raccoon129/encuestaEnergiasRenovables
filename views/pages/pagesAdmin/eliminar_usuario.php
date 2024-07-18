<?php
include '../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // Comprobar si el usuario ha comenzado la encuesta
    $sql = "SELECT * FROM Encuesta WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'No se puede eliminar este usuario porque ya ha iniciado la encuesta.']);
    } else {
        // Eliminar el usuario
        $sql = "DELETE FROM Usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario.']);
        }
    }
}
?>
