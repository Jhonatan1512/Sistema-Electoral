<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["DeleteComite"])){

        $id_presidente = trim($_POST["id_presidente"]);

        $delete = $pdo->query("DELETE FROM presidentes_mesa WHERE id_presidente = '$id_presidente'");

        if($delete == true ){
            $_SESSION['toast_message'] = "Registro eliminado";
            $_SESSION['toast_type'] = "success";
        }else{
            $_SESSION['toast_message'] = "Error al eliminar registro";
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