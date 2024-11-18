<?php 
    require '../vendor/autoload.php';
 
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if (isset($_GET['descargar'])) {
        
        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
                
        $hoja->setCellValue('A1', 'Nombre_Presidenta');
        $hoja->setCellValue('B1', 'DNI_Presidenta');
        $hoja->setCellValue('C1', 'Nombre_Secretaria');
        $hoja->setCellValue('D1', 'DNI_Secretaria');
        $hoja->setCellValue('E1', 'Nombre_Vocal');
        $hoja->setCellValue('F1', 'DNI_Vocal');
        $hoja->setCellValue('G1', 'Numero_Mesa');
        
        $nombreArchivo = "formato_registro_comite_mesa.xlsx";
                
        $writer = new Xlsx($spreadsheet);
                
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }