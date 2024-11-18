
<?php 
session_start();
?>

<style>
    ul li:nth-child(1) .activo {
        background: rgb(11, 150, 214) !important;
    }

    .alineacion{
        display: flex;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        color: #333;
    }

    .container {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        flex: 1;
        max-width: 300px;
        text-align: center;
        
    } 

    .card h2 {
        margin-top: 0;
        font-size: 1.5em;
        color: #555;
    }

    .card p {
        font-size: 2em;
        color: #333;
    }
</style>

<style>
    .grados{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .grados div {
        width: calc(33.33% - 10px); 
        background-color: #fff;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
    }
    .general{
        color:green;
    }
</style>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    <title>Administrador</title> 
</head>
<body>
</body>
</html> 
 
<!-- primero se carga el topbar -->
<?php require('./layout/topbar-admin.php'); ?> 
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar_admin.php'); ?>

<?php
$mesa = $_SESSION["mesa"];

include_once("../includes/conexion.php");

$electores = $pdo->query("
    SELECT COUNT(*) AS total_electores
    FROM usuarios;
");

$votos1 = $pdo->query("
    SELECT COUNT(*) AS total_votos
    FROM usuarios
    WHERE estado_votacion = 1;
");

$faltantes = $pdo->query("
    SELECT COUNT(*) AS votos_faltantes
    FROM usuarios
    WHERE estado_votacion = 0;
");
 
$primero =$pdo->query("
    SELECT 
        c.nombre_partido,
        COUNT(v.id) AS total_votos,
        CONCAT(ROUND((COUNT(v.id) * 100.0 / NULLIF((SELECT COUNT(*) FROM votos v2 WHERE v2.id_elector IN (SELECT id FROM usuarios WHERE grado LIKE '1%')), 0)), 2)) AS porcentaje_votos
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    WHERE 
        u.grado LIKE '1%' 
    GROUP BY 
        c.id_candidato
    ORDER BY 
        c.id_candidato;
");

$segundo = $pdo->query("
    SELECT 
        c.nombre_partido,
        COUNT(v.id) AS total_votos,
        CONCAT(ROUND((COUNT(v.id) * 100.0 / NULLIF((SELECT COUNT(*) FROM votos v2 WHERE v2.id_elector IN (SELECT id FROM usuarios WHERE grado LIKE '2%')), 0)), 2)) AS porcentaje_votos
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    WHERE 
        u.grado LIKE '2%' 
    GROUP BY 
        c.id_candidato
    ORDER BY 
        c.id_candidato;
");

$tercero = $pdo->query("
    SELECT 
        c.nombre_partido,
        COUNT(v.id) AS total_votos,
        CONCAT(ROUND((COUNT(v.id) * 100.0 / NULLIF((SELECT COUNT(*) FROM votos v2 WHERE v2.id_elector IN (SELECT id FROM usuarios WHERE grado LIKE '3%')), 0)), 2)) AS porcentaje_votos
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    WHERE 
        u.grado LIKE '3%' 
    GROUP BY 
        c.id_candidato
    ORDER BY 
        c.id_candidato;
");

$cuarto = $pdo->query("
    SELECT 
        c.nombre_partido,
        COUNT(v.id) AS total_votos,
        CONCAT(ROUND((COUNT(v.id) * 100.0 / NULLIF((SELECT COUNT(*) FROM votos v2 WHERE v2.id_elector IN (SELECT id FROM usuarios WHERE grado LIKE '4%')), 0)), 2)) AS porcentaje_votos
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    WHERE 
        u.grado LIKE '4%' 
    GROUP BY 
        c.id_candidato
    ORDER BY 
        c.id_candidato; 
");

$quinto = $pdo->query("
    SELECT 
        c.nombre_partido,
        COUNT(v.id) AS total_votos,
        CONCAT(ROUND((COUNT(v.id) * 100.0 / NULLIF((SELECT COUNT(*) FROM votos v2 WHERE v2.id_elector IN (SELECT id FROM usuarios WHERE grado LIKE '5%')), 0)), 2)) AS porcentaje_votos
    FROM 
        votos v
    JOIN 
        candidatos c ON v.id_candidato = c.id_candidato
    JOIN 
        usuarios u ON v.id_elector = u.id
    WHERE 
        u.grado LIKE '5%' 
    GROUP BY 
        c.id_candidato
    ORDER BY 
        c.id_candidato;
");

// Almacenar resultados 1°
$partidosP = [];
$porcentajesP = [];
$total_votosP = [];

while ($row = $primero->fetch(PDO::FETCH_ASSOC)) {
    $partidosP[] = $row['nombre_partido'];
    $porcentajesP[] = $row['porcentaje_votos']; 
    $total_votosP[] = $row['total_votos'];
}

// Almacenar resultados 2°
$partidosS = [];
$porcentajesS = [];
$total_votosS = [];

while ($row = $segundo->fetch(PDO::FETCH_ASSOC)) {
    $partidosS[] = $row['nombre_partido'];
    $porcentajesS[] = $row['porcentaje_votos']; 
    $total_votosS[] = $row['total_votos'];
}

// Almacenar resultados 3°
$partidosT = [];
$porcentajesT = [];
$total_votosT = [];

while ($row = $tercero->fetch(PDO::FETCH_ASSOC)) {
    $partidosT[] = $row['nombre_partido'];
    $porcentajesT[] = $row['porcentaje_votos']; 
    $total_votosT[] = $row['total_votos'];
}

// Almacenar resultados 4°
$partidos = [];
$porcentajes = [];
$total_votos = [];

while ($row = $cuarto->fetch(PDO::FETCH_ASSOC)) {
    $partidos[] = $row['nombre_partido'];
    $porcentajes[] = $row['porcentaje_votos']; 
    $total_votos[] = $row['total_votos'];
}

// Almacenar resultados 5°
$partidosQ = [];
$porcentajesQ = [];
$total_votosQ = [];

while ($row = $quinto->fetch(PDO::FETCH_ASSOC)) {
    $partidosQ[] = $row['nombre_partido'];
    $porcentajesQ[] = $row['porcentaje_votos']; 
    $total_votosQ[] = $row['total_votos'];
}

?>

<!-- inicio del contenido principal -->
<div class="page-content">    
        <h4 class="text-center text-secondary">BIENVENIDO</h4>    
    <div class="container">
        <div class="card">
            <?php while($cantidad = $electores->fetchObject()){ ?>
             
                <h2>CANTIDAD DE ELECTORES:</h2> 
                <p><?= $cantidad-> total_electores?></p>
            <?php } ?>
        </div>
    
        <div class="card">
            <?php while($votosT = $votos1->fetchObject()){ ?>
                <h2>VOTOS EMITIDOS:</h2>
                <p><?=  $votosT->total_votos?></p>
            <?php } ?>
        </div>
        <div class="card">
            <?php while($datos2 = $faltantes->fetchObject()){ ?>
                <h2>FALTAN VOTAR:</h2>
                <p><?=  $datos2->votos_faltantes ?></p>
            <?php } ?>
        </div>
    </div>
        
            <!--Votos por grado-->

        <br><br>
        <h3 class="text-center text-primary">Cantidad de votos por grados</h3>
    <div class="grados">

            <!--Primero-->
        <div>
            <p><strong>1° Grado</strong></p>
            <canvas id="myPieChartP" width="400" height="400"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  
                    var candidatosP = <?php echo json_encode($partidosP); ?>;
                    var total_votosP = <?php echo json_encode($total_votosP); ?>; 
                    var porcentajesP = <?php echo json_encode($porcentajesP); ?>; 

                    var etiquetasP = candidatosP.map((candidatoP, index) => {
                        return `${candidatoP} (${total_votosP[index]} votos)`;
                    });

                    var ctx = document.getElementById('myPieChartP').getContext('2d');
                    var myPieChartP = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: etiquetasP, 
                            datasets: [{
                                data: porcentajesP,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += porcentajesP[context.dataIndex] + '%'; 
                                            return label;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: true,
                                    anchor: 'center',
                                    align: 'center',
                                    formatter: (value, context) => {
                                        return value + '%'; 
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

            <!--Segundo-->
        <div>
            <p><strong>2° Grado</strong></p>
            <canvas id="myPieChartS" width="400" height="400"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  
                    var candidatosS = <?php echo json_encode($partidosS); ?>;
                    var total_votosS = <?php echo json_encode($total_votosS); ?>; 
                    var porcentajesS = <?php echo json_encode($porcentajesS); ?>; 

                    var etiquetasS = candidatosS.map((candidatoS, index) => {
                        return `${candidatoS} (${total_votosS[index]} votos)`;
                    });

                    var ctx = document.getElementById('myPieChartS').getContext('2d');
                    var myPieChartS = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: etiquetasS, 
                            datasets: [{
                                data: porcentajesS,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += porcentajesS[context.dataIndex] + '%'; 
                                            return label;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: true,
                                    anchor: 'center',
                                    align: 'center',
                                    formatter: (value, context) => {
                                        return value + '%'; 
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                    }
                                }
                            }
                        }
                    });
                });
            </script>  
        </div>

            <!--Tercero-->
        <div>
            <p><strong>3ro</strong></h1>
            <canvas id="myPieChartT" width="400" height="400"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  
                    var candidatosT = <?php echo json_encode($partidosT); ?>;
                    var total_votosT = <?php echo json_encode($total_votosT); ?>; 
                    var porcentajesT = <?php echo json_encode($porcentajesT); ?>; 

                    var etiquetasT = candidatosT.map((candidatoT, index) => {
                        return `${candidatoT} (${total_votosT[index]} votos)`;
                    });

                    var ctx = document.getElementById('myPieChartT').getContext('2d');
                    var myPieChartT = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: etiquetasT, 
                            datasets: [{
                                data: porcentajesT,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += porcentajesT[context.dataIndex] + '%'; 
                                            return label;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: true,
                                    anchor: 'center',
                                    align: 'center',
                                    formatter: (value, context) => {
                                        return value + '%'; 
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                    }
                                }
                            }
                        }
                    });
                });
            </script> 
        </div>

            <!--Cuarto-->
        <div>
            <p><strong>4to</strong></p>            
            <canvas id="myPieChart" width="400" height="400"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  
                    var candidatos = <?php echo json_encode($partidos); ?>;
                    var total_votos = <?php echo json_encode($total_votos); ?>; 
                    var porcentajes = <?php echo json_encode($porcentajes); ?>; 

                    var etiquetas = candidatos.map((candidato, index) => {
                        return `${candidato} (${total_votos[index]} votos)`;
                    });

                    var ctx = document.getElementById('myPieChart').getContext('2d');
                    var myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: etiquetas, 
                            datasets: [{
                                data: porcentajes,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += porcentajes[context.dataIndex] + '%'; 
                                            return label;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: true,
                                    anchor: 'center',
                                    align: 'center',
                                    formatter: (value, context) => {
                                        return value + '%'; 
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

            <!--Quinto-->
        <div>
            <p><strong>5to</strong></p>
            <canvas id="myPieChartQ" width="400" height="400"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  
                    var candidatosQ = <?php echo json_encode($partidosQ); ?>;
                    var total_votosQ = <?php echo json_encode($total_votosQ); ?>; 
                    var porcentajesQ = <?php echo json_encode($porcentajesQ); ?>; 

                    var etiquetasQ = candidatosQ.map((candidatoQ, index) => {
                        return `${candidatoQ} (${total_votosQ[index]} votos)`;
                    });

                    var ctx = document.getElementById('myPieChartQ').getContext('2d');
                    var myPieChartQ = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: etiquetasQ, 
                            datasets: [{
                                data: porcentajesQ,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += porcentajesQ[context.dataIndex] + '%'; 
                                            return label;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: true,
                                    anchor: 'center',
                                    align: 'center',
                                    formatter: (value, context) => {
                                        return value + '%'; 
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
        
    </div>    
</div>

<!-- fin del contenido principal -->

<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>