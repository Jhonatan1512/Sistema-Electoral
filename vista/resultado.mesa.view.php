<?php 
session_start();
?>

<!-- Toast CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .toast-custom-position {
        top: 80px !important; 
        right: 12px; 
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    <link rel="stylesheet" href="../css/resultados.css">
    <title>Sistema Electoral</title> 
</head>
<body>
</body>
</html>
 
<?php require('./layout/topbar.php'); ?>
<?php require('./layout/sidebar.php'); ?>

<?php
$mesa = $_SESSION["mesa"];

include_once("../includes/conexion.php");

$votos = $pdo->query("
    SELECT c.nombre_candidato, p.nombre_partido, c.logo, COUNT(v.id) as cantidad_votos
    FROM candidatos c
    LEFT JOIN votos v ON c.id_candidato = v.id_candidato AND v.num_mesa = '$mesa'
    LEFT JOIN candidatos p ON c.id_candidato = p.id_candidato
    GROUP BY c.id_candidato;
");

$total_votos_result = $pdo->query("SELECT 
    COUNT(v.id) as total_votos
FROM 
	votos v
WHERE
	num_mesa = '$mesa';");
$total_votos_row = $total_votos_result->fetch(PDO::FETCH_ASSOC);
$total_votos = $total_votos_row['total_votos'];

$colores_candidatos = [];

$colores_disponibles = [
    'red',
    'blue',
    'green',
    'orange',
    'purple',
    'cyan',
];
$candidato_count = 0; 

while ($row = $votos->fetch(PDO::FETCH_ASSOC)) {
    $nombre_candidato = $row['nombre_candidato'];    
    $colores_candidatos[$nombre_candidato] = $colores_disponibles[$candidato_count % count($colores_disponibles)];

    $candidato_count++; 
};

$sql = $pdo->query("
    SELECT num_mesa 
    FROM presidentes_mesa pm
    INNER JOIN mesas m ON pm.mesa = m.id_mesa
    WHERE mesa='$mesa';
");

?>

<style>
    .progress {
        position: relative; 
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        height: 35px;
        margin-top: 10px;
    }
</style>

<div class="page-content">
<?php while ($datos = $sql->fetchObject()) { ?>
        <h4 class="text-center text-secondary">RESULTADOS DE LA MESA <?= $datos->num_mesa?></h4>
<?php } ?>
<h4 class="text-center text-secondary"></h4>

    <a href="../controllers/descargar_resultados.php" class="btn btn-success btn-rounded mb-2" name="resultados"> 
        <i class="fa-solid fa-file-pdf"></i>IMPRIMIR RESULTADOS
    </a> 
    
    <div class="container">
        <?php
        $votos->execute();

        while ($row = $votos->fetch(PDO::FETCH_ASSOC)) {
            $nombre_candidato = $row['nombre_candidato'];
            $nombre_partido = $row['nombre_partido'];
            $logo = $row['logo'];
            $cantidad_votos = $row['cantidad_votos'];
            
            $porcentaje = $total_votos > 0 ? ($cantidad_votos / $total_votos) * 100 : 0;

            $color = isset($colores_candidatos[$nombre_candidato]) ? $colores_candidatos[$nombre_candidato] : 'gray'; 
        ?>
        <div class="candidate">
            <!-- Contenerdor imagenes -->
            <div class="image-container">
                <img src="../public/<?php echo $logo; ?>" alt="<?php echo $nombre_candidato; ?>" class="profile-img">
                <img src="../public/<?php echo $logo; ?>" alt="<?php echo $nombre_candidato; ?>" class="party-logo">                        
            </div>
            <div class="info">
                <h2><?php echo $nombre_candidato; ?></h2>
                <p><?php echo $nombre_partido; ?><span class="vote-count"><?php echo $cantidad_votos; ?> Votos</span></p>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo $porcentaje; ?>%; background-color: <?php echo $color; ?>;">
                        <?php echo round($porcentaje, 2); ?>%
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- Mostrar notificación si existe en la sesión -->
    <?php if (isset($_SESSION['toast_message'])): ?>
      <script>
          document.addEventListener('DOMContentLoaded', function () {
              
              if (typeof jQuery !== 'undefined') {
                  toastr.options = {
                      "closeButton": true,
                      "progressBar": true,
                      "positionClass": "toast-custom-position", 
                  };
                  toastr["<?php echo $_SESSION['toast_type']; ?>"]('<?php echo $_SESSION["toast_message"]; ?>');
              } else {
                  console.error("jQuery no está cargado correctamente.");
              }
          });
      </script>
      <?php
      unset($_SESSION['toast_message']);
      unset($_SESSION['toast_type']);
      ?>
      <?php endif; ?>

      <script>
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    </script>

<?php require('./layout/footer.php'); ?>