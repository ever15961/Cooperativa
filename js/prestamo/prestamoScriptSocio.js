
var operacion = "ingresar";
var idCuota
var idprestamo = "";
window.onload = function () {
    cargarTablePrestamo();
    iniciarDescripcion();
    iniciar();
    //iniciarPrestamoScript();
}

function iniciar() {
    //  document.querySelector("#buscarSocio").addEventListener("click", buscarSocio);
    document.querySelector("#btnRegistrarPrestamo").addEventListener("click", registrarPrestamo);
    document.querySelector("#btnCerrarPrestamo").addEventListener("click", cerrarModal);


    $("#destino").change(function () {
        cambiarInteres();
    })

    cambiarInteres();

}

function cambiarInteres() {
    var index = $("#destino")[0].selectedIndex;
    var interes = $("#tasaDeInteres")[0].options[index].value;
    $("#interes").val(interes + "%");
}
//iniciar clicks de bontones editar y eliminar
function iniciarPrestamoScript() {
    var botoneraEditar = $(".editar");
    var botoneraEliminar = $(".eliminar");
    //  var botoneraMostrar = $(".mostrar");


    for (var i = 0; i < botoneraEditar.length; i++) {
        botoneraEditar[i].addEventListener("click", mostrar);
        botoneraEliminar[i].addEventListener("click", eliminar);
        //   botoneraMostrar[i].addEventListener("click", mostrar);
    }
}

//descripcion de tipo de documento en tabla
function iniciarDescripcion() {
    $("[data-toggle='tooltip'").tooltip();
}

//cargar datatable
function cargarTablePrestamo() {
    var tabla = $("#listadoPrestamos").DataTable();

}


function mostrar(id) {

    // Crear FormData y realizar la solicitud fetch
    idprestamo = id;
    var data = new FormData();
    data.append("posicion", id);
    data.append("operacion", "mostrar");

    fetch("../dao/daoPrestamo.php", {
        method: "POST",
        body: data
    }).then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw "Ha fallado la petición";
        }

    }).then((datos) => {
        llenarTabla(datos);

    }).catch(() => {
        alert("Ha fallado la petición");
    });

    operacion = "ingresar";

}

function llenarTabla(datos) {
    // Aquí puedes implementar la lógica para llenar la tabla con los datos recibidos
    // Por ejemplo, puedes usar jQuery DataTables o manipular el DOM directamente
    // Ajusta según tus necesidades y la estructura de tus datos
    // Ejemplo sencillo: Agregar filas y celdas a la tabla
    var tabla = $('#mitabla');
    tabla.empty();
    if (datos && Array.isArray(datos.id)) {
        // Supongamos que los datos son un array de objetos, cada objeto representa una fila
        var arrayId = datos.id;
        // Supongamos que tienes una variable para almacenar el estado actual de las cuotas
        var estadoCuotas = [];

        for (var i = 0; i < arrayId.length; i++) {
            var fila = arrayId[i];
            // Obtener la fecha actual en formato JavaScript Date
            var fechaActual = new Date();

            // Verificar si la cuota ya fue pagada
            var cuotaPagada = (fila.estado === 2);

            // Convertir la fecha de vencimiento a formato JavaScript Date
            var fechaVencimiento = new Date(fila.fechavencimiento);

            // Verificar si la cuota está en mora
            var estaEnMora = fechaActual > fechaVencimiento;

            // Obtener el estado anterior de la cuota
            var estadoAnterior = (i > 0) ? estadoCuotas[i - 1] : 'pagado';

            // Obtener el estado actual de la cuota (activo o inactivo)
            var estadoCuota = (cuotaPagada) ? 'Pagado' : (estaEnMora ? 'Mora' : 'Activo');

            // Verificar si el botón debe estar habilitado o no
            var botonHabilitado = (fila.estado === 1 && !cuotaPagada && (i === 0 || estadoCuotas[i - 1] === 'pagado')) ? '' : 'disabled';

            // Establecer colores y texto según el estado y mora
            var colorTextoEstado = (cuotaPagada) ? 'red' : (estaEnMora ? 'orange' : 'green');
            var colorBotonPagar = (cuotaPagada) ? 'red' : (estaEnMora ? 'orange' : 'green');
            var textoBotonPagar = (cuotaPagada) ? 'Pagado' : (estaEnMora ? 'Pagar' : (estadoAnterior === 'pagado' ? 'Pendiente' : 'Pendiente'));
            var botonInactivo = cuotaPagada ? 'disabled' : '';
            var montoFormateado = '$' + parseFloat(fila.montoCuota).toFixed(2); // Agregar símbolo de dólar

            // Construir la fila HTML
            var filaHTML = '<tr>';
            filaHTML += '<td>' + fila.numeroCuota + '</td>';
            filaHTML += '<td>' + montoFormateado + '</td>'; // Usar el monto formateado con símbolo de dólar
            filaHTML += '<td>' + fila.fechavencimiento + '</td>';
            filaHTML += '<td style="color: ' + colorTextoEstado + ';">' + estadoCuota + '</td>';
            filaHTML += '<td><button style="background-color: ' + colorBotonPagar + '; color: white;" ' + botonInactivo + ' ' + botonHabilitado +">"+ textoBotonPagar + '</button></td>';
            // ... Continuar con las demás columnas
            filaHTML += '</tr>';

            // Agregar la fila a la tabla
            tabla.append(filaHTML);

            // Actualizar el estado de la cuota actual en el array de estadoCuotas
            estadoCuotas.push(cuotaPagada ? 'pagado' : 'activo');
        }


    } else {
        console.error('Error: datos no es un array válido', datos);
    }
}


