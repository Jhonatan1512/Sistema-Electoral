

<style>
    ul li:nth-child(3) .activo {
        background: rgb(11, 150, 214) !important;
    }
</style>

<style>
    .toast-custom-position {
        top: 80px !important; 
        right: 12px; 
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    
    <title>Administrador</title>
</head>

<body>
<body>
    
</body>
</html>

<?php require('./layout/topbar-admin.php'); ?>
<?php require('./layout/sidebar_admin.php'); ?>

<?php 
include_once("../includes/conexion.php");


if(isset($_GET['id_candidato'])){
    $id_candidato = $_GET['id_candidato'];
}
$sql = $pdo->query("SELECT * FROM candidatos WHERE id_candidato='$id_candidato'");

?> 

<div class="page-content">
    <h4 class="text-center text-secondary">Datos del Candidato</h4>
        <div class="row">
        <form action="../controllers/update.candidato.controller.php" method="POST" enctype="multipart/form-data">
            <?php 
            while ($datos = $sql->fetchObject()) { ?>
            
                <div hidden class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="ID" class="input input__text" name="id_candidato" value="<?=$datos->id_candidato ?>">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="Nombre y Apellidos del Candidato" class="input input__text" name="nombre_candidato" value="<?=$datos->nombre_candidato ?>">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="Nombre del partido" class="input input__text" name="nombre_partido" value="<?=$datos->nombre_partido ?>">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="Grado" class="input input__text" name="grado" value="<?=$datos->grado ?>">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="file" placeholder="" class="input input__text" name="logo" value="">
                </div> <br><br><br><br><br><br><br>

                <div class="text-rigth p-2">
                    <button type="sumbit" class="btn btn-primary btn-rounded mb-2" value="ok" name="ModificarCandidato">MODIFICAR</button>
                    <a href="view.registrar.candidatos.php" class="btn btn-secondary btn-rounded mb-2" value="ok">Volver</a>
                </div>

                <?php
                
            }
            ?>
            
        </form>
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