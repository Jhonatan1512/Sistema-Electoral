<?php
session_start();
include_once("../includes/conexion.php");

if (isset($_POST['cerraMesa'])) {
    $mesa = $_POST['mesa'];
    $estado_mesa = $_POST['estado_mesa'];

    $update_mesa = $pdo->query("UPDATE mesas SET estado_mesa = '$estado_mesa' WHERE id_mesa = '$mesa'");

    if ($update_mesa==true) {     
        $_SESSION['toast_message'] = "Proceso electoral finalizado";
        $_SESSION['toast_type'] = "success"; 
        header("location:../vista/resultado.mesa.view");
    } else  {
        $_SESSION['toast_message'] = "Hubo  problemas al finalizar el proceso electoral";
        $_SESSION['toast_type'] = "error"; 
    }
}

   

