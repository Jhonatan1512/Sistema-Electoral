<?php
session_start();

?>
<style>
    .toast-custom-position {
        top: 80px !important; 
        right: 12px; 
    }
</style>

<style>
    ul li:nth-child(2) .activo {
        background: rgb(11, 150, 214) !important;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

</body>

</html>

<!-- primero se carga el topbar -->
<?php require ('./layout/topbar-admin.php'); ?>
<!-- luego se carga el sidebar -->
<?php require ('./layout/sidebar_admin.php'); ?>

<!-- inicio del contenido principal -->

<?php
include_once("../includes/conexion.php");


$sql = $pdo->query("
    SELECT 
        usuarios.nombre,
        usuarios.apellidos,
        usuarios.DNI,
        usuarios.estado_votacion,
        usuarios.grado,
        m.num_mesa
    FROM usuarios
    LEFT JOIN mesas m ON usuarios.grado = m.ubicacion_mesa
    WHERE estado_votacion='0';
");

?>

<div class="page-content">
    <h4 class="text-center text-secondary">LISTA DE ESTUDIANTES QUE NO VOTARON</h4>

    
    <a href="admin.view.lista" class="btn btn-primary btn-rounded mb-2"> 
        <i class="fa-solid fa-arrow-rotate-left"></i> VOLVER
    </a>

    <table class="table table-striped table-hover" id="example">
        <thead> 
            <tr>
                
                <th scope="col">NOMBRE</th>
                <th scope="col">APELLIDOS</th>
                <th scope="col">DNI</th>
                <th scope="col">ESTADO VOTACIÓN</th>
                <th scope="col">GRADO</th>
                <th scope="col">MESA</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            while ($datos = $sql->fetchObject()) {
                ?>
                <tr>
                    
                    <th><?= $datos->nombre ?></th>
                    <td><?= $datos->apellidos ?></td>
                    <td><?= $datos->DNI ?></td>
                    <td>
                        <?php if ($datos->estado_votacion == 1) { ?>
                            <img src="../public/like.png" alt="Voto Realizado" width="25" >
                        <?php } else { ?>
                            <img src="../public/error.png" alt="Voto No Realizado" width="25" >
                        <?php } ?>
                    </td>
                    <td><?= $datos->grado ?></td>
                    
                    <td><?= $datos->num_mesa?></td>
                </tr>

                <?php
            }
            ?>            
        </tbody>
    </table>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require ('./layout/footer.php'); ?>