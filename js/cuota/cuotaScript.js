var codigoPrestamo = 0;

$(document).ready(function () {
    //new DateTable("#listadoCuotas");

    iniciarBuscar();
});


var iniciarBuscar = () => {
    $("#buscarcuota").click(obtenerCuotasPrestamo);
    $("#limpiarBusqueda").click(limpiarCodigo);
    $("#tipoCuota").change(setearCuotas);
}

var setearCuotas = () => {
    var tipo = $("#tipoCuota").val();

    var data = new FormData();

    data.append("codigo", $("#cuota").val());

    if (tipo.endsWith("1")) {
        data.append("operacion", "obtenerCuotasPagadas");

    } else if (tipo.endsWith("2")) {
        data.append("operacion", "obtenerCuotasNoPagadas");

    } else {
        obtenerCuotasPrestamo();
        return;
    }

    fetch("../dao/daoCuota.php",
        {
            method: "POST",
            body: data
        }
    ).then((request) => {
        if(request.ok){
            return request.json();
        }else{
            throw "Error en la petición";
        }
    }).then((request) => {
            imprimirDetallePrestamo(request);
    }).catch((error) => {
        return error;
    })

}

function imprimirCuotasCondicionadas(data){
    var body = $("#cuotasCuerpo")[0];
    body.innerHTML = data;
    setearEventos();
}

var limpiarCodigo = () => {
    $("#cuota").val("");
    $("#cuota")[0].removeAttribute("disabled");
    $("#cuotasCuerpo")[0].innerHTML="";
    $("#listadoCuotas")[0].classList.add("hide");
    $("#detallePrestamo")[0].classList.add("hide");

    $("#tipoCuota").val(0);
}

var obtenerCuotasPrestamo = () => {
    codigoPrestamo = $("#cuota").val();

    $("#cuota")[0].setAttribute("disabled","true");

    var data = new FormData();
    data.append("codigo", codigoPrestamo);
    data.append("operacion", "obtenerCuotas");

    fetch(
        "../dao/daoCuota.php",
        {
            method: "POST",
            body: data
        }
    ).then((request) => {
        if (request.ok) {
            return request.json();
        } else {
            throw "Error en la petición";
        }
    }).then((request) => {
        // var data = request;
        imprimirDetallePrestamo(request);

    }).catch((error) => {
        return error;
    });
}

function imprimirDetallePrestamo(data) {
    var tipo = $("#tipoCuota")[0];
    tipo.removeAttribute("disabled");

    var detalle = data[0];
    var cuotas = data[1];

    $("#codigo").html(detalle.codigo);
    $("#monto").html("$" + detalle.monto);
    $("#nombre").html(detalle.nombre);
    $("#plazo").html(detalle.plazo);
    $("#tipo").html(detalle.destino);

    imprimirCuotas(cuotas);

}


