<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["reiniciar"])){

        $deleteVotos = $pdo->query("TRUNCATE TABLE votos");
        $updateEstado = $pdo->query("UPDATE `usuarios` SET `estado_votacion`='0'");

        if($deleteVotos == true && $updateEstado == true) {
            $_SESSION['toast_message'] = "Elecciones reiniciadas";
            $_SESSION['toast_type'] = "success";
        } else {
            $_SESSION['toast_message'] = "No se pudo reiniciar las elecciones";
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