<?php 
    require '../vendor/autoload.php';
 
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if (isset($_GET['descargar'])) {
        
        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
                
        $hoja->setCellValue('A1', 'Nombre');
        $hoja->setCellValue('B1', 'Apellidos');
        $hoja->setCellValue('C1', 'DNI');
        $hoja->setCellValue('D1', 'Grado');
        $hoja->setCellValue('E1', 'Num_Mesa');
        $hoja->setCellValue('F1', 'Rol');
        
        $nombreArchivo = "formato_registro_usuarios.xlsx";
                
        $writer = new Xlsx($spreadsheet);
                
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }