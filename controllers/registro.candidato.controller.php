<?php
session_start();
include_once ("../includes/conexion.php");

if (isset($_POST["RegistrarCandidato"])) {
 
    $nombre_candidato = $_POST['nombre_candidato'];
    $nombre_partido = $_POST['nombre_partido'];
    $logo = $_FILES['logo']['name'];
    $grado = $_POST['grado'];

    if (isset($logo) && $logo != '') { 
        $tipo = $_FILES['logo']['type'];
        $temp = $_FILES['logo']['tmp_name'];

        if (!(strpos($tipo, 'jpg') || strpos($tipo, 'png') || strpos($tipo, 'jpeg'))) {
            $_SESSION['toast_message'] = "Solo se permiten imagenes de tipo jpg, png y jpeg";
            $_SESSION['toast_type'] = "warning";

        } else {
            $sqlinsert = 'INSERT INTO candidatos (nombre_candidato, nombre_partido, logo, grado) VALUES (?,?,?,?)';
            $queryinsert = $pdo->prepare($sqlinsert);
            $resulinsert = $queryinsert->execute(array($nombre_candidato, $nombre_partido, $logo, $grado));

            if ($resulinsert == true) {
                move_uploaded_file($temp, '../public/' . $logo);
                $_SESSION['toast_message'] = "Partido Politico creado";
                $_SESSION['toast_type'] = "success"; 
                header("location:../vista/view.registrar.candidatos");
            } else {
                $_SESSION['toast_message'] = "Error al crear Partido Politico";
                $_SESSION['toast_type'] = "error";
            }
        }
    } else {
        $_SESSION['toast_message'] = "Todos los campos son necesarios";
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