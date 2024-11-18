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
include_once("../controllers/delete.comite.mesas.controller.php");
include_once("../controllers/update.comite.mesas.controller.php");
include_once("../controllers/registro.comite.mesas.controller.php");
include_once("../controllers/deleteData.comite.mesas.controller.php");

$sql = $pdo->query("
    SELECT 
        id_presidente,
        nombre_presidente,
        dni,
        secretaria,
        dni_secretaria,
        vocal,
        dni_vocal,
        m.num_mesa
    FROM `presidentes_mesa` p
    INNER JOIN mesas m ON p.mesa = m.id_mesa;
");


?>

<style>
</style>

<div class="page-content">

    <h4 class="text-center text-secondary">COMITE DE MESA</h4>

    <a href="" data-toggle="modal" data-target="#registrarComite"class="btn btn-primary btn-rounded mb-2"> 
        <i class="fa-solid fa-plus"></i> REGISTRAR COMITE DE MESA
    </a>

    <a href="" data-toggle="modal" data-target="#exampleModal"class="btn btn-success btn-rounded mb-2"> 
        <i class="fa-solid fa-file-excel"></i>&nbsp;REGISTRO MASIVO
    </a>
    <a href="" data-toggle="modal" data-target="#deleteRegistros"class="btn btn-danger btn-rounded mb-2"> 
        <i class="fa-solid fa-database"></i>&nbsp;ELIMINAR REGISTROS
    </a>

    <table class="table table-striped table-hover" id="example">
        <thead>
            <tr>
                <th scope="col">PRESIDENTA</th> 
                <th scope="col">DNI PRESIDENTA</th>
                <th scope="col">SECRETARIA</th>
                <th scope="col">DNI SECRETARIA</th>
                <th scope="col">VOCAL</th>
                <th scope="col">DNI VOCAL</th>
                <th scope="col">MESA</th>
                <th scope="col"></th>
                <th scope="col"></th>    
            </tr>
        </thead>
        <tbody class="table-group-divider"> 
            <?php
            while ($datos = $sql->fetchObject()) {
                ?>
                <tr>
                    <td scope="row"><?= $datos->nombre_presidente ?></td>
                    <th><?= $datos->dni ?></th>
                    <td><?= $datos->secretaria ?></td>
                    <td><?= $datos->dni_secretaria ?></td>
                    <td><?= $datos->vocal ?></td>
                    <td><?= $datos->dni_vocal ?></td> 
                    <td><?= $datos->num_mesa ?></td>
                    <td>
                        <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_presidente ?>"
                            class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="" data-toggle="modal" data-target="#deleteElector<?= $datos->id_presidente ?>"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    <td></td>
                </tr>

                <!-- Modal Update Comite de mesa-->
                <div class="modal fade" id="exampleModal<?= $datos->id_presidente ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Comite de mesa</h5> 

                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="ID" class="input input__text" name="id_presidente"
                                            value="<?= $datos->id_presidente ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="Nombre Presidenta" class="input input__text" name="nombre_presidente"
                                            value="<?= $datos->nombre_presidente ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="DNI Presidenta" class="input input__text"
                                            name="dni" value="<?= $datos->dni ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="Nombre Secretaria" class="input input__text" name="secretaria"
                                            value="<?= $datos->secretaria ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="DNI Secretaria" class="input input__text" name="dni_secretaria"
                                        value="<?= $datos->dni_secretaria ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="Nombre Vocal" class="input input__text" name="vocal"
                                            value="<?= $datos->vocal ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="DNI Vocal" class="input input__text" name="dni_vocal"
                                            value="<?= $datos->dni_vocal ?>">
                                    </div>
                                    <div class="fl-flex-label mb-4 px2 col-12 ">
                                        <select name="mesa" id="" class="input input__select">
                                            <option value="">Mesa...</option>
                                            <?php
                                            $sql2 = $pdo->query("select * from mesas ");
                                            while ($datos1 = $sql2->fetchObject()) { ?>
                                                <option value="<?= $datos1->id_mesa ?>"><?= $datos1->num_mesa ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="text-rigth p-2">
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                            name="ModificarComite">GUARDAR</button>
                                        <a href="views.comite.admin" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete Registro de comite de mesa-->
                <div class="modal fade" id="deleteElector<?= $datos->id_presidente?>" tabindex="-1" aria-labelledby="deleteElector"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title" id="deleteElector">¿ESTAS SEGURO DE ELIMINAR EL REGISTRO?</h5> 
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                                        <input type="text" placeholder="ID" class="input input__text" name="id_presidente"
                                            value="<?= $datos->id_presidente ?>">
                                    </div>
                                    <div class="text-rigth p-2">
                                        <button type="submit" class="btn btn-success btn-rounded mb-2" value="ok"
                                            name="DeleteComite">SI!!</button>
                                        <a href="views.comite.admin" class="btn btn-danger btn-rounded mb-2">NO</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </tbody>
    </table> 

            <!-- Modal Registro por excel-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between">
                            <h5 class="modal-title" id="exampleModalLabel">Seleccionar archivo excel</h5> 

                        </div>
                            <div class="modal-body">

                                <div class="alert alert-primary" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                        &nbsp;Importante: Primero descargue el formato
                                </div>
                                <div class="alert alert-primary" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                        &nbsp;Importante: Asegurese de no tener datos duplicados en el erchivo excel
                                </div>

                                <form action="../controllers/formatoExcel.comite.controller.php" method="GET">
                                    <button type="submit" class="btn btn-success" name="descargar">
                                        <i class="fa-solid fa-file-excel"></i>&nbsp;Descargar formato
                                    </button><br><br>                                                                            
                                </form>

                                <form action="../controllers/registroMasivo.comiteElectoral.controller.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="archivo_excel" accept=".xls,.xlsx"> <br><br>
                                    <div class="text-rigth p-2">
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                            name="subirData">GUARDAR
                                        </button>
                                            <a href="views.comite.admin" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal Registrar Comite de mesa-->
            <div class="modal fade" id="registrarComite" tabindex="-1" aria-labelledby="registrar"
                    aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between">
                             <h5 class="modal-title" id="registrar">Registrar Comite de mesa</h5> 

                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="ID" class="input input__text" name="id_presidente"
                                        value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="Nombre Presidenta" class="input input__text" name="nombre_presidente"
                                        value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="DNI Presidenta" class="input input__text"
                                        name="dni" value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="Nombre Secretaria" class="input input__text" name="secretaria"
                                        value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="DNI Secretaria" class="input input__text" name="dni_secretaria"
                                    value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="Nombre Vocal" class="input input__text" name="vocal"
                                        value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <input type="text" placeholder="DNI Vocal" class="input input__text" name="dni_vocal"
                                        value="">
                                </div>
                                <div class="fl-flex-label mb-4 px2 col-12 ">
                                    <select name="mesa" id="" class="input input__select">
                                        <option value="">Mesa...</option>
                                        <?php
                                        $sql2 = $pdo->query("select * from mesas ");
                                        while ($datos1 = $sql2->fetchObject()) { ?>
                                            <option value="<?= $datos1->id_mesa ?>"><?= $datos1->num_mesa ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="text-rigth p-2">
                                    <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                        name="RegistrarComite">GUARDAR</button>
                                    <a href="views.comite.admin" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Delete Registro de comite de mesa-->
            <div class="modal fade" id="deleteRegistros" tabindex="-1" aria-labelledby="deleteRegistros"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between">
                            <h5 class="modal-title" id="deleteRegistros">¿ESTAS SEGURO DE ELIMINAR LA DATA?</h5> 
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <div class="text-rigth p-2">
                                    <button type="submit" class="btn btn-success btn-rounded mb-2" value="ok"
                                        name="DeleteData">SI!!</button>
                                    <a href="views.comite.admin" class="btn btn-danger btn-rounded mb-2">NO</a>
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