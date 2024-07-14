<?php
include '../../../db.php';

$id_usuario = $_GET['id_usuario'];

// Consultar las categorías
$sql_categorias = "SELECT * FROM Categoría";
$result_categorias = $conn->query($sql_categorias);

if ($result_categorias->num_rows > 0) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Progreso de la Encuesta</title>
        <style>
            body {
                text-align: center;
            }
            table {
                margin: 0 auto;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px 12px;
                border: 1px solid black;
            }
            h4 {
                text-align: center;
            }
        </style>
    </head>
    <body>";

    while ($categoria = $result_categorias->fetch_assoc()) {
        echo "<h4>" . $categoria['nombre_categoria'] . "</h4>";
        echo "<table>
                <tr>
                    <th>Factor</th>
                    <th>Porcentaje Factor 1</th>
                    <th>Porcentaje Factor 2</th>
                    <th>Factor 2</th>
                </tr>";

        $sql_respuestas = "SELECT Factor1.nombre_factor AS factor1, Factor2.nombre_factor AS factor2, Respuesta.factor_dominante, Respuesta.porcentaje_incidencia, Respuesta.id_factor_1, Respuesta.id_factor_2
                           FROM Respuesta
                           JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta
                           JOIN Factor AS Factor1 ON Respuesta.id_factor_1 = Factor1.id_factor
                           JOIN Factor AS Factor2 ON Respuesta.id_factor_2 = Factor2.id_factor
                           WHERE Encuesta.id_usuario = $id_usuario AND Encuesta.id_categoria = " . $categoria['id_categoria'];
        $result_respuestas = $conn->query($sql_respuestas);

        if ($result_respuestas->num_rows > 0) {
            while ($respuesta = $result_respuestas->fetch_assoc()) {
                // Determinar los valores de porcentaje para cada factor y truncar a enteros
                $porcentaje_factor1 = $respuesta['factor_dominante'] == $respuesta['id_factor_1'] ? floor($respuesta['porcentaje_incidencia']) : 0;
                $porcentaje_factor2 = $respuesta['factor_dominante'] == $respuesta['id_factor_2'] ? floor($respuesta['porcentaje_incidencia']) : 0;
                echo "<tr>
                        <td>" . $respuesta['factor1'] . "</td>
                        <td>" . $porcentaje_factor1 . "</td>
                        <td>" . $porcentaje_factor2 . "</td>
                        <td>" . $respuesta['factor2'] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay respuestas para esta categoría.</td></tr>";
        }

        echo "</table><br>";
    }

    echo "<button onclick='window.print()'>Imprimir</button>";
    echo "</body></html>";
}
?>