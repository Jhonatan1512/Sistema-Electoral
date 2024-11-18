<?php
include_once("../includes/conexion.php");

$votos = $pdo->query("
    SELECT c.grado, c.nombre_partido, c.logo, COUNT(v.id) as cantidad_votos
    FROM candidatos c
    LEFT JOIN votos v ON c.id_candidato = v.id_candidato
    GROUP BY c.id_candidato;
");

$total_votos_result = $pdo->query("SELECT COUNT(id) AS total_votos FROM votos");
$total_votos_row = $total_votos_result->fetch(PDO::FETCH_ASSOC);
$total_votos = $total_votos_row['total_votos'];

$data = [];
while ($row = $votos->fetch(PDO::FETCH_ASSOC)) {
    $porcentaje = $total_votos > 0 ? ($row['cantidad_votos'] / $total_votos) * 100 : 0;
    $data[] = [
        'grado' => $row['grado'], 
        'nombre_partido' => $row['nombre_partido'],
        'logo' => $row['logo'],
        'cantidad_votos' => $row['cantidad_votos'],
        'porcentaje' => round($porcentaje, 2),
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
