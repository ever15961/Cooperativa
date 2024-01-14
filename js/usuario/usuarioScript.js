$(document).ready(function () {
    iniciar();
});

function iniciar() {
    document.querySelector("#btnIniciarSesion").addEventListener("click", iniciarSesion);
    document.querySelector("#btnBuscarCorreo").addEventListener("click", buscarCorreo);
    document.querySelector("#btnComprobarCodigo").addEventListener("click", comprobarCodigo);
    document.querySelector("#btnActualizar").addEventListener("click", actualizarContra);
    document.querySelector("#btnRegistrarSocio").addEventListener("click", registrarSocio);


}

//función que envia formulario de registro socio
function registrarSocio(e) {
    e.preventDefault();
    var form = new FormData(this.parentElement.parentElement);
        if (document.getElementById('nombres').value == "" || document.getElementById('apellidos').value == ""
            || document.getElementById('direccion').value == "" || document.getElementById('telefono').value == ""
            || document.getElementById('nIdentificacion').value == "" || document.getElementById('usuario').value == ""
            || document.getElementById('clave_').value == "" || document.getElementById('tipoIdentificacion').value == "0"
            || document.getElementById('correo').value == "") {
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: 'No has llenado todos los campos',
                timer: 1500
            })

        } else {
            if(validarCorreo(document.getElementById('correo').value)){
            if (verificarClave(document.getElementById('clave_').value)) {
                var tipoIdentificacion = document.getElementById('tipoIdentificacion').value;
                var nIdentificacion = document.getElementById('nIdentificacion').value;
                var numero = document.getElementById('telefono').value;
                // Validar tipo de identificación
                switch (parseInt(tipoIdentificacion)) {
                    case 1: // DUI
                        if (isDUI(nIdentificacion)) {
                            if (verificarTelefono(numero)) {
                                form.append("operacion", "ingresarSocio");
                                iniciarPeticion(form, null, e);
                            } else {
                                mostrarError('Formato telefono invalido');
                            }
                        } else {
                            mostrarError('Formato DUI inválido');
                        }
                        break;
                    case 2: // NIT
                        if (isNIT(nIdentificacion)) {
                            if (verificarTelefono(numero)) {
                                form.append("operacion", "ingresarSocio");
                                form.append("id", id);
                                iniciarPeticion(form, null, e);
                            } else {
                                mostrarError('Formato telefono invalido');
                            }
                        } else {
                            mostrarError('Formato NIT inválido');
                        }
                        break;
                    case 3: // Pasaporte salvadoreño
                        if (isSalvadoranPassportValid(nIdentificacion)) {
                            if (verificarTelefono(numero)) {
                                form.append("operacion", "ingresarSocio");
                                form.append("id", id);
                                iniciarPeticion(form, null, e);
                            } else {
                                mostrarError('Formato telefono invalido');
                            }
                        } else {
                            mostrarError('Formato Pasaporte inválido');
                        }
                        break;
                    default:
                        mostrarError('Tipo de identificación no válido');
                }

            } else {
                Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'error',
                    html: 'La contraseña no cumple con los requisitos:<br>' +
                        '- Al menos una letra mayúscula<br>' +
                        '- Al menos un número<br>' +
                        '- Al menos un carácter especial',
                    timer: 5000
                });
            }
        }else{
                Swal.fire({
                    position: "top-end",
                    title: 'System',
                    showConfirmButton: false,
                    icon: 'error',
                    html: 'Correo invalido',
                    timer: 5000
                });
            }


        }
    } 

function validarCorreo(correo) {
    // Expresión regular para validar el formato de un correo electrónico
    var regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Verificar si el correo cumple con el formato
    return regexCorreo.test(correo);
}



