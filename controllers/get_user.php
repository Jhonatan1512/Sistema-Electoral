<?php
    include_once("../includes/conexion.php");

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 50;
    $offset = ($page - 1) * $limit;
    $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

    // Contar el total de registros con el filtro aplicado
    $total_sql = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE DNI LIKE :filtro OR grado LIKE :filtro");
    $total_sql->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
    $total_sql->execute();
    $total_records = $total_sql->fetchColumn();

    // Obtener los registros actuales con el filtro aplicado, incluyendo el número de mesa
    $sql = $pdo->prepare("
        SELECT usuarios.*, mesas.num_mesa
        FROM usuarios
        LEFT JOIN mesas ON usuarios.num_mesa = mesas.id_mesa
        WHERE usuarios.DNI LIKE :filtro OR usuarios.grado LIKE :filtro
        LIMIT :limit OFFSET :offset
    ");
    $sql->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
    $sql->bindParam(':limit', $limit, PDO::PARAM_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Enviar datos y total de registros en la respuesta JSON
    $response = [
        'total_records' => $total_records,
        'data' => $data
    ];

    echo json_encode($response);

