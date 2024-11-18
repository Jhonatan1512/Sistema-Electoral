<?php 
include_once("../includes/conexion.php");

if(isset($_POST["UpdateMesa"])){

    $id_mesa = $_POST["id_mesa"];
    $num_mesa = $_POST["num_mesa"];
    $ubicacion_mesa = $_POST["ubicacion_mesa"];

    if(empty($ubicacion_mesa)){
        $_SESSION['toast_message'] = "Todos los campos son obligatorios";
        $_SESSION['toast_type'] = "warning";
    } else {

        $updateMesa = $pdo->query("UPDATE mesas SET num_mesa='$num_mesa', ubicacion_mesa='$ubicacion_mesa' WHERE id_mesa='$id_mesa'");

        if($updateMesa == true){
            $_SESSION['toast_message'] = "Datos de la mesa actualizados";
            $_SESSION['toast_type'] = "success";
        } else{
            $_SESSION['toast_message'] = "Error al actualizar datos de la mesa";
            $_SESSION['toast_type'] = "warning";            
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