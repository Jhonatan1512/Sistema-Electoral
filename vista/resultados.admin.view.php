<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/st.png">
    <link rel="stylesheet" href="../css/resultados.css">
    <title>Administrador</title> 
</head>
<body>
</body>
</html>

<?php require('./layout/topbar-admin.php'); ?>
<?php require('./layout/sidebar_admin.php'); ?>

<style>
    .progress {
        position: relative; 
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        height: 35px;
        margin-top: 10px;
    }

    .candidate {
        margin-bottom: 20px;
    }
</style>

<div class="page-content">

<h4 class="text-center text-secondary">RESULTADOS GENERALES</h4>

    <a href="../controllers/resultados.generales.controller.php" class="btn btn-success btn-rounded mb-2" name="resultados"> <i class="fa-solid fa-file-pdf"></i>
    IMPRIMIR RESULTADOS</a><br><br>
    
    <div class="container">
        <!-- Aquí se cargarán los resultados dinámicamente -->
    </div>
    
</div>

<?php require('./layout/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>
    function obtenerResultados() {
        $.ajax({
            url: '../controllers/get_resultados.php', 
            type: 'GET',
            success: function(data) {
                data.sort((a, b) => b.porcentaje - a.porcentaje);

                let container = $('.container');
                container.empty(); 
                
                let coloresDisponibles = ['red', 'blue', 'green', 'orange', 'purple', 'cyan'];

                data.forEach((candidato, index) => {
                    let color = coloresDisponibles[index % coloresDisponibles.length]; 

                    let nombrePartido = candidato.nombre_partido === "VOTO EN BLANCO" ? "VOTOS EN BLANCO" : candidato.nombre_partido;

                    let html = `
                        <div class="candidate">
                            <div class="image-container">
                                <img src="../public/${candidato.logo}" alt="${candidato.nombre_candidato}" class="profile-img">
                            </div>
                            <div class="info">
                                <h2>${nombrePartido}</h2>
                                ${candidato.nombre_partido !== "VOTO EN BLANCO" ? `<p>Lista ${candidato.grado}</p>` : ''}
                                <span class="vote-count">${candidato.cantidad_votos} Votos</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${candidato.porcentaje}%; background-color: ${color};">
                                        ${candidato.porcentaje}%
                                    </div>
                                </div>
                            </div> 
                        </div>`;
                    container.append(html);
                });
            }
        });
    }
        
    setInterval(obtenerResultados, 500);
    obtenerResultados();
    
</script>

