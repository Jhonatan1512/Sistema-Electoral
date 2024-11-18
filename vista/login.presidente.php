

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="shortcut icon" href="../public/st.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 
    <title>Login</title> 
  </head>
  <body> 
    <div class="wrapper">
      <div class="container main">
        <div class="row">

          <div class="col-md-6 side-image">
            <div class="text">
              
            </div>  
          </div>          
            <div class="col-md-6 right">

            <form class="form" method="post">
            <?php 
                  include_once("../includes/conexion.php");
                  include_once("../controllers/login.presidente.controller.php"); 
            ?>
              <div class="input-box">
                
                <div class="input-field">
                  <input type="text" class="input" id="email" name="dni" required="" autocomplete="off" />
                  <label for="email">Ingrese su DNI</label>
                </div>
                <div class="input-field">
                  <input type="submit" class="submit" value="SIGUIENTE" name="btnIngresar" />
                </div>
              </div>
              </form>
            </div>
          
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    
    <?php if (isset($_SESSION['toast_message'])): ?>
      <script>
          document.addEventListener('DOMContentLoaded', function () {
              
              if (typeof jQuery !== 'undefined') {
                  toastr.options = {
                      "closeButton": true,
                      "progressBar": true,
                      "positionClass": "toast-top-right", 
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
    
    
  </body>
</html>
