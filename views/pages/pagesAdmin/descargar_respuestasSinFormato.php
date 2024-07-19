<?php
//YA FUNCIONA TOTALMENTE
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

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Inicializar la fila de inicio para los datos en la hoja de Excel
$rowIndex = 1;

// Consultar todas las categorías existentes en la base de datos
$sql_categorias = "SELECT * FROM Categoría";
$result_categorias = $conn->query($sql_categorias);

if ($result_categorias->num_rows > 0) {
    while ($categoria = $result_categorias->fetch_assoc()) {
        // Escribir el nombre de la categoría
        $sheet->setCellValue("A$rowIndex", $categoria['nombre_categoria']);
        $sheet->mergeCells("A$rowIndex:D$rowIndex");
        $sheet->getStyle("A$rowIndex")->getFont()->setBold(true)->setSize(14);
        $rowIndex++;

        // Escribir los encabezados de las columnas
        $sheet->setCellValue("A$rowIndex", "Factor");
        $sheet->setCellValue("B$rowIndex", "Porcentaje Factor 1");
        $sheet->setCellValue("C$rowIndex", "Porcentaje Factor 2");
        $sheet->setCellValue("D$rowIndex", "Factor");
        $sheet->getStyle("A$rowIndex:D$rowIndex")->getFont()->setBold(true)->setSize(12);
        $rowIndex++;

        // Consultar todas las respuestas para el usuario y la categoría actual
        $sql_respuestas = "SELECT Factor1.nombre_factor AS factor1, Factor2.nombre_factor AS factor2, Respuesta.factor_dominante, Respuesta.porcentaje_incidencia, Respuesta.id_factor_1, Respuesta.id_factor_2
                           FROM Respuesta
                           JOIN Encuesta ON Respuesta.id_encuesta = Encuesta.id_encuesta
                           JOIN Factor AS Factor1 ON Respuesta.id_factor_1 = Factor1.id_factor
                           JOIN Factor AS Factor2 ON Respuesta.id_factor_2 = Factor2.id_factor
                           WHERE Encuesta.id_usuario = $id_usuario AND Encuesta.id_categoria = " . $categoria['id_categoria'] . "
                           ORDER BY Respuesta.id_factor_1 DESC, Respuesta.id_factor_2 ASC";
        $result_respuestas = $conn->query($sql_respuestas);

        // Verificar si hay respuestas para la categoría actual
        if ($result_respuestas->num_rows > 0) {
            // Iterar a través de todas las respuestas
            while ($respuesta = $result_respuestas->fetch_assoc()) {
                // Determinar los valores de porcentaje para cada factor y truncar a enteros
                $porcentaje_factor1 = $respuesta['factor_dominante'] == $respuesta['id_factor_1'] ? floor($respuesta['porcentaje_incidencia']) : 0;
                $porcentaje_factor2 = $respuesta['factor_dominante'] == $respuesta['id_factor_2'] ? floor($respuesta['porcentaje_incidencia']) : 0;

                // Insertar los datos en la hoja de Excel
                $sheet->setCellValue("A$rowIndex", str_replace('FACTOR', '', $respuesta['factor1']));
                $sheet->setCellValue("B$rowIndex", $porcentaje_factor1);
                $sheet->setCellValue("C$rowIndex", $porcentaje_factor2);
                $sheet->setCellValue("D$rowIndex", str_replace('FACTOR', '', $respuesta['factor2']));
                $sheet->getStyle("A$rowIndex:D$rowIndex")->getFont()->setSize(12);

                $rowIndex++;
            }
        } else {
            // Si no hay respuestas, insertar un mensaje indicativo en la hoja de Excel
            $sheet->setCellValue("A$rowIndex", "No hay respuestas para esta categoría.");
            $sheet->mergeCells("A$rowIndex:D$rowIndex");
            $sheet->getStyle("A$rowIndex")->getFont()->setItalic(true)->setSize(12);
            $rowIndex++;
        }

        // Añadir un espacio entre categorías
        $rowIndex++;
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
