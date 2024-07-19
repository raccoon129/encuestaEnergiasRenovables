<?php
include '../../../db.php';
include '../../includes/session_check.php';
// Permitir acceso solo a administradores
check_access(['admon']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // Verificar si el usuario ha respondido la encuesta
    $sql_check = "SELECT COUNT(*) AS count FROM Respuesta 
                  JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta 
                  WHERE Encuesta.id_usuario = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        // Eliminar usuario si no ha respondido la encuesta
        $sql_delete = "DELETE FROM Usuario WHERE id_usuario = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $userId);
        if ($stmt_delete->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No se puede eliminar el usuario porque ha respondido la encuesta.']);
    }
}
?>
