<?php 
    session_start();
    include_once("../includes/conexion.php");

    if(isset($_POST["RegistrarElector"])){
        $nombre = trim($_POST["nombre"]);
        $apellidos = trim($_POST["apellidos"]);
        $DNI = trim($_POST["DNI"]);
        $grado = trim($_POST["grado"]);
        $num_mesa = trim($_POST["num_mesa"]);
        $rol = trim($_POST["rol"]);

        if(empty($nombre) || empty($apellidos) || empty($DNI) || empty($grado) || empty($num_mesa) || empty($rol)){
            $_SESSION['toast_message'] = "Todos los campos son obligatorios";
            $_SESSION['toast_type'] = "warning";
        } else {
            
            $checkDNI = "SELECT COUNT(*) FROM usuarios WHERE DNI = ?";
            $queryCheckDNI = $pdo->prepare($checkDNI);
            $queryCheckDNI->execute(array($DNI));
            $DNIExists = $queryCheckDNI->fetchColumn();

            if($DNIExists){
                $_SESSION['toast_message'] = "El DNI ya está registrado";
                $_SESSION['toast_type'] = "warning";
            } else {
                
                $insert = "INSERT INTO `usuarios`(`nombre`, `apellidos`, `DNI`, `grado`, `num_mesa`, `rol`) VALUES (?,?,?,?,?,?)";
                $queryInsert = $pdo->prepare($insert);
                $resultInsert = $queryInsert->execute(array($nombre, $apellidos, $DNI, $grado, $num_mesa, $rol));

                if($resultInsert == true){
                    $_SESSION['toast_message'] = "Elector creado correctamente";
                    $_SESSION['toast_type'] = "success";
                } else{
                    $_SESSION['toast_message'] = "Error al registrar elector";
                    $_SESSION['toast_type'] = "error";
                }
            }
        }
        header("location:../vista/admin.view.lista");
    }

