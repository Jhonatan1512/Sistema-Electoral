<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf; 

session_start();
date_default_timezone_set('America/Lima');
include_once("../includes/conexion.php");

$hora_instalacion = "07:30 am";

$total_votantes_query = $pdo->query("
    SELECT COUNT(*) AS total_votos
    FROM usuarios
    WHERE estado_votacion = 1;
");
$total_votantes = $total_votantes_query->fetch(PDO::FETCH_ASSOC)['total_votos'];

$votos = $pdo->query("
    SELECT c.nombre_candidato, p.nombre_partido, c.logo, COUNT(v.id) as cantidad_votos
    FROM candidatos c
    LEFT JOIN votos v ON c.id_candidato = v.id_candidato
    LEFT JOIN candidatos p ON c.id_candidato = p.id_candidato
    GROUP BY c.id_candidato
");

$votos_grado = $pdo->query("
    SELECT 
    grado,
    nombre_partido,
    logo,
    total_votos
FROM (
    SELECT 
        SUBSTRING(u.grado, 1, 1) AS grado,
        c.nombre_partido,
        c.logo,
        COUNT(v.id) AS total_votos,
        ROW_NUMBER() OVER (PARTITION BY SUBSTRING(u.grado, 1, 1) ORDER BY COUNT(v.id) DESC) AS row_num
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    GROUP BY 
        grado, c.nombre_partido, c.logo
) AS ranked
ORDER BY grado, total_votos DESC;

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
            width: 100%;
            border: none;
            padding: 10px;
        }
        .section-title {
            font-weight: bold;
            float: left;
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
       
        .firma {
            margin-top: 40px;
            border-collapse: collapse;
            border: none;
        }
        .firma td {
            border: none;
            text-align: center;
            font-size: 13px;
            padding-top: 30px;
        }
        th {
            background-color: #f2f2f2;
        }

        .content-section-table {
            width: 100%; 
            margin-bottom: 10px;
            border-collapse: collapse; 
            border: none; 
        }
        .content-section-table td {
            width: 50%; 
            vertical-align: top; 
            border: none; 
        }
        .section1 {
            border: 0px solid #000; 
            padding: 10px; 
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            /*background-color: #f2f2f2;*/
            padding: 5px;
        }
        .content{
            text-align: justify;
        }
        .section2 {
            text-align: justify;
        }
        .contenido {
           background-color: white; 
           width:25px;
           padding-left: 25px;
           padding-right: 25px;
           text-align:center;
           height:15px;
           display:inline;
        }
        
    </style>
</head>
<body>

<div class="header">
    <img src="data:image/png;base64,' . $imageData1 . ' alt="" width="80" style="float:left;">
    <img src="data:image/png;base64,' . $imageData2 . ' alt="" width="80" style="float:right;">
    <h2>CONSEJO MUNICIPAL ESTUDIANTIL</h2>
    <h4>I.E. EMBLEMÁTICA "SANTA TERESITA"</h4><br>
</div>

<table class="content-section-table">
    <tr>        
        <td>
            <div class="section1">
                <div class="section-title">Acta Final del Proceso Electoral de la Institución Educativa Emblemático Santa Teresita - Nivel Secundario</div>
                <div class="content">
                    <strong>
                    Fecha: 15 de noviembre del año 2024<br>
                    Hora de inicio: 08:00 a.m.
                    </strong>
                </div>
                <div class="content">
                    En la Institución Educativa Emblemático Santa Teresita - Nivel Secundario, 
                    el día 15 de noviembre de 2024 se llevó a cabo el proceso electoral para la 
                    elección del consejo estudiantil. La jornada se realizó de manera ordenada y participativa, 
                    con el fin de fortalecer la democracia estudiantil y promover la participación activa de las estudiantes.
                </div>
            </div>
            <div class="section1">
                <div class="section-title">Implementación del Voto Presencial Electrónico</div><br><br>
                <div class="content">
                    En el marco de las elecciones de 2024, se implementó por primera vez el voto presencial electrónico, 
                    como una medida innovadora con el objetivo de incrementar y fomentar las competencias digitales 
                    en nuestra comunidad educativa. Esta iniciativa representa un paso importante hacia la 
                    modernización de nuestros procesos electorales y se alinea con los esfuerzos de nuestra 
                    institución por preparar a los estudiantes para los desafíos tecnológicos del futuro.<br>

                    Además, este cambio no solo responde a un enfoque de modernización y formación digital, 
                    sino que también contribuye significativamente a la protección del medio ambiente. 
                    La implementación del voto electrónico permite disminuir el uso del papel, 
                    un recurso cuya producción y desecho tienen un impacto ambiental considerable. De esta manera, 
                    buscamos reducir nuestra huella ecológica y promover la sostenibilidad en el ámbito escolar.<br>

                    Con este nuevo sistema, nuestra institución se compromete a ser un modelo de innovación y conciencia 
                    ambiental, reduciendo la necesidad de impresión de boletas, papeletas y otros materiales que 
                    tradicionalmente se utilizan en los procesos electorales. De esta forma, estamos no solo 
                    fortaleciendo la cultura digital, sino también participando activamente en la conservación 
                    de nuestros recursos naturales al reducir el consumo de papel y, en consecuencia, minimizar 
                    el impacto en los ecosistemas vinculados a la tala de árboles y el uso de químicos para la producción de papel.
                </div>
            </div>
            <div class="section1">
                <div class="section-title">Desarrollo del Proceso Electoral</div><br><br>
                <div class="content">
                    El proceso electoral inició puntualmente a las 08:00 a.m. con la apertura de 
                    las mesas de votación, donde los estudiantes, utilizando dispositivos electrónicos 
                    habilitados para el voto, ejercieron su derecho al sufragio en un ambiente de respeto y 
                    responsabilidad. A las 9:30 a.m., se procedió al cierre de las mesas y al conteo de los resultados.
                </div>
            </div>
            <div class="section1"><br>
                <div class="section-title">Resultados Finales por Lista</div><br><br>
                <div class="content">
                    A continuación, se presenta el cuadro resumen de los votos obtenidos por cada lista participante:
                </div>
            </div>
        </td>
    </tr>
</table>


<div class="section">
    
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
        </tbody>
    </table>
</div>

<table class="content-section-table">
    <tr>        
        <td>
            <div class="section1">
                <div class="section-title">Observaciones Finales</div><br><br>
                <div class="content">
                    - La jornada electoral se llevó a cabo sin incidentes, respetándose el proceso democrático.<br>
                    - Se destaca la participación entusiasta de las estudiantes, 
                    reflejando el compromiso de la comunidad educativa con el desarrollo de sus valores cívicos.
                </div>
            </div>
            <div class="section1">
                <div class="section-title">Cierre</div><br><br>
                <div class="content">
                    Se da por concluido el proceso electoral del consejo estudiantil del año 2025 
                    en la Institución Educativa Emblemático Santa Teresita - Nivel Secundario. 
                </div><br>
                <div class="content">
                    <strong>Hora de culminación: 09:30 a.m.</strong>
                </div>
            </div>
        </td>
    </tr>
</table>
<table class="firma" width="100%" >
    <tr>
        <td>____________________   <br><strong>Hna. Margarita Castilla Félix </strong><br><br> Directora:</td>
        <td>____________________ <br><strong> Prof. Roberto Rubio Cotrina</strong><br><br>Presidente del Comité Electoral: </td>
        <td>____________________  <br><br><strong> De la Rosa Briones Andrea</strong><br><br>Presidenta del Municipio Escolar Estudiantil: </td>
        
    </tr>
    <tr>
        <td>DNI:<br>07913902 </td>
        <td>DNI:<br>26696434 </td>
        <td>DNI:<br>61325010 </td>
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

$dompdf->stream("Resultados_generales.pdf", array("Attachment" => 1));

