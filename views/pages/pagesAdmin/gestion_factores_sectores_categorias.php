<?php
include '../../../db.php';
//ARCHIVO DE FUNCIONALIDADES
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'update_factor':
            $id_factor = $_POST['id_factor'];
            $nombre_factor = $_POST['nombre_factor'];
            $contenido_factor = $_POST['contenido_factor'];

            $sql = "UPDATE Factor SET nombre_factor = ?, contenido_factor = ? WHERE id_factor = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssi', $nombre_factor, $contenido_factor, $id_factor);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
            $stmt->close();
            break;

        case 'update_sector':
            $id_sector = $_POST['id_sector'];
            $nombre_sector = $_POST['nombre_sector'];

            $sql = "UPDATE Sector SET nombre_sector = ? WHERE id_sector = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $nombre_sector, $id_sector);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
            $stmt->close();
            break;

        case 'add_sector':
            $nombre_sector = $_POST['nombre_sector'];

            $sql = "INSERT INTO Sector (nombre_sector) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $nombre_sector);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
            $stmt->close();
            break;

        case 'delete_sector':
            $id_sector = $_POST['id_sector'];

            // Verificar si el sector está asignado a algún usuario
            $sql = "SELECT COUNT(*) as count FROM Usuario WHERE id_sector = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id_sector);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] == 0) {
                // Eliminar el sector si no está asignado a ningún usuario
                $sql = "DELETE FROM Sector WHERE id_sector = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $id_sector);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No se puede eliminar el sector porque está asignado a uno o más usuarios.']);
            }
            $stmt->close();
            break;

        case 'update_categoria':
            $id_categoria = $_POST['id_categoria'];
            $nombre_categoria = $_POST['nombre_categoria'];

            $sql = "UPDATE Categoría SET nombre_categoria = ? WHERE id_categoria = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $nombre_categoria, $id_categoria);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
            $stmt->close();
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
            break;
    }
}

$conn->close();
?>
