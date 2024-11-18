
//Llenar Tabla
let paginaActual = 1;
const limit = 40; 

function cargarPagina(pagina, filtro = "") {
    fetch(`../controllers/get_user.php?page=${pagina}&filtro=${filtro}`)
        .then(response => response.json())
        .then(response => {
            const totalRecords = response.total_records;
            const data = response.data;

            let html = `
                <div class="cabecera">
                    <div class="celda">Nombre</div>
                    <div class="celda">Apellidos</div>
                    <div class="celda">DNI</div>
                    <div class="celda">Grado</div>
                    <div class="celda">Mesa</div>
                    <div class="celda">Estado Votación</div>
                    <div class="celda"></div>
                </div>`;

            data.forEach(usser => {
                let imagenEstado = '';
                if (usser.estado_votacion == '0') {
                    imagenEstado = '<img src="../public/error.png" alt="Estado 0" width="25px"/>';
                } else if (usser.estado_votacion == '1') {
                    imagenEstado = '<img src="../public/like.png" alt="Estado 1" width="25px"/>';
                }
                html += `
                    <div class="fila" id="fila-${usser.id}">
                        <div class="celda">${usser.nombre}</div>
                        <div class="celda">${usser.apellidos}</div>
                        <div class="celda">${usser.DNI}</div>
                        <div class="celda">${usser.grado}</div>
                        <div class="celda">${usser.num_mesa}</div>
                        <div class="celda">${imagenEstado}</div>
                        <div class="celda">
                            <button class="btn btn-warning btn-sm" onclick="abrirModalEdicion(${usser.id})">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(${usser.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>`;
            });

            document.getElementById("contenedor-datos").innerHTML = html;

            paginaActual = pagina;
            const startRecord = (pagina - 1) * limit + 1;
            const endRecord = Math.min(pagina * limit, totalRecords);
            document.getElementById("pagina-actual").innerText = paginaActual;
            document.getElementById("registro-rango").innerText =
                `Mostrando registros del ${startRecord} al ${endRecord} de un total de ${totalRecords} registros.`;
        })
        .catch(error => console.error('Error al cargar datos:', error));
}

cargarPagina(1);

document.getElementById("input-busqueda").addEventListener("input", function() {
    const filtro = this.value;
    cargarPagina(1, filtro);
}); 


// Abrir y llenar modal
function abrirModalEdicion(id) {
    $('#modalEdicion').modal('show'); 

    fetch(`../controllers/get_user_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('input[name="id"]').value = data.usuario.id;
                document.querySelector('input[name="nombre"]').value = data.usuario.nombre;
                document.querySelector('input[name="apellidos"]').value = data.usuario.apellidos;
                document.querySelector('input[name="DNI"]').value = data.usuario.DNI;
                document.querySelector('select[name="estado_votacion"]').value = data.usuario.estado_votacion;
                document.querySelector('input[name="grado"]').value = data.usuario.grado;
                document.querySelector('select[name="num_mesa"]').value = data.usuario.num_mesa;

                const selectMesa = document.querySelector('select[name="num_mesa"]');
                selectMesa.innerHTML = '<option value="">Mesa...</option>'; 
                data.mesas.forEach(mesa => {
                    const option = document.createElement('option');
                    option.value = mesa.id_mesa;
                    option.textContent = mesa.num_mesa;
                    selectMesa.appendChild(option);
                });

                $('#modalEdicion').modal('show');
            } else {
                Swal.fire('Error', 'No se pudo cargar los datos del usuario.', 'error');
            }
        })
        .catch(error => {
            console.error('Error al cargar los datos del usuario:', error);
            Swal.fire('Error', 'Hubo un problema al cargar los datos del usuario.', 'error');
        });
}

// Función para confirmar eliminación con SweetAlert
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarRegistro(id);
        }
    });
}

// Función para eliminar el registro y actualizar la tabla
function eliminarRegistro(id) {
    fetch(`../controllers/delete.electora.php?id=${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Eliminado', 'El registro ha sido eliminado.', 'success');
                document.getElementById(`fila-${id}`).remove(); 
            } else {
                Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
            }
        })
        .catch(error => console.error('Error al eliminar registro:', error));
}

