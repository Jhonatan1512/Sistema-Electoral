
<?php
//session_start();
include_once("../includes/conexion.php"); 

if(!empty($_POST["btnIngresar"])){
    if(!empty($_POST["dni"])){ 
        $dni = $_POST["dni"];
        
        $sql=$pdo->query("SELECT * FROM usuarios WHERE DNI='$dni'");
        
        if($datos=$sql->fetchObject()) { 
            if ($datos->estado_votacion == 1) {
                $_SESSION['toast_message'] = "Usted ya emitio su voto, gracias";
                $_SESSION['toast_type'] = "warning"; 
            } else { 
                $_SESSION["DNI"]=$datos->DNI;  
                $_SESSION["id"]=$datos->id; 
                $_SESSION["nombre"]=$datos->nombre;
                $_SESSION["num_mesa"]=$datos->num_mesa;

                header("location:../vista/candidatos.view");
            }
        } else {
            $_SESSION['toast_message'] = "Su DNI es incorrecta, intente de nuevo";
            $_SESSION['toast_type'] = "error"; 
        }
    } else { 
        $_SESSION['toast_message'] = "Por favor ingrese su DNI";
        $_SESSION['toast_type'] = "warning";
    }
}
?>
