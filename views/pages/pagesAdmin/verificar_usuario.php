<?php
include '../../../db.php';
//ARCHIVO DE FUNCIONALIDAD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // Comprobar si el usuario ha comenzado la encuesta
    $sql = "SELECT * FROM Encuesta WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'can_delete' => false]);
    } else {
        echo json_encode(['success' => true, 'can_delete' => true]);
    }
}
?>
