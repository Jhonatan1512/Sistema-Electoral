<?php 
include_once("../includes/conexion.php");

if(isset($_POST["ModificarElector"])){
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $DNI = $_POST["DNI"];
    $estado_votacion = $_POST["estado_votacion"];
    $grado = $_POST["grado"];
    $num_mesa = $_POST["num_mesa"];

    if(empty($nombre) || empty($apellidos) || empty($DNI) || empty($grado) || empty($num_mesa)){
        $_SESSION['toast_message'] = "Todos los campos son obligatorios";
        $_SESSION['toast_type'] = "warning";

    } else {       
            
        $insert = $pdo->query("UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', DNI='$DNI', grado='$grado', num_mesa='$num_mesa', estado_votacion='$estado_votacion' WHERE id='$id'");
            
        if($insert == true){
            $_SESSION['toast_message'] = "Datos actualizados correctamente";
            $_SESSION['toast_type'] = "success";
        } else{
            $_SESSION['toast_message'] = "Error al actualizar datos";
            $_SESSION['toast_type'] = "error";
        }
    }
    ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location);
        }, 0);
    </script>
    <?php
}
?>