function confirmarPago(id) {
    Swal.fire({
        title: '¿Desea pagar la cuota?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, pagar'
    }).then((result) => {
        if (result.isConfirmed) {
            idCuota = id;
            // Llama a la función daoPrestamo y pasa el id como parámetro
            cancelarCuota(id);
        } else {
            // Aquí puedes agregar lógica adicional si el usuario cancela el pago
            console.log('Pago cancelado para el ID:', id);
        }
    });
}

function cancelarCuota(id) {
    var form = new FormData();
    form.append("operacion", "pagar");
    form.append("id", id);
    form.append("idPrestamo", idprestamo);
    iniciarPeticionPago(form, null);

}
function buscarSocio() {

    var form = new FormData();
    form.append("dato", document.querySelector("#socio").value);
    form.append("operacion", "comprobarSocio");

    fetch("../dao/daoPrestamo.php", {
        method: "POST",
        body: form
    }).then((response) => {
        if (response.ok) {
            return response.text();
        } else {
            throw "Error al procesar operación";
        }
    }).then((response) => {
        alert(response);
    }).catch(() => {
        console.log("error");
    })

}


//función que envia formulario de registro usuario
function registrarPrestamo(e) {
    if (operacion == "ingresar") {
        e.preventDefault();

        var form = new FormData(this.parentNode.parentNode);
        form.append("operacion", "ingresar");
        iniciarPeticion(form, null);
    }

}




//iniciar petición con API fetch 
function iniciarPeticion(data, fn) {
    fetch("../dao/daoPrestamo.php", {
        method: "POST",
        body: data
    }).then((response) => {
        if (response.ok) {
            return response.json(); // Utiliza response.json() para manejar JSON
        } else {
            throw "Error en la inserción";
        }
    }).then((jsonResponse) => {
        // Manejar la respuesta JSON
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: jsonResponse.success ? 'success' : 'error',
            text: jsonResponse.message,
            timer: 1500
        })

        // cerrarModal(); // Si necesitas cerrar un modal, descomenta esta línea
    }).then(() => {
        //limpiarFormulario();
        setTimeout(() => {
            window.location.reload();
        }, 1500);
        if (fn != null) {
            fn(data);
        }
    }).catch(() => {
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: 'error',
            text: 'Ha fallado la petición',
            timer: 1500
        });
    });
}

function iniciarPeticionPago(data, fn) {
    fetch("../dao/daoPrestamo.php", {
        method: "POST",
        body: data
    }).then((response) => {
        if (response.ok) {
            return response.json(); // Utiliza response.json() para manejar JSON
        } else {
            throw "Error en la inserción";
        }
    }).then((jsonResponse) => {
        // Manejar la respuesta JSON
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: jsonResponse.success ? 'success' : 'error',
            text: jsonResponse.message,
            timer: 1500
        })
    }).then(() => {
        mostrar(idprestamo);
        Swal.fire({
            title: 'Generando comprobante...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        // Aquí puedes realizar cualquier lógica adicional antes de abrir la nueva pestaña

        // Después de realizar cualquier lógica adicional, abrir la nueva pestaña después de un retraso
        setTimeout(() => {
            window.open('../dao/fpdf/PruebaH.php?id=' + idCuota, '_blank');

            // Cierra el mensaje de carga después de un pequeño retraso (puedes ajustar el tiempo según tus necesidades)
            setTimeout(() => {
                Swal.close();
            }, 1000); // Ejemplo de retraso de 1 segundo (1000 milisegundos)
        }, 1000);
    }).catch(() => {
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: 'error',
            text: 'Ha fallado la petición',
            timer: 1500
        });
    });
}
//eliminar registro
function eliminar($id) {
    new $.Zebra_Dialog(
        "Eliminar al prestamo?",
        {
            type: "question",
            title: "Pregunta",
            custom_class: "myclass",
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
            fetch("../dao/daoPrestamo.php", {
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
    operacion = "ingresar";
}
function cerrarModal() {
    location.href = location.href;
}