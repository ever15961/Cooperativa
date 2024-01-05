var operacion = "ingresar";
var id=0;
var pass="";

//cargar complementos
$(document).ready(function () {
    cargarTableInteres();
    //iniciarinteresScript();
  
    //iniciando componentes
    iniciar();
    // Configura tu modal para que no se cierre automáticamente
});



//cargar datatable
function cargarTableInteres() {
    var tabla = $("#listadoInteres").DataTable();

}




//eliminar registro
function eliminar($id) {
    new $.Zebra_Dialog(
        "Eliminar ?",
        {
            type: "question",
            title: "Pregunta",
            custom_class:"myclass",
            onClose: function (caption) {
                if (caption.toLowerCase() == "ok") {
                   
                    procesarEliminado($id);
                }
            }
        }
    );
}

function procesarEliminado(row) {
    // Muestra una alerta SweetAlert para ingresar la contraseña
    Swal.fire({
        title: 'Por favor, ingresa tu contraseña:',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {
            // Validación: verifica si se ingresó una contraseña
            if (!password || password.trim() === '') {
                Swal.showValidationMessage('Contraseña requerida para eliminar');
            }
            return password; // Devuelve la contraseña para que se guarde en result.value
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // El usuario ha confirmado con la contraseña
            var data = new FormData();
            data.append("posicion", row);
            data.append("operacion", "eliminar");
            data.append("pass", result.value); // Agrega la contraseña al FormData

            // Realiza la petición fetch con la contraseña
            fetch("../dao/daoInteres.php", {
                method: "POST",
                body: data
            }).then((response) => {
                if (response.ok) {
                    return response.json(); // Espera un JSON en lugar de texto
                } else {
                    throw "Ha fallado la petición";
                }
            }).then((data) => {
                // Utiliza el JSON para mostrar la alerta
                if (data.success) {
                    Swal.fire({
                        position: "top-end",
                        title: 'System',
                        showConfirmButton: false,
                        icon: 'success',
                        text: data.message,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        title: 'System',
                        showConfirmButton: false,
                        icon: 'error',
                        text: data.message,
                        timer: 1500
                    });
                }
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
                if (fn != null) {
                    fn(data);
                }
            }).catch(() => {
                console.error("Ha fallado la petición:", error);
                Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'error',
                    text: "Ha fallado la petición",
                    timer: 1500
                });
            });
        }
    });
}

//setear valores de tabla en formulario
function modificar($id,elemento) {

    operacion = "editar";
    id=$id;
    var tr = elemento.closest("tr");
    var collTd = tr.children;
    var textoConPorcentaje = collTd[2].innerText;

    var textoSinPorcentaje = textoConPorcentaje.replace('%', '');
    $("#destino").val(collTd[1].innerText);
    $("#interes").val(textoSinPorcentaje);

    $("#btnRegistrarInteres").val("Modificar Interes");


    }




//iniciar elementos html necesarios para ingreso o modificacion
function iniciar() {
    document.querySelector("#btnRegistrarInteres").addEventListener("click", registrarInteres);
    document.querySelector("#btnCerrarInteres").addEventListener("click",cerrarModal);
}

//función que envia formulario de registro interes
function registrarInteres(e) {
    e.preventDefault();
    var form = new FormData(this.parentNode.parentNode);

    if (operacion == "ingresar") {
        if(document.getElementById('destino').value == "" || document.getElementById('interes').value == ""){
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'No has llenado todos los campos',
                timer: 1500 
              })
            
            }else {
                form.append("operacion", "ingresar");
                form.append("id",id);
                iniciarPeticion(form, null,e);
        }
        
        

    } else {
        if(document.getElementById('destino').value == "" || document.getElementById('interes').value == ""){
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'No has llenado todos los campos',
                timer: 1500 
              })
            
            }else{
                form.append("operacion", "editar");
                form.append("id",id);
                iniciarPeticion(form, null,e);
                
    }
}

    
}

//iniciar petición con API fetch 
function iniciarPeticion(data, fn, event) {
    // Extraer la operación de data
    const operacion = data.get("operacion");

    if (operacion === "ingresar") {
        // Si la operación es "ingresar", realizar la acción directamente sin pedir la contraseña
        fetch("../dao/daoInteres.php", {
            method: "POST",
            body: data
        }).then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Error en la petición");
            }
        }).then((data) => {
            if (data.success) {
                Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'success',
                    text: data.message,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'error',
                    text: data.message,
                    timer: 1500
                });
            }
        }).then(() => {
            limpiarFormulario();
            setTimeout(() => {
                window.location.reload();
            }, 1500);
            if (fn != null) {
                fn(data);
            }
        }).catch((error) => {
            console.error("Ha fallado la petición:", error);
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: "Ha fallado la petición",
                timer: 1500
            });
        });
    } else {
        // Si la operación no es "ingresar", pedir la contraseña
        Swal.fire({
            title: 'Por favor, ingresa tu contraseña:',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                // Validación: verifica si se ingresó una contraseña
                if (!password || password.trim() === '') {
                    Swal.showValidationMessage('Contraseña requerida para editar');
                }
                return password; // Devuelve la contraseña para que se guarde en result.value
            }
        }).then((result) => {
            if (result.isConfirmed) {
                data.append("pass", result.value); // Utiliza result.value para obtener la contraseña

                fetch("../dao/daoInteres.php", {
                    method: "POST",
                    body: data
                }).then((response) => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error("Error en la petición");
                    }
                }).then((data) => {
                    if (data.success) {
                        Swal.fire({
                            position: "top-end",
                            title: 'System',
                            showConfirmButton: false,
                            icon: 'success',
                            text: data.message,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            title: 'System',
                            showConfirmButton: false,
                            icon: 'error',
                            text: data.message,
                            timer: 1500
                        });
                    }
                }).then(() => {
                    limpiarFormulario();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                    if (fn != null) {
                        fn(data);
                    }
                }).catch((error) => {
                    console.error("Ha fallado la petición:", error);
                    Swal.fire({
                        position: "top-end",
                        title: 'System',
                        showConfirmButton: false,
                        icon: 'error',
                        text: "Ha fallado la petición",
                        timer: 1500
                    });
                });
            }
        });
    }
}
   // Función para mostrar mensajes de error
   function mostrarError(mensaje) {
    Swal.fire({
        position: "top-end",
        title: 'System',
        showConfirmButton: false,
        icon: 'error',
        text: mensaje,
        timer: 1500 
    });
}



function limpiarFormulario() {

    $("#destino").val("");
    $("#interes").val("");

    $("#btnRegistrarSocio").val("Registrar Interes");
}

function cerrarModal(){
    location.href = location.href;
    location.reload();
}