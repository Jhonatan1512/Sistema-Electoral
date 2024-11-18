<?php
session_start();
include_once ("../includes/conexion.php");

if (isset($_POST["ModificarCandidato"])) {

    $id_candidato = $_POST['id_candidato'];
    $nombre_candidato = $_POST['nombre_candidato'];
    $nombre_partido = $_POST['nombre_partido'];
    $logo = $_FILES['logo']['name'];
    $grado = $_POST['grado'];

    if (!empty($nombre_candidato) && !empty($nombre_partido) && !empty($grado)) {
        
        if (!empty($logo)) {
            $tipo = $_FILES['logo']['type'];
            $temp = $_FILES['logo']['tmp_name'];

            $extensiones_validas = array('image/jpeg', 'image/png', 'image/jpg');
            if (!in_array($tipo, $extensiones_validas)) {
                $_SESSION['toast_message'] = "Solo se permiten imágenes de tipo jpg, png y jpeg";
                $_SESSION['toast_type'] = "warning";
            } else {
                
                    $sql = 'UPDATE candidatos SET nombre_candidato=?, nombre_partido=?, logo=?, grado=? WHERE id_candidato=?';
                    $query = $pdo->prepare($sql);
                    $result = $query->execute(array($nombre_candidato, $nombre_partido, $logo, $grado, $id_candidato));

                    if ($result) {
                        move_uploaded_file($temp, '../public/' . $logo);
                        $_SESSION['toast_message'] = "Datos del candidato actualizados exitosamente";
                        $_SESSION['toast_type'] = "success";
                    } else {
                        $_SESSION['toast_message'] = "Error al actualizar del candidato";
                        $_SESSION['toast_type'] = "error";
                    }
            }
        } else {
            
                $sql = 'UPDATE candidatos SET nombre_candidato=?, nombre_partido=?, grado=? WHERE id_candidato=?';
                $query = $pdo->prepare($sql);
                $result = $query->execute(array($nombre_candidato, $nombre_partido, $grado, $id_candidato));

                if ($result) {
                    $_SESSION['toast_message'] = "Candidato actualizado exitosamente";
                    $_SESSION['toast_type'] = "success";
                } else {
                    $_SESSION['toast_message'] = "Error al actualizar el candidato";
                    $_SESSION['toast_type'] = "error";
                }
        }
    } else {
        $_SESSION['toast_message'] = "Todos los campos son necesarios";
        $_SESSION['toast_type'] = "warning";
    }

    header("location:../vista/view.registrar.candidatos");
    exit(); 
}
