<?php
require '../vendor/autoload.php'; 
include_once ("../includes/conexion.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['subirArchivo'])) {

    if (isset($_FILES['archivo_excel']['tmp_name'])) {

        $archivoExcel = $_FILES['archivo_excel']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($archivoExcel);
            $hoja = $spreadsheet->getActiveSheet();
            $numFilas = $hoja->getHighestRow();
 
            $pdo->beginTransaction();

            for ($i = 2; $i <= $numFilas; $i++) {
                $nombre = $hoja->getCell('A' . $i)->getValue();
                $apellidos = $hoja->getCell('B' . $i)->getValue();
                $DNI = $hoja->getCell('C' . $i)->getValue();
                $grado = $hoja->getCell('D' . $i)->getValue();
                $num_mesa = $hoja->getCell('E' . $i)->getValue();
                $rol = $hoja->getCell('F' . $i)->getValue();

                if (!empty($nombre) && !empty($apellidos) && !empty($DNI) && !empty($grado) && !empty($num_mesa) && !empty($rol)) {
                    $queryinsert = $pdo->prepare("INSERT INTO usuarios (nombre, apellidos, DNI, grado, num_mesa, rol) VALUES (?, ?, ?, ?, ?, ?)");
                    $resultado = $queryinsert->execute([$nombre, $apellidos, $DNI, $grado, $num_mesa, $rol]);
                    
                    if ($resultado == false) {
                        throw new Exception("Error al registrar el usuario con DNI: $DNI");
                    }
                }
            }

            $pdo->commit();

            $_SESSION['toast_message'] = "Data registrada con exito";
            $_SESSION['toast_type'] = "success";
            header("location:../vista/admin.view.lista");

        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['toast_message'] = "Error al cargar la data";
            $_SESSION['toast_type'] = "error";
        }
    }
}

