<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
date_default_timezone_set('America/Lima');
include_once("../includes/conexion.php");

if(isset($_GET['id_mesa'])){
    $mesa = $_GET['id_mesa'];
}  

//Presidenta de mesa
$nombre_presidente_query = $pdo->query("SELECT nombre_presidente FROM presidentes_mesa WHERE mesa = '$mesa'");
$nombre_presidente =  $nombre_presidente_query->fetch(PDO::FETCH_ASSOC)['nombre_presidente'];

$dni_presidenta_query = $pdo->query("SELECT dni FROM presidentes_mesa WHERE mesa = '$mesa'");
$dni_presidenta = $dni_presidenta_query->fetch(PDO::FETCH_ASSOC)['dni'];

//Secretaria de mesa
$nombre_secretaria_query = $pdo->query("SELECT secretaria FROM presidentes_mesa WHERE mesa = '$mesa'");
$nombre_secretaria =  $nombre_secretaria_query->fetch(PDO::FETCH_ASSOC)['secretaria'];

$dni_secretaria_query = $pdo->query("SELECT dni_secretaria FROM presidentes_mesa WHERE mesa = '$mesa'");
$dni_secretaria = $dni_secretaria_query->fetch(PDO::FETCH_ASSOC)['dni_secretaria'];

//Vocal de mesa
$nombre_vocal_query = $pdo->query("SELECT vocal FROM presidentes_mesa WHERE mesa = '$mesa'");
$nombre_vocal =  $nombre_vocal_query->fetch(PDO::FETCH_ASSOC)['vocal'];

$dni_vocal_query = $pdo->query("SELECT dni_vocal FROM presidentes_mesa WHERE mesa = '$mesa'");
$dni_vocal = $dni_vocal_query->fetch(PDO::FETCH_ASSOC)['dni_vocal'];

$hora_instalacion = "07:30 am";

$hora_inicio_escrutinio_query = $pdo->query("SELECT hora_inicio FROM mesas WHERE id_mesa = '$mesa'");
$hora_inicio_escrutinio_24 = $hora_inicio_escrutinio_query->fetch(PDO::FETCH_ASSOC)['hora_inicio'];
$hora_inicio_escrutinio = date('h:i a', strtotime($hora_inicio_escrutinio_24));

$hora_sufragio = date("h:i a");

