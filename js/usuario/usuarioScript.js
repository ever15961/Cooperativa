$(document).ready(function () {
    iniciar();
});

function iniciar() {
    document.querySelector("#btnIniciarSesion").addEventListener("click", iniciarSesion);
    document.querySelector("#btnBuscarCorreo").addEventListener("click", buscarCorreo);
    document.querySelector("#btnComprobarCodigo").addEventListener("click", comprobarCodigo);
    document.querySelector("#btnActualizar").addEventListener("click", actualizarContra);

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