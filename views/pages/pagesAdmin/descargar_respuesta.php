<?php
require '../../../vendor/autoload.php'; // Ajusta la ruta según tu estructura de proyecto
include '../../../db.php';
include '../../includes/session_check.php';

// Permitir acceso solo a administradores
check_access(['admon']);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

$id_usuario = $_GET['id_usuario'];

// Ruta de la plantilla de Excel
$templatePath = '../../../files/PlantillaResultados.xlsx';

// Cargar la plantilla de Excel
$spreadsheet = IOFactory::load($templatePath);
$sheet = $spreadsheet->getActiveSheet();

// Consultar todas las categorías existentes en la base de datos
$sql_categorias = "SELECT * FROM Categoría";
$result_categorias = $conn->query($sql_categorias);

// Mapear las columnas iniciales para cada categoría
$columnStartMap = ['B', 'G', 'L', 'Q', 'V', 'AA'];

if ($result_categorias->num_rows > 0) {
    $categoriaIndex = 0; // Índice de la categoría actual

    while ($categoria = $result_categorias->fetch_assoc()) {
        // Obtener la columna inicial para la categoría actual
        $columnStart = $columnStartMap[$categoriaIndex];
        $rowIndex = 3; // Comenzar desde la fila 3 para cada categoría

        // Consultar todas las respuestas para el usuario y la categoría actual
        $sql_respuestas = "SELECT Factor1.nombre_factor AS factor1, Factor2.nombre_factor AS factor2, Respuesta.factor_dominante, Respuesta.porcentaje_incidencia, Respuesta.id_factor_1, Respuesta.id_factor_2
                           FROM Respuesta
                           JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta
                           JOIN Factor AS Factor1 ON Respuesta.id_factor_1 = Factor1.id_factor
                           JOIN Factor AS Factor2 ON Respuesta.id_factor_2 = Factor2.id_factor
                           WHERE Encuesta.id_usuario = $id_usuario AND Encuesta.id_categoria = " . $categoria['id_categoria'] . "
                           ORDER BY Respuesta.id_factor_1 DESC, Respuesta.id_factor_2 ASC";
        $result_respuestas = $conn->query($sql_respuestas);

        if ($result_respuestas->num_rows > 0) {
            while ($respuesta = $result_respuestas->fetch_assoc()) {
                $porcentaje_factor1 = $respuesta['factor_dominante'] == $respuesta['id_factor_1'] ? floor($respuesta['porcentaje_incidencia']) : 0;
                $porcentaje_factor2 = $respuesta['factor_dominante'] == $respuesta['id_factor_2'] ? floor($respuesta['porcentaje_incidencia']) : 0;

                // Eliminar la palabra "FACTOR" de los nombres de los factores
                $factor1 = str_replace('FACTOR', '', $respuesta['factor1']);
                $factor2 = str_replace('FACTOR', '', $respuesta['factor2']);

                // Insertar los datos en la hoja de Excel
                $sheet->setCellValue("$columnStart$rowIndex", $factor1);
                $sheet->setCellValue(chr(ord($columnStart) + 1) . $rowIndex, $porcentaje_factor1);
                $sheet->setCellValue(chr(ord($columnStart) + 2) . $rowIndex, $porcentaje_factor2);
                $sheet->setCellValue(chr(ord($columnStart) + 3) . $rowIndex, $factor2);

                // Aplicar estilo a las celdas
                $sheet->getStyle("$columnStart$rowIndex:" . chr(ord($columnStart) + 3) . "$rowIndex")->getFont()->setSize(12)->getColor()->setARGB(Color::COLOR_BLUE);

                $rowIndex++;
            }
        } else {
            // Si no hay respuestas, insertar un mensaje indicativo en la hoja de Excel
            $sheet->setCellValue("$columnStart$rowIndex", "No hay respuestas para esta categoría.");
            // Aplicar estilo a la celda
            $sheet->getStyle("$columnStart$rowIndex")->getFont()->setSize(12)->getColor()->setARGB(Color::COLOR_BLUE);
        }

        // Incrementar el índice de la categoría
        $categoriaIndex++;

        // Verificar si hay más categorías que columnas especificadas
        if ($categoriaIndex >= count($columnStartMap)) {
            // Aquí puedes decidir qué hacer si hay más categorías que columnas mapeadas
            break;
        }
    }
}

// Crear el archivo Excel y redirigir para descargarlo
$writer = new Xlsx($spreadsheet);
$outputFile = 'respuestas_usuario_' . $id_usuario . '.xlsx';
$writer->save($outputFile);

// Forzar la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . basename($outputFile) . '"');
header('Content-Length: ' . filesize($outputFile));
readfile($outputFile);

// Eliminar el archivo temporal después de la descarga
unlink($outputFile);
exit;
?>
