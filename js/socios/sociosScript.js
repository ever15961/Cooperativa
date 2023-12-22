var operacion = "ingresar";
var id=0;
var pass="";

//cargar complementos
$(document).ready(function () {
    cargarTableSocio();
    //iniciarSociosScript();
    iniciarDescripcion();
    //iniciando componentes
    iniciar();
    // Configura tu modal para que no se cierre automáticamente
});

//descripcion de tipo de documento en tabla
function iniciarDescripcion() {
    $("[data-toggle='tooltip'").tooltip();
}

//cargar datatable
function cargarTableSocio() {
    var tabla = $("#listadoSocios").DataTable();

}

//iniciar clicks de bontones editar y eliminar
function iniciarSociosScript() {
    var botoneraEditar = $(".editar");
    var botoneraEliminar = $(".eliminar");


    for (var i = 0; i < botoneraEditar.length; i++) {
        botoneraEditar[i].addEventListener("click", modificar);
        botoneraEliminar[i].addEventListener("click", eliminar);
    }
}



//eliminar registro
function eliminar($id) {
    new $.Zebra_Dialog(
        "Eliminar al socio?",
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
            fetch("../dao/daoSocio.php", {
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

    $("#nombres").val(collTd[2].innerText);
    $("#apellidos").val(collTd[3].innerText);
    $("#direccion").val(collTd[4].innerText);
    $("#telefono").val(collTd[6].innerText);
    $("#nIdentificacion").val(collTd[5].innerText);

    $("#usuario").hide();
    $("#clave").hide();
    $("[for='usuario']").hide();
    $("[for='clave']").hide();
    $("#btnRegistrarSocio").val("Modificar Socio");

    var tIdentificacionText = collTd[5].dataset.originalTitle;

    var select = document.querySelector("#tipoIdentificacion");
    var options = select.options;

    for (var i = 0; i < options.length; i++) {
        if (options[i].text.toLowerCase() == tIdentificacionText.toLowerCase()) {
            select.value = options[i].value;
            return;
        }
    }

}


//iniciar elementos html necesarios para ingreso o modificacion
function iniciar() {
    document.querySelector("#btnRegistrarSocio").addEventListener("click", registrarSocio);
    document.querySelector("#btnCerrarSocio").addEventListener("click",cerrarModal);
}

//función que envia formulario de registro socio
function registrarSocio(e) {
    e.preventDefault();
    var form = new FormData(this.parentNode.parentNode);

    if (operacion == "ingresar") {
        if(document.getElementById('nombres').value == "" || document.getElementById('apellidos').value == ""
        || document.getElementById('direccion').value == "" || document.getElementById('telefono').value == ""
        || document.getElementById('nIdentificacion').value == "" || document.getElementById('usuario').value == ""
        || document.getElementById('clave').value == "" || document.getElementById('tipoIdentificacion').value == "0"){
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'No has llenado todos los campos',
                timer: 1500 
              })
            
            }else {
                var tipoIdentificacion = document.getElementById('tipoIdentificacion').value;
                var nIdentificacion = document.getElementById('nIdentificacion').value;
            
                    // Validar tipo de identificación
    switch (parseInt(tipoIdentificacion)) {
        case 1: // DUI
            if (isDUI(nIdentificacion)) {
                if(verificarTelefono(numero)){
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
                    }else{
                        mostrarError('Formato telefono invalido');
                    }
            } else {
                mostrarError('Formato DUI inválido');
            }
            break;
        case 2: // NIT
            if (isNIT(nIdentificacion)) {
                if(verificarTelefono(numero)){
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
                    }else{
                        mostrarError('Formato telefono invalido');
                    }
            } else {
                mostrarError('Formato NIT inválido');
            }
            break;
        case 3: // Pasaporte salvadoreño
            if (isSalvadoranPassportValid(nIdentificacion)) {
                if(verificarTelefono(numero)){
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
                    }else{
                        mostrarError('Formato telefono invalido');
                    }
            } else {
                mostrarError('Formato Pasaporte inválido');
            }
            break;
        default:
            mostrarError('Tipo de identificación no válido');
    }

        }
        
        

    } else {
        if(document.getElementById('nombres').value == "" || document.getElementById('apellidos').value == ""
        || document.getElementById('direccion').value == "" || document.getElementById('telefono').value == ""
        || document.getElementById('nIdentificacion').value == "" || document.getElementById('tipoIdentificacion').value == "0"){
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'No has llenado todos los campos',
                timer: 1500 
              })
            
            }else{
                var tipoIdentificacion = document.getElementById('tipoIdentificacion').value;
                var nIdentificacion = document.getElementById('nIdentificacion').value;
                var numero = document.getElementById('telefono').value;
            
                    // Validar tipo de identificación
    switch (parseInt(tipoIdentificacion)) {
        case 1: // DUI
            if (isDUI(nIdentificacion)) {
                if(verificarTelefono(numero)){
                form.append("operacion", "editar");
        form.append("id",id);
        iniciarPeticion(form, null,e);
                }else{
                    mostrarError('Formato telefono invalido');
                }
            } else {
                mostrarError('Formato DUI inválido');
            }
            break;
        case 2: // NIT
            if (isNIT(nIdentificacion)) {
                if(verificarTelefono(numero)){
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
                    }else{
                        mostrarError('Formato telefono invalido');
                    }
            } else {
                mostrarError('Formato NIT inválido');
            }
            break;
        case 3: // Pasaporte salvadoreño
            if (isSalvadoranPassportValid(nIdentificacion)) {
                if(verificarTelefono(numero)){
                    form.append("operacion", "editar");
            form.append("id",id);
            iniciarPeticion(form, null,e);
                    }else{
                        mostrarError('Formato telefono invalido');
                    }
            } else {
                mostrarError('Formato Pasaporte inválido');
            }
            break;
        default:
            mostrarError('Tipo de identificación no válido');
    }
    }}

    
}

//iniciar petición con API fetch 
function iniciarPeticion(data, fn, event) {
    // Extraer la operación de data
    const operacion = data.get("operacion");

    if (operacion === "ingresar") {
        // Si la operación es "ingresar", realizar la acción directamente sin pedir la contraseña
        fetch("../dao/daoSocio.php", {
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

                fetch("../dao/daoSocio.php", {
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

function verificarTelefono(telefono) {

    // Expresión regular para validar un número de teléfono en El Salvador
    // Asumiendo formato de 8 dígitos (sin incluir el prefijo internacional)
    var regex = /^[267]\d{7}$/;

    // Verificar si el número de teléfono cumple con la expresión regular
    if (regex.test(telefono)) {
        return true;
    } else {
        return false;
    }
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
var isSalvadoranPassportValid = function(str) {
    // Verificar si la longitud del pasaporte es 8
    if (str.length !== 8) {
        return false;
    }

    // Aplicar la expresión regular para validar el formato del pasaporte salvadoreño
    var regex = /^[A-Z]{1}\d{7}$/;
    return regex.test(str);
};
function limpiarFormulario() {

    $("#nombres").val("");
    $("#apellidos").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#nIdentificacion").val("");
    $("#tipoIdentificacion").val(0);

    $("#usuario").val("");
    $("#clave").val("");
    
    $("#btnRegistrarSocio").val("Registrar Socio");
}

function cerrarModal(){
    location.href = location.href;
}