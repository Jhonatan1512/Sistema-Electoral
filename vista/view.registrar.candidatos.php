<?php
session_start();

?>

<style>
    ul li:nth-child(1) .activo {
        background: rgb(11, 150, 214) !important;
    }
    .btn{
        text-align: center;
    }
</style>

<style>
    .toast-custom-position {
        top: 80px !important; 
        right: 12px; 
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    <link rel="stylesheet" href="../css/view.candidatos.css">
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
include_once("../controllers/delete.candidatos.controller.php");

$candidatos = $pdo->query("SELECT * FROM candidatos;");

?>


<div class="page-content">
    
    <h4 class="text-center text-secondary">PARTIDOS POLITÍCOS</h4>

    <a id="btn" href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-rounded mb-2"> 
        <i class="fa-solid fa-plus"></i> REGISTRAR PARTIDO POLITICO
    </a>
    <a href="" data-toggle="modal" data-target="#deletePartidos" class="btn btn-danger btn-rounded mb-2"> 
        <i class="fa-solid fa-trash"></i></i> ELIMINAR PARTIDOS POLITICOS
    </a> 
        <div class="container"> 
            <?php while($datos = $candidatos->fetchObject()) { ?>
                <div class="profile">
                    <div class="image-container">
                        <img src="../public/<?php echo $datos->logo; ?>" alt="<?php echo $datos->nombre_candidato; ?>" class="profile-img">
                        <img src="../public/<?php echo $datos->logo; ?>" alt="<?php echo $datos->nombre_partido; ?>" class="party-logo">
                    </div>
                    <div class="text">
                        <h3><a href="update.view.camdidato.php?id_candidato=<?= $datos->id_candidato ?>" class="edit-btn" data-id="<?= $datos->id_candidato ?>"><?= $datos->nombre_candidato ?></a></h3>
                        <p><?= $datos->nombre_partido ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

            <!--Insert Candidatos-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="exampleModalLabel">DATOS DEL PARTIDO POLITICO</h5> 
                    </div>
                    <div class="modal-body">
                        <form action="../controllers/registro.candidato.controller.php" method="POST" enctype="multipart/form-data">
                            <div class="fl-flex-label mb-4 px2 col-12 ">
                                <input type="text" placeholder="NOMBRE CANDIDATO" class="input input__text" name="nombre_candidato"
                                    value="">
                            </div>
                            <div class="fl-flex-label mb-4 px2 col-12 ">
                                <input type="text" placeholder="NOMBRE DEL PARTIDO POLÍTICO" class="input input__text"
                                    name="nombre_partido" value="">
                            </div>
                            <div class="fl-flex-label mb-4 px2 col-12 ">
                                <input type="file" placeholder="" class="input input__text" name="logo"
                                    value="">
                            </div>
                            <div class="fl-flex-label mb-4 px2 col-12 ">
                                <input type="text" placeholder="GRADO" class="input input__text" name="grado"
                                    value="">
                            </div>

                            <div class="text-rigth p-2">
                                <button type="sumbit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                    name="RegistrarCandidato">GUARDAR</button>
                                <a href="view.registrar.candidatos.php" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!--Delete Candidatos-->
        <div class="modal fade" id="deletePartidos" tabindex="-1" aria-labelledby="deletePartidosLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="deletePartidosLabel">¿ESTAS SEGURO DE ELIMINAR?</h5> 
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="text-rigth p-2">
                                <button type="sumbit" class="btn btn-success btn-rounded mb-2" value="ok"
                                    name="DeleteCandidatos">SI!!</button>
                                <a href="view.registrar.candidatos" class="btn btn-danger btn-rounded mb-2">NO</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require ('./layout/footer.php'); ?>