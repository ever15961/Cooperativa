var operacion = "ingresar";
var row = -1;
var id=0;
var claveNueva=false;

//cargar complementos
$(document).ready(function () {
    $("#nuevaCon").hide();
    cargarTableUsuarios();
  //  iniciarUsuariosScript();
    iniciarDescripcion();
    //iniciando componentes
    iniciar();
});

//descripcion de tipo de documento en tabla
function iniciarDescripcion() {
    $("[data-toggle='tooltip'").tooltip();
}

//cargar datatable
function cargarTableUsuarios() {
    var tabla = $("#listadoUsuarios").DataTable();

}

//iniciar clicks de bontones editar y eliminar
function iniciarUsuariosScript() {
    var botoneraIngresar = $(".ingresar");
    var botoneraEditar = $(".editar");
    var botoneraEliminar = $(".eliminar");
    botoneraIngresar[0].addEventListener("click", ingresar);


    for (var i = 0; i < botoneraEditar.length; i++) {
        botoneraEditar[i].addEventListener("click", modificar);
        botoneraEliminar[i].addEventListener("click", eliminar);
    }
}




//eliminar registro
function eliminar($id) {
    new $.Zebra_Dialog(
        "Eliminar al usuario?",
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
        fetch("../dao/daoUsuario.php", {
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



//setear valores de tabla en formulario
function modificar($id,elemento) {
    operacion = "editar";
    id=$id;
    var tr = elemento.closest("tr");
    var collTd = tr.children;
    $("#nombres").val(collTd[2].innerText);
    $("#apellidos").val(collTd[3].innerText);

    $("#nIdentificacion").val(collTd[4].innerText);
    $("#infoCuen").hide();
    $("#nuevaCon").show();


    
    $("#btnRegistrarUsuario").val("Modificar Usuario");

    var tIdentificacionText = collTd[4].dataset.originalTitle;

    var select = document.querySelector("#tipoIdentificacion");
    var options = select.options;

    for (var i = 0; i < options.length; i++) {
        if (options[i].text.toLowerCase() == tIdentificacionText.toLowerCase()) {
            select.value = options[i].value;
        }
    }

    var rolText = collTd[5].innerText;
    var rolText = collTd[5].innerText.trim();  // Utiliza trim() para quitar espacios al principio y al final
    var select2 = document.querySelector("#usuario_privilegio");
    var opcion = select2.options;
    
    for (var j = 0; j < opcion.length; j++) {
        // Utiliza trim() para quitar espacios al principio y al final de la opción del select
        var opcionText = opcion[j].text.trim();
    
        if (opcionText.toLowerCase() == rolText.toLowerCase()) {
            select2.value = opcion[j].value;
            return;
        }
    }

}


//iniciar elementos html necesarios para ingreso o modificacion
function iniciar() {
    document.querySelector("#btnRegistrarUsuario").addEventListener("click", registrarUsuario);
    document.querySelector("#btnCerrarUsuario").addEventListener("click",cerrarModal);
}

//función que envia formulario de registro usuario
function registrarUsuario(e) {
    e.preventDefault();
    var form = new FormData(this.parentNode.parentNode);
    if(operacion=="ingresar"){
    if(document.getElementById('nombres').value == "" || document.getElementById('apellidos').value == ""
    || document.getElementById('nIdentificacion').value == "" || document.getElementById('tipoIdentificacion').value == "0"
    || document.getElementById('clave').value == "" || document.getElementById('clave2').value == ""
    || document.getElementById('usuario_privilegio').value == "0"){
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: 'error',
            text: 'No has llenado todos los campos',
            timer: 1500 
          })
        
        }else if(document.getElementById('clave').value == document.getElementById('clave2').value){
            var tipoIdentificacion = document.getElementById('tipoIdentificacion').value;
            var nIdentificacion = document.getElementById('nIdentificacion').value;
        
                // Validar tipo de identificación
switch (parseInt(tipoIdentificacion)) {
    case 1: // DUI
        if (isDUI(nIdentificacion)) {
            form.append("operacion", operacion);
            iniciarPeticion(form, null, e);
        } else {
            mostrarError('Formato DUI inválido');
        }
        break;
    case 2: // NIT
        if (isNIT(nIdentificacion)) {
            form.append("operacion", operacion);
            iniciarPeticion(form, null, e);
        } else {
            mostrarError('Formato NIT inválido');
        }
        break;
    default:
        mostrarError('Tipo de identificación no válido');

    }
    
    
}else{
    Swal.fire({
        position: "top-end",
        title: 'System',
        showConfirmButton: false,
        icon: 'error',
        text: 'Las claves no coinciden',
        timer: 1500 
      })  
}
}else {
    if(document.getElementById('nombres').value == "" || document.getElementById('apellidos').value == ""
    || document.getElementById('nIdentificacion').value == "" || document.getElementById('tipoIdentificacion').value == "0"
    || document.getElementById('usuario_privilegio').value == "0"){
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: 'error',
            text: 'No has llenado todos los campos',
            timer: 1500 
          })
        
        }else {

            if(!document.getElementById('usuario_clave_nueva_1').value == "" || !document.getElementById('usuario_clave_nueva_2').value == ""){
                if(document.getElementById('usuario_clave_nueva_1').value== document.getElementById('usuario_clave_nueva_2').value){
                claveNueva=true;
                }else{              
                    Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'error',
                    text: 'Las claves no coinciden',
                    timer: 1500 
                  }) }
            }
                var tipoIdentificacion = document.getElementById('tipoIdentificacion').value;
                var nIdentificacion = document.getElementById('nIdentificacion').value;
                form.append("clavenueva",claveNueva);
            
                    // Validar tipo de identificación
    switch (parseInt(tipoIdentificacion)) {
        case 1: // DUI
            if (isDUI(nIdentificacion)) {
                
                form.append("operacion", "editar");
        form.append("id",id);
        iniciarPeticion(form, null,e);
            } else {
                mostrarError('Formato DUI inválido');
            }
            break;
        case 2: // NIT
            if (isNIT(nIdentificacion)) {
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
            } else {
                mostrarError('Formato NIT inválido');
            }
            break;
        default:
            mostrarError('Tipo de identificación no válido');
    
            }
        }
        }
    
    }


