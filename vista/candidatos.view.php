<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/candidatos.css">
    <link rel="shortcut icon" href="../public/st.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <title>Candidatos</title>
</head>
<body>   
 
<?php 
    $id = $_SESSION["id"];
    include_once("../includes/conexion.php");
    include_once("../controllers/voto.controller.php"); 
    
    $sql = $pdo->query("SELECT * FROM usuarios WHERE id = '$id'");
    $candidatos = $pdo->query("SELECT * FROM candidatos"); 
?>
 
<?php while ($datos = $sql->fetchObject()) { ?>  
    <div class="container">
        <h2 class="text-encabezado">Bienvenida <?=$datos->nombre?>, MARCA EL SIMBOLO DE LA LISTA DE TU PREFERENCIA, !GRACIAS!</h2>
        
        <?php foreach ($candidatos as $row) { ?>
        <div class="box"> 
          <div class="contenido">
            <div class="text" style="clear: both;">
              <strong style="color:#000036;"><?php echo $row['nombre_partido'] ?></strong><br>
              <?php echo $row['nombre_candidato'] ?>
            </div> 

            <?php if ($row['nombre_partido'] !== 'VOTO EN BLANCO') : ?>
              <div class="numLista" style="height: 130px;">
                <h1>Lista
                  <?php echo $row['grado']; ?>
                </h1>
              </div>
            <?php else : ?>
              <div class="numLista" style="height: 130px; border: none;"></div>
            <?php endif; ?>
          </div>

          <div class="image" id="image_<?php echo $row['id_candidato']; ?>">             
            <form method="post" action="">            
              <input type="hidden" name="DNI" value="<?=$datos->DNI ?>">
              <input type="hidden" name="id" value="<?=$datos->id ?>">
              <input type="hidden" name="num_mesa" value="<?=$datos->num_mesa?>">
              <input type="hidden" name="id_candidato" value="<?php echo $row['id_candidato']?>">
              <input type="hidden" name="estado_votacion" value="1">
 
              <div class="images">             
                  <div class="logo">
                    <button type="button" class="image-button" onclick="marcarImagenConX(<?php echo $row['id_candidato']; ?>)">
                        <img src="../public/<?php echo $row['logo']?>" alt="<?php echo $row['nombre_candidato'] ?>">
                    </button>               
                  </div>
              </div>
              
              <div class="modal fade" id="modal_<?php echo $row['id_candidato']; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $row['id_candidato']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" style="color:#000036" id="modalLabel_<?php echo $row['id_candidato']; ?>">¿Estás segura de tu elección?</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color:#000036"> 
                      El cambio está en tus manos!
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                      <button type="submit" class="btn btn-success" name="registrarVoto">¡Sí!</button>
                    </div>
                  </div>
                </div>
              </div> 
            </form>            
          </div>
        </div>
        <?php } ?>
        <!-- Botón Confirmar Voto para abrir el modal del candidato seleccionado -->
        <div style="margin-top: 20px;">
          <button type="button" class="btn btn-success" onclick="abrirModalConfirmacion()">Confirmar Voto</button>
        </div>
        
    </div>
    
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   
  let candidatoSeleccionado = null;
  
  function marcarImagenConX(idCandidato) {
    
    document.querySelectorAll('.image').forEach(function(elemento) {
      elemento.classList.remove('selected');
    });
    
    document.getElementById('image_' + idCandidato).classList.add('selected');
    
    candidatoSeleccionado = idCandidato;
  }

  function abrirModalConfirmacion() {
    if (candidatoSeleccionado) {      
      const modalId = `#modal_${candidatoSeleccionado}`;
      const modal = new bootstrap.Modal(document.querySelector(modalId));
      modal.show();
    } else {
      Swal.fire({
            icon: 'warning',
            title: 'Selecciona un candidato',
            text: 'Por favor, selecciona un candidato antes de confirmar.',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'btn btn-primary' 
            },
            buttonsStyling: false 
        });
    }
  }
</script>

</body>
</html>
