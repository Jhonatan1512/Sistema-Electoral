<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["RegistrarMesa"])){

        $num_mesa = trim($_POST["num_mesa"]);
        $ubicacion_mesa = trim($_POST["ubicacion_mesa"]);
        $hora_inicio = trim($_POST["hora_inicio"]);

        if(empty($num_mesa) || empty($ubicacion_mesa)){
            $_SESSION['toast_message'] = "Todos los Campos son obligatorios";
            $_SESSION['toast_type'] = "warning";
        } else{

            $insert = "INSERT INTO mesas (num_mesa, ubicacion_mesa, hora_inicio) VALUES(?,?,?)";
            $queryInsert = $pdo->prepare($insert);
            $resultInsert = $queryInsert->execute(array($num_mesa, $ubicacion_mesa, $hora_inicio));

            if($resultInsert == true){
                $_SESSION['toast_message'] = "Mesa registrada";
                $_SESSION['toast_type'] = "success";
            }else{
                $_SESSION['toast_message'] = "Error al registrar nueva mesa";
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