//iniciar petición con API fetch 
function iniciarPeticion(data, fn, event) {
    // Extraer la operación de data
    const operacion = data.get("operacion");

    if (operacion === "ingresarSocio") {
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
               setTimeout(() => {
                    window.location.reload();
                }, 1500);
                if (fn != null) {
                    fn(data);
                }
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
}


function actualizarContra(e) {
    e.preventDefault();
    if (document.getElementById('claveAct').value == document.getElementById('claveAct2').value) {
        if (verificarClave(document.getElementById('claveAct').value)) {
            var form = new FormData(document.getElementById('claves'));

            form.append("operacion", "actualizar");

            fetch("../dao/daoUsuario.php", {
                method: "POST",
                body: form
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

                    location.reload();
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
            Swal.fire({
                position: "top-end",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                html: 'La contraseña no cumple con los requisitos:<br>' +
                    '- Al menos una letra mayúscula<br>' +
                    '- Al menos un número<br>' +
                    '- Al menos un carácter especial',
                timer: 5000
            });
        }
    } else {
        Swal.fire({
            position: "top-end",
            title: 'System',
            showConfirmButton: false,
            icon: 'error',
            text: 'Las claves no coinciden',
            timer: 1500
        })

    }
}

function verificarClave(clave) {
    // La expresión regular requiere al menos una letra mayúscula, al menos un número y al menos un carácter especial
    var regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).+$/;
    return regex.test(clave);
}

function comprobarCodigo(e) {
    e.preventDefault();


    var form = new FormData(this.parentElement.parentElement);
    form.append("operacion", "comprobarCodigo");

    fetch("../dao/daoUsuario.php", {
        method: "POST",
        body: form
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

            $('#modalCodigo').modal('hide');

            // Abrir el nuevo modal con el contenido deseado
            $('#modalContra').modal('show');
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

function buscarCorreo(e) {
    e.preventDefault();


    var form = new FormData(this.parentElement.parentElement);
    form.append("operacion", "buscarCorreo");

    fetch("../dao/daoUsuario.php", {
        method: "POST",
        body: form
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

            $('#modalBuscarCorreo').modal('hide');

            // Abrir el nuevo modal con el contenido deseado
            $('#modalCodigo').modal('show');
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


function iniciarSesion(e) {
    e.preventDefault();


    var form = new FormData(this.parentElement.parentElement);
    form.append("operacion", "iniciarSesion");

    fetch("../dao/daoUsuario.php", {
        method: "POST",
        body: form
    }).then((response) => {
        if (response.ok) {
            return response.json(); // Espera un JSON en lugar de texto
        } else {
            throw "Ha fallado la petición";
        }
    }).then((data) => {
        if (data.success) {
            Swal.fire({
                position: "center",
                title: 'System',
                showConfirmButton: false,
                icon: 'success',
                text: data.message + data.usuario,
                timer: 1500
            });
            redirect();
        } else {
            Swal.fire({
                position: "center",
                title: 'System',
                showConfirmButton: false,
                icon: 'error',
                text: data.message,
                timer: 1500
            });
        }
    }).catch(() => {
        console.log("error en la petición");
    })
}

function redirect() {
    location.href = "../";
}
var isDUI = function (str) {
    var regex = /(^\d{8})-(\d$)/,
        parts = str.match(regex);
    // verficar formato y extraer digitos junto al digito verificador
    if (parts !== null) {
        var digits = parts[1],
            dig_ve = parseInt(parts[2], 10),
            sum = 0;
        // sumar producto de posiciones y digitos
        for (var i = 0, l = digits.length; i < l; i++) {
            var d = parseInt(digits[i], 10);
            sum += (9 - i) * d;
        }
        return dig_ve === (10 - (sum % 10)) % 10;
    } else {
        return false;
    }
};

var isNIT = function (str) {
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
var isSalvadoranPassportValid = function (str) {
    // Verificar si la longitud del pasaporte es 8
    if (str.length !== 8) {
        return false;
    }

    // Aplicar la expresión regular para validar el formato del pasaporte salvadoreño
    var regex = /^[A-Z]{1}\d{7}$/;
    return regex.test(str);
};

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

function limpiarFormulario() {

    $("#nombres").val("");
    $("#apellidos").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#nIdentificacion").val("");
    $("#tipoIdentificacion").val(0);

    $("#usuario").val("");
    $("#clave_").val("");

    $("#btnRegistrarSocio").val("Registrar Socio");
}
