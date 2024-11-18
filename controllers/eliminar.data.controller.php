<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["Eliminar"])){

        $deleteDatos = $pdo->query("DELETE FROM usuarios");
        $reiniciarID = $pdo->query("ALTER TABLE usuarios AUTO_INCREMENT = 1");

        if($deleteDatos == true && $reiniciarID == true) {
            $_SESSION['toast_message'] = "La data ha sido eliminado";
            $_SESSION['toast_type'] = "success";
        } else {
            $_SESSION['toast_message'] = "Error al eliminar data";
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