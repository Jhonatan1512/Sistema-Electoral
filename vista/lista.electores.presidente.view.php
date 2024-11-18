<?php 
session_start();
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Toastr CSS -->
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
    <title>Sistema Electoral</title> 

    
</head>
<body>

<?php require('./layout/topbar.php'); ?>
<?php require('./layout/sidebar.php'); ?> 

<?php
$mesa = $_SESSION["mesa"];
include_once("../includes/conexion.php");
?> 

<div class="page-content">

    <h4 class="text-center text-secondary">LISTA DE ELECTORES</h4> 

    <form action="../controllers/cerra.mesa.controller.php" method="POST">
        <input type="hidden" name="mesa" value="<?php echo $mesa?>">
        <input type="hidden" name="estado_mesa" id="" value="0">
        <button class="btn btn-danger btn-rounded mb-2" type="submit" name="cerraMesa">
            <i class="fa-solid fa-xmark"></i>
            CERRAR MESA
        </button>
    </form>
    
    <table class="table table-striped table-hover" id="example">
        <thead>
            <tr>
                <th scope="col">APELLIDOS</th>
                <th scope="col">NOMBRE</th>
                <th scope="col">DNI</th>
                <th scope="col">ESTADO VOTACIÓN</th>
                <th scope="col">GRADO</th>
            </tr>
        </thead>
        <tbody id="electores-list">
            <!-- Aquí se cargarán los electores dinámicamente -->
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Toastr JS -->
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        
        function cargarElectores() {
            $.ajax({
                url: '../controllers/get_electores.php', 
                type: 'GET',
                success: function(data) {
                    $('#electores-list').html(data); 
                },
                error: function() {
                    alert('Error al cargar la lista de electores.');
                }
            });
        }

        cargarElectores();

        setInterval(cargarElectores, 500); 
    });

    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
    };
</script>

<?php require('./layout/footer.php'); ?>
</body>
</html>
