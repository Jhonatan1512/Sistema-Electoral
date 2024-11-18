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


<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">


<!-- primero se carga el topbar -->
<?php require ('./layout/topbar-admin.php'); ?>
<!-- luego se carga el sidebar -->
<?php require ('./layout/sidebar_admin.php'); ?>

<!-- inicio del contenido principal -->

<?php
include_once("../includes/conexion.php");
include_once("../controllers/update.elector.controller.php");
include_once("../controllers/reiniciar.elecciones.controller.php");
include_once("../controllers/eliminar.data.controller.php");


?>

<div class="page-content">
    <h4 class="text-center text-secondary">LISTA DE ELECTORES</h4>

    <a href="view.registro.electores" class="btn btn-primary btn-rounded mb-2"> <i class="fa-solid fa-plus"></i>
        REGISTRAR ELECTOR
    </a>

    <a href="" data-toggle="modal" data-target="#exampleModal"class="btn btn-success btn-rounded mb-2">
        <i class="fa-solid fa-file-excel"></i>&nbsp;REGISTRO MASIVO
    </a>

    <a href="view.estudiantesNoVotaron" class="btn btn-warning btn-rounded mb-2"> 
        <i class="fa-solid fa-eye"></i> VER ESTUDIANTES QUE NO VOTARON
    </a>

    <a href="" data-toggle="modal" data-target="#reinciarElecciones"class="btn btn-info btn-rounded mb-2"> 
        <i class="fa-solid fa-rotate-left"></i> REINICIAR ELECCIONES
    </a>

    <a href="" data-toggle="modal" data-target="#eliminarData"class="btn btn-danger btn-rounded mb-2"> 
        <i class="fa-solid fa-database"></i> ELIMINAR DATA
    </a>

    <div class="d-flex align-items-center" id="search">
            <input type="text" id="input-busqueda" class="form-control me-2" placeholder="Buscar por DNI o grado">
    </div>

    <br><br><br><br>

    <!-- Contenedor de la "tabla" de datos -->
    <div id="contenedor-datos" class="tabla-simulada mt-4">

    </div>

    <div id="registro-rango" class="mt-2" id="">
        <!-- Aquí se mostrará el rango de registros, por ejemplo:
        "Mostrando registros del 1 al 10 de un total de 225 registros" -->
    </div>

    <!-- Controles de paginación -->
    <div class="pagination-controls">
        <button onclick="cargarPagina(1)">Primera</button>
        <button onclick="cargarPagina(paginaActual - 1)"><i class="fa-solid fa-angle-left"></i> Anterior</button>
        <span id="pagina-actual">1</span>
        <button onclick="cargarPagina(paginaActual + 1)">Siguiente <i class="fa-solid fa-chevron-right"></i></button>
    </div>
    
    <!-- Modal Update elector-->
    <div class="modal" id="modalEdicion" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar Elector</h5> 

                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div hidden class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="ID" class="input input__text" name="id"
                                value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="" class="input input__text" name="nombre"
                                value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="" class="input input__text"
                                name="apellidos" value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="" class="input input__text" name="DNI"
                                value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <select name="estado_votacion" class="input input__select">
                                <option value="1">Votó</option>
                                <option value="0">No Votó</option>
                            </select>
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <input type="text" placeholder="" class="input input__text" name="grado"
                                value="">
                        </div>
                        <div class="fl-flex-label mb-4 px2 col-12 ">
                            <select name="num_mesa" class="input input__select">
                                <option value="">Mesa...</option>
                            </select>
                        </div>
                        

                        <div class="text-rigth p-2">
                            <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                name="ModificarElector">GUARDAR</button>
                            <a href="admin.view.lista" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

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

                        <form action="../controllers/formato.excel.php" method="GET">
                            <button type="submit" class="btn btn-success" name="descargar">
                                <i class="fa-solid fa-file-excel"></i>&nbsp;Descargar formato
                            </button><br><br>                                                                            
                        </form>

                        <form action="../controllers/registro.electores.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="archivo_excel" accept=".xls,.xlsx"> <br><br>
                            <div class="text-rigth p-2">
                                <button type="submit" class="btn btn-primary btn-rounded mb-2" value="ok"
                                    name="subirArchivo">GUARDAR
                                </button>
                                    <a href="admin.view.lista" class="btn btn-secondary btn-rounded mb-2">VOLVER</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>    
    
    <!--Reiniciar Elecciones-->
    <div class="modal fade" id="reinciarElecciones" tabindex="-1" aria-labelledby="reiniciar"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="reiniciar">¿ESTAS SEGURO DE REINIAR LAS ELECCIONES?</h5> 
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="text-rigth p-2">
                            <button type="submit" class="btn btn-success btn-rounded mb-2" value="ok"
                                name="reiniciar">SI!!</button>
                            <a href="admin.view.lista" class="btn btn-danger btn-rounded mb-2">NO</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Eliminar Data-->
    <div class="modal fade" id="eliminarData" tabindex="-1" aria-labelledby="eliminar"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="eliminar">¿ESTAS SEGURO DE ELIMINAR LA DATA?</h5> 
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="text-rigth p-2">
                            <button type="submit" class="btn btn-success btn-rounded mb-2" value="ok"
                                name="Eliminar">SI!!</button>
                            <a href="admin.view.lista" class="btn btn-danger btn-rounded mb-2">NO</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            
        
</div>

<script src="../js/table.js"></script>

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