$cedulas_recibidas_query = $pdo->query("
    SELECT COUNT(*) AS total_electores 
    FROM usuarios
    WHERE num_mesa = '$mesa';
");
$cedulas_recibidas = $cedulas_recibidas_query->fetch(PDO::FETCH_ASSOC)['total_electores'];


$numero_mesa_query = $pdo->query("SELECT num_mesa FROM mesas WHERE id_mesa='$mesa'");
$numero_mesa = $numero_mesa_query->fetch(PDO::FETCH_ASSOC)['num_mesa'];

$total_votantes_query = $pdo->query("
    SELECT COUNT(*) AS total_votos
    FROM usuarios
    WHERE num_mesa = '$mesa' AND estado_votacion = 1;
");
$total_votantes = $total_votantes_query->fetch(PDO::FETCH_ASSOC)['total_votos'];

$no_votaron_query = $pdo->query("
    SELECT COUNT(*) AS no_votaron 
    FROM usuarios
    WHERE num_mesa = '$mesa' AND estado_votacion = 0;");

$no_votaron = $no_votaron_query->fetch(PDO::FETCH_ASSOC)['no_votaron'];


$votos = $pdo->query("
    SELECT c.nombre_candidato, c.nombre_partido, c.logo, COUNT(v.id) AS cantidad_votos
    FROM candidatos c
    LEFT JOIN votos v ON c.id_candidato = v.id_candidato AND v.num_mesa = '$mesa'
    GROUP BY c.id_candidato;
");

$imagePath1 = '../public/st.png';
$imageData1 = base64_encode(file_get_contents($imagePath1));

$imagePath2 = '../public/onpe.png';
$imageData2 = base64_encode(file_get_contents($imagePath2));

$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
        }
        .header h2, .header h4 {
            margin: 0;
            padding: 0;
        }
        .content-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 20px;
        } 
        .section {
            width: 97%;
            border: none;
            padding: 10px;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            background-color: #f2f2f2;
            padding: 5px;
        }
        .content { 
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: none;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .firma {
            margin-top: 40px;
            border-collapse: collapse;
            border: none;
            font-size: 13px;
        }
        .firma td {
            border: none;
            text-align: center;
            padding-top: 30px;
        }


        .content-section-table {
            width: 100%; 
            margin-bottom: 20px;
            border-collapse: collapse; 
            border: none; 
        }
        .content-section-table td {
            width: 50%; 
            vertical-align: top; 
            border: none; 
        }
        .section1 {
            border: 1px solid #000; 
            padding: 10px; 
            height: 95px;
            background-color: #f2f2f2;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            background-color: #f2f2f2;
            padding: 5px;
        }
        .content{
            text-align: justify;
            font-size: 15px;
        }
        #section2 {
            text-align: justify;
            font-size: 15px;            
            font-weight: normal;
        }
        .contenido {
           background-color: white; 
           width:25px;
           padding-left: 25px;
           padding-right: 25px;
           text-align:center;
           height:15px;
           display:inline;
           border: solid 1px;
        }
        
    </style>
</head>
<body>

<div class="header">
    <img src="data:image/png;base64,' . $imageData1 . ' alt="" width="80" style="float:left;">
    <img src="data:image/png;base64,' . $imageData2 . ' alt="" width="80" style="float:right;">
    <h4>CONSEJO MUNICIPAL ESTUDIANTIL</h4><br>
    <h2>I.E. EMBLEMÁTICA "SANTA TERESITA"</h2>
    <h3>ACTA ELECTORAL MESA N° ' . $numero_mesa . '</h3>
</div>

<table class="content-section-table">
    <tr>
        <td>
            <div class="section1">
                <div class="section-title">INSTALACIÓN</div>
                <div class="content">
                    La mesa de votación se instala a las <strong>'. $hora_instalacion.'</strong> horas, del día 15 de Noviembre de 2024.<br>
                    Total de electores: 
                    <strong>
                        <div class="contenido">
                            '.$cedulas_recibidas.'
                        </div>
                    </strong>
                </div>
            </div>
        </td>

        <td>
            <div class="section1">
                <div class="section-title">SUFRAGIO</div>
                <div class="content">
                    El sufragio concluye a las <strong>'. $hora_sufragio.'</strong> horas, del día 15 de Noviembre de 2024.<br>
                    Total de electores que votaron: 
                    <strong>
                        <div class="contenido">    
                           '. $total_votantes.'
                        </div>
                    </strong>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="section">
    <div class="section-title">ESCRUTINIO <br><br>
        <div id="section2">
            Siendo las ' . $hora_inicio_escrutinio . ' horas del dia 15 de noviembre de 2024, se da inicio al ESCRUTINIO.
        </div> 
    </div>
    <table>
        <thead>
            <tr>
                <th>CANDIDATO</th>
                <th>PARTIDO</th>
                <th>LOGO</th>
                <th>VOTOS</th>
            </tr>
        </thead>
        <tbody>';

        while ($fila = $votos->fetch(PDO::FETCH_ASSOC)) {
    
            if ($fila['nombre_partido'] === 'VOTO EN BLANCO') {
                if ($fila['logo']) {
                    $logoPath = '../public/' . $fila['logo'];
                    
                    if (file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logo = '<img src="data:image/png;base64,' . $logoData . '" width="40">';
                    } else {
                        $logo = ''; 
                    }
                } else {
                    $logo = ''; 
                }
        
                $html .= '
                <tr>
                    <td colspan="3">VOTOS EN BLANCO</td>
                    <td>' . htmlspecialchars($fila['cantidad_votos']) . '</td>
                </tr>';
            } else {
                if ($fila['logo']) {
                    $logoPath = '../public/' . $fila['logo'];
                    
                    if (file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logo = '<img src="data:image/png;base64,' . $logoData . '" width="40">';
                    } else {
                        $logo = ''; 
                    }
                } else {
                    $logo = ''; 
                }
        
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($fila['nombre_candidato']) . '</td>
                    <td>' . htmlspecialchars($fila['nombre_partido']) . '</td>
                    <td>' . $logo . '</td>
                    <td>' . htmlspecialchars($fila['cantidad_votos']) . '</td>
                </tr>';
            }
        }
        
$html .= '
        <tr>
            <td colspan="3"><strong>Total de Votos</strong></td>
            <td><strong>' . $total_votantes . '</strong></td>
        </tr>
        <tr>
            <td colspan="3"><strong>No Votaron</strong></td>
            <td><strong>' . $no_votaron . '</strong></td>
        </tr>
        </tbody>
    </table>
</div>

<div class="section" id="section2">
    Siendo las ' . $hora_sufragio . ' horas, finaliza el ACTO DE ESCRUTINIO.
</div>
<br><br>

<table class="firma" width="100%" >
    <tr>
        <td> ----------------------------------------- <br>Presidenta:<br>'.$nombre_presidente.'  <br><br> DNI: '.$dni_presidenta.'</td>
        <td> ----------------------------------------- <br>Secretaria:<br>'.$nombre_secretaria.'  <br><br> DNI: '.$dni_secretaria.'</td>
        <td> ----------------------------------------- <br>Vocal:<br>'.$nombre_vocal.'       <br><br> DNI: '.$dni_vocal.'</td><br>        
    </tr>
</table>

</body>
</html>
';

$dompdf = new Dompdf();

$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("acta_electoral_mesa_".$numero_mesa.".pdf", array("Attachment" => 1));

