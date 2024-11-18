<?php
    include_once("../includes/conexion.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el registro']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
