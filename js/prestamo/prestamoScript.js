var operacion = "ingresar";
window.onload = function () {
    cargarTablePrestamo();
    iniciarDescripcion();
    iniciar();
    iniciarPrestamoScript();
//    iniciarPrestamoScript();
}

function iniciar() {
  //  document.querySelector("#buscarSocio").addEventListener("click", buscarSocio);
    document.querySelector("#btnRegistrarPrestamo").addEventListener("click", registrarPrestamo);
    document.querySelector("#btnCerrarPrestamo").addEventListener("click",cerrarModal);
    
}
//iniciar clicks de bontones editar y eliminar
function iniciarPrestamoScript() {
    var botoneraEditar = $(".editar");
    var botoneraEliminar = $(".eliminar");
  //  var botoneraMostrar = $(".mostrar");


    for (var i = 0; i < botoneraEditar.length; i++) {
        botoneraEditar[i].addEventListener("click", mostrar);
        botoneraEliminar[i].addEventListener("click", mostrar);
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


function mostrar(event){    
 // Verificar si el parámetro es un objeto PointerEvent
 var id = event;

 // Si el parámetro es un objeto PointerEvent, intentar obtener el ID de un atributo personalizado
 if (event instanceof PointerEvent) {
     id = event.target.dataset.id || event.target.id;
 }

 // Crear FormData y realizar la solicitud fetch
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
     // Haz algo con la respuesta, por ejemplo, mostrarla en la consola
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

    var colorTextoEstado = (fila.estado === 1) ? 'green' : 'red'; // Cambia los colores según tus preferencias
    var colorBotonPagar = (fila.estado === 1) ? 'green' : 'red'; // Cambia los colores según tus preferencias
    var textoBotonPagar = (fila.estado === 1) ? 'Pagar' : 'Pagado';
    var botonInactivo = (fila.estado === 2) ? 'disabled' : '';
    var montoFormateado = '$' + parseFloat(fila.montoCuota).toFixed(2); // Agregar símbolo de dólar

    var filaHTML = '<tr>';
    filaHTML += '<td>' + fila.numeroCuota + '</td>';
    filaHTML += '<td>' + montoFormateado + '</td>'; // Usar el monto formateado con símbolo de dólar
    filaHTML += '<td>' + fila.fechavencimiento + '</td>';
    filaHTML += '<td style="color: ' + colorTextoEstado + ';">' + ((fila.estado === 1) ? 'Activo' : 'Inactivo') + '</td>';
    
    // Verificar si el botón debe estar habilitado o no
    var botonHabilitado = (fila.estado === 1 && (i === 0 || estadoCuotas[i - 1] === 'pagado')) ? '' : 'disabled';

    filaHTML += '<td><button style="background-color: ' + colorBotonPagar + '; color: white;" ' + botonInactivo + ' ' + botonHabilitado + ' onclick="confirmarPago(' + fila.id + ')">' + textoBotonPagar + '</button></td>';
    // ... Continuar con las demás columnas
    filaHTML += '</tr>';

    // Agregar la fila a la tabla
    tabla.append(filaHTML);

    // Actualizar el estado de la cuota actual en el array de estadoCuotas
    estadoCuotas.push(fila.estado === 2 ? 'pagado' : 'activo');
}
    
   
}else {
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
            // Aquí puedes agregar lógica adicional si el usuario confirma el pago
            console.log('Cuota pagada para el ID:', id);
        } else {
            // Aquí puedes agregar lógica adicional si el usuario cancela el pago
            console.log('Pago cancelado para el ID:', id);
        }
    });
}
function buscarSocio() {

    var form = new FormData();
    form.append("dato", document.querySelector("#socio").value);
    form.append("operacion","comprobarSocio");

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
    if(operacion=="ingresar"){
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
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'success',
                text: 'Registro guardardado con exito',
                timer: 1500 
              })
            return response.text();
        } else {
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'Error al registrar',
                timer: 1500 
              })
            throw "Error en la inserción";
        }

    }).then((response) => {
        if (fn != null) {
            fn(data);
        }
      //  cerrarModal();

    }).catch(() => {
        throw "Ha fallado la petición";
    });
}
function cerrarModal(){
    location.href = location.href;
}