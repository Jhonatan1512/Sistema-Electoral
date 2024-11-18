<?php

session_start();
include_once("../includes/conexion.php");
if(!empty($_POST["btnIngresar"])){
    if(!empty($_POST["dni"])){
        
        $dni = $_POST["dni"];

        $sql=$pdo->query("select * from admin where dni='$dni'");

        if($datos=$sql->fetchObject()){  
            $_SESSION["dni"]=$datos->dni; 
            $_SESSION["id_presidente"]=$datos->id_presidente; 
            $_SESSION["nombre"]=$datos->nombre;
            $_SESSION["mesa"]=$datos->mesa;

            header("location:../vista/admin.view");
        } else{ 
            $_SESSION['toast_message'] = "Su DNI es incorrecta, intente de nuevo";
            $_SESSION['toast_type'] = "error";
        }
    } else{ 
        $_SESSION['toast_message'] = "Por favor ingrese su DNI";
        $_SESSION['toast_type'] = "warning";
    }
}