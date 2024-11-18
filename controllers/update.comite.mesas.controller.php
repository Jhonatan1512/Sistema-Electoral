<?php 
    include_once("../includes/conexion.php");

    if(isset($_POST["ModificarComite"])){

        $id_presidente = trim($_POST["id_presidente"]);
        $nombre_presidente = trim($_POST["nombre_presidente"]);
        $dni = trim($_POST["dni"]);
        $secretaria = trim($_POST["secretaria"]);
        $dni_secretaria = trim($_POST["dni_secretaria"]);
        $vocal = trim($_POST["vocal"]);
        $dni_vocal = trim($_POST["dni_vocal"]);
        $mesa = trim($_POST["mesa"]);

        if(empty($nombre_presidente) || empty($dni) || empty($secretaria) || empty($dni_secretaria) || empty($vocal) || empty($dni_vocal) || empty($mesa)){
            $_SESSION['toast_message'] = "Todos los datos son obligatorios";
            $_SESSION['toast_type'] = "warning";
        }else{
            $update = $pdo->query("
                                UPDATE 
                                    presidentes_mesa 
                                SET 
                                    nombre_presidente='$nombre_presidente',
                                    dni='$dni',
                                    secretaria='$secretaria',
                                    dni_secretaria='$dni_secretaria',
                                    vocal='$vocal',
                                    dni_vocal='$dni_vocal',
                                    mesa='$mesa' 
                                WHERE id_presidente = '$id_presidente'");
        
            if($update == true){
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