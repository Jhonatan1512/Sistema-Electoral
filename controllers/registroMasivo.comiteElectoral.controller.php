<?php
require '../vendor/autoload.php'; 
include_once ("../includes/conexion.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['subirData'])) {

    if (isset($_FILES['archivo_excel']['tmp_name'])) {

        $archivoExcel = $_FILES['archivo_excel']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($archivoExcel);
            $hoja = $spreadsheet->getActiveSheet();
            $numFilas = $hoja->getHighestRow();

            $pdo->beginTransaction();

            for ($i = 2; $i <= $numFilas; $i++) {
                $Nombre_Presidenta = $hoja->getCell('A' . $i)->getValue();
                $DNI_Presidenta = $hoja->getCell('B' . $i)->getValue();
                $Nombre_Secretaria = $hoja->getCell('C' . $i)->getValue();
                $DNI_Secretaria = $hoja->getCell('D' . $i)->getValue();
                $Nombre_Vocal = $hoja->getCell('E' . $i)->getValue();
                $DNI_Vocal = $hoja->getCell('F' . $i)->getValue();
                $Numero_Mesa = $hoja->getCell('G' . $i)->getValue();

                if (!empty($Nombre_Presidenta) && !empty($DNI_Presidenta) && !empty($Nombre_Secretaria) && !empty($DNI_Secretaria) && !empty($Nombre_Vocal) && !empty($DNI_Vocal) && !empty($Numero_Mesa)) {
                    
                    $queryinsert = $pdo->prepare("INSERT INTO presidentes_mesa (nombre_presidente, dni, secretaria, dni_secretaria, vocal, dni_vocal, mesa) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $resultado = $queryinsert->execute([$Nombre_Presidenta, $DNI_Presidenta, $Nombre_Secretaria, $DNI_Secretaria, $Nombre_Vocal, $DNI_Vocal, $Numero_Mesa]);
                    
                    if ($resultado == false) {
                        throw new Exception("Error al registrar el usuario con DNI: $Nombre_Presidenta");
                    }
                }
            }

            $pdo->commit();

            $_SESSION['toast_message'] = "Data registrada con exito";
            $_SESSION['toast_type'] = "success";
            header("location:../vista/views.comite.admin");

        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['toast_message'] = "Error al cargar la data";
            $_SESSION['toast_type'] = "error";
        }
    }
}

