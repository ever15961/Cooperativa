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
        data.append("operacion", "obtenerCuotasPagadasSocio");

    } else if (tipo.endsWith("2")) {
        data.append("operacion", "obtenerCuotasNoPagadasSocios");

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
            return request.text();
        }else{
            throw "Error en la petición";
        }
    }).then((request) => {
            imprimirCuotasCondicionadas(request);
    }).catch((error) => {
        return error;
    })

}

function imprimirCuotasCondicionadas(data){
    var body = $("#cuotasCuerpo")[0];
    body.innerHTML = data;

}

var limpiarCodigo = () => {
    $("#cuota")[0].value=0;
    $("#cuota")[0].removeAttribute("disabled");
    $("#cuotasCuerpo")[0].innerHTML="";
    $("#listadoCuotas")[0].classList.add("hide");
    $("#detallePrestamo")[0].classList.add("hide");

    $("#tipoCuota").val(0);
}

var obtenerCuotasPrestamo = () => {

    codigoPrestamo = $("#cuota").val();

    if(codigoPrestamo==="0"){
        mensajeErrorPrestamo();
        return;
    }

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

    $("#codigo")[0].innerHTML=detalle.codigo;
  
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

    var botonDesactivado = "";
    var cuotasNoPagadas = 0;

    for (var i = 0; i < cuotas.length; i++) {
        fila = document.createElement("tr");

        numeroCuota = document.createElement("td");
        numeroCuota.innerText = cuotas[i].numCuota;

        monto = document.createElement("td");
        monto.innerText = "$" + cuotas[i].montoCuota.toFixed(2);

        vencimiento = document.createElement("td");
        vencimiento.innerText = cuotas[i].fechavencimiento;

        filaBtn = document.createElement("td");

        estadoStr = "Pagada";

        if (cuotas[i].estado == 1) {
            estadoStr = "No Pagada";
        }

         
        estado = document.createElement("td");
        estado.innerText = estadoStr;

        fila.appendChild(numeroCuota);
        fila.appendChild(monto);
        fila.appendChild(vencimiento);
        fila.appendChild(estado);
        tablaCuotas.appendChild(fila);
    }

    document.querySelector("#detallePrestamo").classList.remove("hide");
    document.querySelector("#listadoCuotas").classList.remove("hide");

}


function mensajeExito() {
    Swal.fire({
        position: "center",
        title: 'Información',
        showConfirmButton: false,
        icon: 'success',
        text: "Cuota pagada correctamente!",
        timer: 1500
    });
}

function mensajeErrorPrestamo() {
    Swal.fire({
        position: "center",
        title: 'Información',
        showConfirmButton: false,
        icon: 'error',
        text: "Seleccione préstamo!",
        timer: 1500
    });
}


