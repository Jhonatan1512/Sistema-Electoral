<?php
//session_start();
include_once ("../includes/conexion.php");

if (isset($_POST["registrarVoto"])) {
                
        $id = $_POST["id"];
        $DNI = $_POST['DNI'];
        $estado_votacion = $_POST['estado_votacion']; 
        $id_candidato = $_POST['id_candidato'];
        $num_mesa = $_POST['num_mesa']; 

        $actualiza = $pdo->query("update usuarios set estado_votacion='$estado_votacion' where id=$id");

        /*$registrar = $pdo->query("insert into votos (id_elector, id_candidato, num_mesa) VALUES (?,?,?)");
        $queryinsert = $pdo->prepare($registrar);
        $resulinser = $queryinsert->execute(array($id, $id_candidato, $num_mesa)); 
        */

        $queryinsert = $pdo->prepare("insert into votos (id_elector, id_candidato, num_mesa) VALUES (?,?,?)");
        $resulinser = $queryinsert->execute(array($id, $id_candidato, $num_mesa)); 
        
        if ($actualiza==true && $resulinser==true) {   
            $_SESSION['toast_message'] = "¡Voto registrado con éxito!";
            $_SESSION['toast_type'] = "success"; 
            
        } else  {
            $_SESSION['toast_message'] = "Error al registrar el voto.";
            $_SESSION['toast_type'] = "error";
        }
    header("location:../vista/login");
}