//iniciar petición con API fetch 
function iniciarPeticion(data, fn) {
   // Extraer la operación de data
   const operacion = data.get("operacion");

   if (operacion === "ingresar") {
       // Si la operación es "ingresar", realizar la acción directamente sin pedir la contraseña
       fetch("../dao/daoUsuario.php", {
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

               fetch("../dao/daoUsuario.php", {
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
var isDUI = function(str){
    var regex = /(^\d{8})-(\d$)/,
        parts = str.match(regex);
     // verficar formato y extraer digitos junto al digito verificador
     if(parts !== null){
       var digits = parts[1],
           dig_ve = parseInt(parts[2], 10),
           sum    = 0;
       // sumar producto de posiciones y digitos
       for(var i = 0, l = digits.length; i < l; i++){
         var d = parseInt(digits[i], 10);
         sum += ( 9 - i ) * d;
       }
       return dig_ve === (10 - ( sum % 10 ))%10;
     }else{
       return false;
     }
 };

 var isNIT = function(str) {
    // Expresión regular para validar formato NIT
    var regex = /^\d{4}-\d{6}-\d{3}-\d{1}$/;
    
    // Verificar si el formato del NIT es correcto
    if (!regex.test(str)) {
        return false;
    }

    // Eliminar guiones y espacios en blanco del NIT
    var nitDigits = str.replace(/[-\s]/g, '');

    // Extraer los dígitos y el dígito verificador
    var digits = nitDigits.substring(0, nitDigits.length - 1);
    var digVerificador = parseInt(nitDigits.charAt(nitDigits.length - 1), 10);

    // Calcular el dígito verificador esperado
    var sum = 0;
    for (var i = 0, l = digits.length; i < l; i++) {
        var d = parseInt(digits[i], 10);
        sum += (l - i + 1) * d;
    }

    var digVerificadorCalculado = (11 - (sum % 11)) % 11;

    // Comparar el dígito verificador calculado con el proporcionado
    return digVerificador === digVerificadorCalculado;
};
function limpiarFormulario() {

    $("#nombres").val("");
    $("#apellidos").val("");
    $("#nIdentificacion").val("");
    $("#usuario").val("");
    $("#clave").val("");
    $("#tipoIdentificacion").val(0);
    $("#usuario_privilegio").val(0);
    claveNueva=false;
}

function cerrarModal(){
    location.href = location.href;
}