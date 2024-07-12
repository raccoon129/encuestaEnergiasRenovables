<?php
include '../../../db.php'; // Incluye tu archivo de conexión a la base de datos

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Consulta para obtener el progreso de la encuesta del usuario
    $sql = "SELECT Factor.nombre_factor, Respuesta.factor_dominante, Respuesta.porcentaje_incidencia
            FROM Respuesta
            JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta
            JOIN Factor ON Respuesta.id_factor_1 = Factor.id_factor OR Respuesta.id_factor_2 = Factor.id_factor
            WHERE Encuesta.id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Factor</th><th>Factor Dominante</th><th>Porcentaje de Incidencia</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['nombre_factor'] . '</td>';
            echo '<td>' . $row['factor_dominante'] . '</td>';
            echo '<td>' . $row['porcentaje_incidencia'] . '%</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No hay respuestas registradas para este usuario.</p>';
    }

    $stmt->close();
}
?>

