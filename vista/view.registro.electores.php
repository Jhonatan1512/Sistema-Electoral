
<style>
    ul li:nth-child(3) .activo {
        background: rgb(11, 150, 214) !important;
    }
</style>


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
?> 

<div class="page-content">
    <h4 class="text-center text-secondary">Datos del Candidato</h4>
        <div class="row">
        <form action="../controllers/controller.registro.elector.php" method="POST">            
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="NOMBRE" class="input input__text" name="nombre" value="">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="APELLIDOS" class="input input__text" name="apellidos" value="">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="DNI" class="input input__text" name="DNI" value="">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="GRADO" class="input input__text" name="grado" value="">
                </div>
                <div class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <select name="num_mesa" id="" class="input input__select">
                        <option value="">MESA...</option>
                        <?php
                        $sql = $pdo->query("select * from mesas ");
                        while ($datos = $sql->fetchObject()) { ?>
                            <option value="<?= $datos->id_mesa ?>"><?= $datos->num_mesa ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div> 
                <div hidden class="fl-flex-label mb-4 px2 col-12 col-md-6">
                    <input type="text" placeholder="" class="input input__text" name="rol" value="estudiante">
                </div>
                <br><br><br><br><br><br><br><br><br><br>

                <div class="text-rigth p-2">
                    <button type="sumbit" class="btn btn-primary btn-rounded mb-2" value="ok" name="RegistrarElector">REGISTRAR</button>
                    <a href="admin.view.lista" class="btn btn-secondary btn-rounded mb-2" value="ok">Volver</a>
                </div>
        </form>
    </div>
</div>

<?php require('./layout/footer.php'); ?>