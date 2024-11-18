<?php
session_start();

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

<!-- inicio del contenido principal -->

<style>
    .toast-custom-position {
        top: 80px !important; 
        right: 12px; 
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<?php
include_once("../controllers/update.mesas.controller.php");
include_once("../controllers/registrar.mesa.controller.php");
include_once("../controllers/delete.mesas.controller.php");

include_once("../includes/conexion.php");

$sql = $pdo->query("SELECT * FROM mesas");

?>

<div class="page-content">
    <h4 class="text-center text-secondary">MESAS</h4>

    <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-rounded mb-2">
        <i class="fa-solid fa-plus"></i> REGISTRAR MESA
    </a>

    <table class="table table-striped table-hover" id="example">
        <thead> 
            <tr>
                <th scope="col"></th>
                <th scope="col">NÚMERO MESA</th>
                <th scope="col">ESTADO MESA</th>
                <th scope="col">RESULTADOS</th>
                <th scope="col"></th>
                <th scope="col">UBICACIÓN</th>                
            </tr>
        </thead>
        <tbody class="table-group-divider"> 
            <?php
            while ($datos = $sql->fetchObject()) {
                ?>
                <tr>
                    <td scope="row"><?= $datos->id_mesa ?></td> 
                    <th><?= $datos->num_mesa ?></th>
                    <td>
                        <?php if ($datos->estado_mesa == 1) { ?>
                            <img src="../public/open.png" alt="Voto Realizado" width="40" >
                        <?php } else { ?>
                            <img src="../public/closed.png" alt="Voto No Realizado" width="40" >
                        <?php } ?> 
                    </td>
                    <td>
                        <a href="../controllers/resultados.mesas.admin.php?id_mesa=<?= $datos->id_mesa ?>" class="btn btn-success btn-rounded mb-2" name="resultados">
                            <i class="fa-solid fa-chart-simple"></i>
                        </a>
                    </td>
                    <td>
                        <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_mesa ?>"
                            class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

                        <a href="" data-toggle="modal" data-target="#DeleteModal<?= $datos->id_mesa ?>"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></i></a>
                    </td>
                    <td><?= $datos->ubicacion_mesa?></td>
                </tr> 

                <!-- Modal Update Mesa-->
                <div class="modal fade" id="exampleModal<?= $datos->id_mesa ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Mesa</h5> 
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="ID" class="input input__text" name="id_mesa"
                                            value="<?= $datos->id_mesa ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="Número de mesa" class="input input__text" name="num_mesa"
                                            value="<?= $datos->num_mesa ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="Ubicación de la mesa" class="input input__text" name="ubicacion_mesa" 
                                        value="<?= $datos->ubicacion_mesa ?>">
                                    </div>

                                    <div class="text-rigth p-2">
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                            name="UpdateMesa">GUARDAR</button>
                                        <a href="mesas.view.admin.php" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                    <!--Modal Delete Mesa-->
                <div class="modal fade" id="DeleteModal<?= $datos->id_mesa ?>" tabindex="-1" aria-labelledby="deleteMesa"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title" id="deleteMesa">¿ESTAS SEGURO DE ELIMINAR?</h5> 
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="ID" class="input input__text" name="id_mesa"
                                            value="<?= $datos->id_mesa ?>">
                                    </div>
                                    <div class="text-rigth p-2">
                                        <button type="submit" class="btn btn-success btn-rounded mb-2" value="ok"
                                            name="deleteMesa">SI</button>
                                        <a href="mesas.view.admin.php" class="btn btn-danger btn-rounded mb-2">NO</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </tbody>
    </table>

        <!--Modal Rgsitar Mesa-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="exampleModalLabel">DATOS DE LA MESA</h5> 
                </div>
                <div class="modal-body">
                    <form action="" method="POST" >
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="NÚMERO DE MESA" class="input input__text" name="num_mesa"
                                value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="UBICACIÓN" class="input input__text"
                                name="ubicacion_mesa" value="">
                        </div>
                        <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="HORA INICIO" class="input input__text"
                                name="hora_inicio" value="00:00:00">
                        </div>

                        <div class="text-rigth p-2">
                            <button type="sumbit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                name="RegistrarMesa">GUARDAR</button>
                            <a href="mesas.view.admin" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
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