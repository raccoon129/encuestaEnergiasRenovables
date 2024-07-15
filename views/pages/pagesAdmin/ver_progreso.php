<?php
include '../../../db.php';

$id_usuario = $_GET['id_usuario'];

// Obtener el ID del usuario desde los parámetros GET
$id_usuario = $_GET['id_usuario'];

// Consultar todas las categorías existentes en la base de datos
$sql_categorias = "SELECT * FROM Categoría";
$result_categorias = $conn->query($sql_categorias);

// Verificar si hay categorías
if ($result_categorias->num_rows > 0) {
    // Iniciar la estructura HTML de la página
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Progreso de la Encuesta</title>
        <style>
            body {
                text-align: center; /* Centrar el contenido del cuerpo */
            }
            table {
                margin: 0 auto; /* Centrar las tablas */
                border-collapse: collapse; /* Colapsar los bordes de las celdas */
            }
            th, td {
                padding: 8px 12px; /* Espaciado interno de las celdas */
                border: 1px solid black; /* Borde de las celdas */
            }
            h4 {
                text-align: center; /* Centrar los encabezados */
            }
        </style>
    </head>
    <body>";

    // Iterar a través de todas las categorías para crear una tabla para cada una
    while ($categoria = $result_categorias->fetch_assoc()) {
        // Mostrar el nombre de la categoría
        echo "<h4>" . $categoria['nombre_categoria'] . "</h4>";
        
        // Iniciar la tabla HTML para mostrar las respuestas
        echo "<table>
                <tr>
                    <th>Factor</th>
                    <th>Porcentaje Factor 1</th>
                    <th>Porcentaje Factor 2</th>
                    <th>Factor</th>
                </tr>";

        // Consultar todas las respuestas para el usuario y la categoría actual
        $sql_respuestas = "SELECT Factor1.nombre_factor AS factor1, Factor2.nombre_factor AS factor2, Respuesta.factor_dominante, Respuesta.porcentaje_incidencia, Respuesta.id_factor_1, Respuesta.id_factor_2
                           FROM Respuesta
                           JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta
                           JOIN Factor AS Factor1 ON Respuesta.id_factor_1 = Factor1.id_factor
                           JOIN Factor AS Factor2 ON Respuesta.id_factor_2 = Factor2.id_factor
                           WHERE Encuesta.id_usuario = $id_usuario AND Encuesta.id_categoria = " . $categoria['id_categoria'];
        $result_respuestas = $conn->query($sql_respuestas);

        // Verificar si hay respuestas para la categoría actual
        if ($result_respuestas->num_rows > 0) {
            // Iterar a través de todas las respuestas
            while ($respuesta = $result_respuestas->fetch_assoc()) {
                // Determinar los valores de porcentaje para cada factor y truncar a enteros
                // Si el factor dominante es el factor 1, el porcentaje para el factor 1 será el valor de porcentaje_incidencia y el factor 2 será 0
                // Si el factor dominante es el factor 2, el porcentaje para el factor 2 será el valor de porcentaje_incidencia y el factor 1 será 0
                $porcentaje_factor1 = $respuesta['factor_dominante'] == $respuesta['id_factor_1'] ? floor($respuesta['porcentaje_incidencia']) : 0;
                $porcentaje_factor2 = $respuesta['factor_dominante'] == $respuesta['id_factor_2'] ? floor($respuesta['porcentaje_incidencia']) : 0;

                // Mostrar los datos de la respuesta en una fila de la tabla
                echo "<tr>
                        <td>" . $respuesta['factor1'] . "</td>
                        <td>" . $porcentaje_factor1 . "</td>
                        <td>" . $porcentaje_factor2 . "</td>
                        <td>" . $respuesta['factor2'] . "</td>
                      </tr>";
            }
        } else {
            // Si no hay respuestas para la categoría actual, mostrar un mensaje indicativo
            echo "<tr><td colspan='4'>No hay respuestas para esta categoría.</td></tr>";
        }

        // Cerrar la tabla HTML
        echo "</table><br>";
    }

    // Añadir un botón para imprimir la página
    echo "<button onclick='window.print()'>Imprimir</button>";
    
    // Cerrar la estructura HTML de la página
    echo "</body></html>";
}
?>