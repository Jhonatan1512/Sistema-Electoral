<?php
session_start();
include_once("../includes/conexion.php");

date_default_timezone_set('America/Lima');

if (isset($_POST['aperturarMesa'])) {
    $mesa = $_POST['mesa'];
    $hora_inicio = date('H:i:s');
    $estado_mesa = $_POST['estado_mesa'];

    $update_mesa = $pdo->query("UPDATE mesas SET estado_mesa = '$estado_mesa' WHERE id_mesa = '$mesa'");
    $actualiza = $pdo->query("UPDATE mesas SET hora_inicio = '$hora_inicio' WHERE id_mesa = '$mesa'");
    
    if ($actualiza==true && $update_mesa ==true) {     
        $_SESSION['toast_message'] = "Proceso electoral iniciado.";
        $_SESSION['toast_type'] = "success"; 
        header("location:../vista/lista.electores.presidente.view");
    } else  { 
        $_SESSION['toast_message'] = "Hubo un error al aperturar la mesa, intente de nuevo";
        $_SESSION['toast_type'] = "error"; 
    } 
    
}

   

