
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
    #btn{
        margin-left: 12.5%;
        margin-top: 20px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    <title>Sistema Electoral</title> 
</head>
<body>
</body>
</html>
 
<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?> 
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<?php
$mesa = $_SESSION["mesa"];

include_once("../includes/conexion.php");

$sql = $pdo->query("
    SELECT num_mesa 
    FROM presidentes_mesa pm
    INNER JOIN mesas m ON pm.mesa = m.id_mesa
    WHERE mesa='$mesa';
"); 

$electores = $pdo->query("
    SELECT COUNT(*) AS total_electores
    FROM usuarios
    WHERE num_mesa = '$mesa';
");

$votos = $pdo->query("
    SELECT COUNT(*) AS total_votos
    FROM usuarios
    WHERE num_mesa = '$mesa' AND estado_votacion = 1;
");

$faltantes = $pdo->query("
    SELECT COUNT(*) AS votos_faltantes
    FROM usuarios
    WHERE num_mesa = '$mesa' AND estado_votacion = 0;
");

?>

<!-- inicio del contenido principal -->
<div class="page-content"> 
    <?php while ($datos = $sql->fetchObject()) { ?>
        <h4 class="text-center text-secondary">NÚMERO DE MESA <?=$datos ->num_mesa?></h4>
    <?php } ?>

    <div class="container">
            <div class="card">
                <?php while($cantidad = $electores->fetchObject()){ ?>
                
                <h2>CANTIDAD DE ELECTORES:</h2> 
                <p><?= $cantidad-> total_electores?></p>
                <?php } ?>
            </div>
    
            <div class="card">
            <?php while($votosT = $votos->fetchObject()){ ?>
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

    <form action="../controllers/apertura_mesa.controller.php" method="POST">
        <input type="hidden" name="mesa" value="<?php echo $mesa; ?>"> 
        <input type="hidden" name="estado_mesa" id="" value="1">
        <button class="btn btn-primary btn-rounded mb-2" id="btn" type="submit" name="aperturarMesa">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> APERTURAR MESA
        </button>      
    </form>
    
</div> 

<!-- fin del contenido principal -->

<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>