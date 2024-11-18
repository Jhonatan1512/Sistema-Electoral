<?php
session_start();
include_once("../includes/conexion.php");

$mesa = $_SESSION["mesa"]; 

$sql = $pdo->query("SELECT * FROM usuarios WHERE num_mesa = '$mesa' ORDER BY apellidos ASC");

while ($datos = $sql->fetchObject()) {
    echo "<tr>";
    echo "<td scope='row'>" . $datos->apellidos . "</td>";
    echo "<th>" . $datos->nombre . "</th>";
    echo "<td>" . $datos->DNI . "</td>";
    echo "<td>";
    if ($datos->estado_votacion == 1) {
        echo "<img src='../public/like.png' alt='Voto Realizado' width='25'>";
    } else {
        echo "<img src='../public/error.png' alt='Voto No Realizado' width='25'>";
    }
    echo "</td>";
    echo "<td>" . $datos->grado . "</td>";
    echo "</tr>";
}