function imprimirCuotas(cuotas) {
    var tablaCuotas = document.querySelector("#cuotasCuerpo");
    tablaCuotas.innerHTML = "";
    var fila, numeroCuota, monto, vencimiento, estado, btnPagar, filaBtn, estadoStr;

    var cuotaAnteriorPagada = true; // Variable para rastrear si la cuota anterior está pagada


    for (var i = 0; i < cuotas.length; i++) {
        fila = document.createElement("tr");

        numeroCuota = document.createElement("td");
        numeroCuota.innerText = cuotas[i].numCuota;

        monto = document.createElement("td");
        monto.innerText = "$" + cuotas[i].montoCuota.toFixed(2);
        monto.classList.add("text-success");

        vencimiento = document.createElement("td");
        vencimiento.innerText = cuotas[i].fechavencimiento;

        filaBtn = document.createElement("td");

        if (cuotas[i].estado == 1) {
            // Calcular si la cuota está en mora comparando la fecha de vencimiento con la fecha actual
            var fechaVencimiento = new Date(cuotas[i].fechavencimiento);
            var fechaActual = new Date();

            if (fechaVencimiento < fechaActual) {
                // Cuota en mora
                estadoStr = "Mora";
                btnPagar = document.createElement("button");
                btnPagar.innerText = "Pagar";
                btnPagar.classList.add("btn");
                btnPagar.classList.add("bg-danger");
                btnPagar.classList.add("text-light");
                btnPagar.addEventListener("click", pagarCuota);
                btnPagar.disabled = !cuotaAnteriorPagada; // Deshabilitar si la cuota anterior no está pagada
                filaBtn.appendChild(btnPagar);
            } else {
                // Cuota no en mora
                estadoStr = "No Pagada";
                btnPagar = document.createElement("button");
                btnPagar.innerText = "Pagar";
                btnPagar.classList.add("btn");
                btnPagar.classList.add("bg-success");
                btnPagar.classList.add("text-light");
                btnPagar.addEventListener("click", pagarCuota);
                btnPagar.disabled = !cuotaAnteriorPagada; // Deshabilitar si la cuota anterior no está pagada
                filaBtn.appendChild(btnPagar);
            }

            // Actualizar el estado de cuotaAnteriorPagada
            cuotaAnteriorPagada = false;
        } else {
            // Cuota pagada
            estadoStr = "Pagada";
            btnPagar = document.createElement("button");
            btnPagar.innerText = "Pagada";
            btnPagar.classList.add("btn");
            btnPagar.classList.add("bg-secondary");
            btnPagar.classList.add("text-light");
            btnPagar.disabled = true;
            filaBtn.appendChild(btnPagar);
        }

        estado = document.createElement("td");
        estado.innerText = estadoStr;

        estado.classList.add(getEstadoColorClass(estadoStr));

        fila.appendChild(numeroCuota);
        fila.appendChild(monto);
        fila.appendChild(vencimiento);
        fila.appendChild(estado);
        fila.appendChild(filaBtn);
        tablaCuotas.appendChild(fila);
    }

    document.querySelector("#detallePrestamo").classList.remove("hide");
    document.querySelector("#listadoCuotas").classList.remove("hide");
}

function getEstadoColorClass(estadoStr) {
    switch (estadoStr) {
        case "Mora":
            return "text-warning"; // Amarillo para cuotas en mora
        case "No Pagada":
            return "text-danger"; // Rojo para cuotas no pagadas
        case "Pagada":
            return "text-success"; // Verde para cuotas pagadas
        default:
            return ""; // Por defecto, no se agrega ninguna clase de color
    }
}


function pagarCuota(e) {
        Swal.fire({
            title: '¿Desea pagar la cuota?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, pagar'
        }).then((result) => {
            if (result.isConfirmed) {
         
    var table = this.parentNode.parentNode;
    numCuota = table.children[0].innerText;
    var targ = e.target;

    var data = new FormData();
    data.append("numCuota", numCuota);
    data.append("codigo", codigoPrestamo);
    data.append("operacion", "obtenerIdCuota");

    fetch("../dao/daoCuota.php", {
        method: "POST",
        body: data
    }
    ).then((request) => {
        if (request.ok) {
            return request.json();
        } else {
            throw "Error en la petición";
        }
    }).then((request) => {
        obtenerCuotasPrestamo();
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
                window.open('../dao/fpdf/Factura.php?id=' + request.id, '_blank');
                
                // Cierra el mensaje de carga después de un pequeño retraso (puedes ajustar el tiempo según tus necesidades)
                setTimeout(() => {
                  Swal.close();
                }, 1000); // Ejemplo de retraso de 1 segundo (1000 milisegundos)
              }, 1000);
          
    }).catch((error) => {
        return error;
    })
            } else {
                // Aquí puedes agregar lógica adicional si el usuario cancela el pago
                console.log('Pago cancelado para el ID:', id);
            }
        });
    
}

function ocultarBotonPagar(data, targ) {
    if (data.respuesta == 0) {
        var component = targ.parentNode.parentNode;
        component.children[3].innerText = "Pagada";
        targ.classList.add("hide");

    }
}
