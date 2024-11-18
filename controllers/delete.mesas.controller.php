<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["deleteMesa"])){

        $id_mesa = trim($_POST["id_mesa"]);

        $delete = $pdo->query("DELETE FROM mesas WHERE id_mesa='$id_mesa'");

        if($delete == true){
            $_SESSION['toast_message'] = "Registro de la mesa eliminado";
            $_SESSION['toast_type'] = "success";
        }else{
            $_SESSION['toast_message'] = "Error al eliminar el registro de la mesa";
            $_SESSION['toast_type'] = "error";
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