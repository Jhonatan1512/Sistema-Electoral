<?php
    include_once("../includes/conexion.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "
            SELECT usuarios.*, mesas.num_mesa 
            FROM usuarios 
            INNER JOIN mesas ON usuarios.num_mesa = mesas.id_mesa 
            WHERE usuarios.id = :id
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $query_mesas = "SELECT id_mesa, num_mesa FROM mesas";
            $stmt_mesas = $pdo->prepare($query_mesas);
            $stmt_mesas->execute();
            $mesas = $stmt_mesas->fetchAll(PDO::FETCH_ASSOC);

            $numeros_mesa = array_map(function($mesa) {
                return ['id_mesa' => $mesa['id_mesa'], 'num_mesa' => $mesa['num_mesa']];
            }, $mesas);

            echo json_encode([
                'success' => true,
                'usuario' => $usuario,
                'mesas' => $numeros_mesa
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
