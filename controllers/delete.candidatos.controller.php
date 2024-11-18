<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["DeleteCandidatos"])){

        $delete = $pdo->query("DELETE FROM candidatos");

        if($delete == true){
            $_SESSION['toast_message'] = "Registro de candidatos eliminados";
            $_SESSION['toast_type'] = "success";
        }else{
            $_SESSION['toast_message'] = "Error al eliminar el registro de candidatos";
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