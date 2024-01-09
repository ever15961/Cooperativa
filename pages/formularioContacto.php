<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listados Préstamos</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome CSS -->
    <link href="../css/all.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="../css/owl.carousel.min.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="../css/jquery.fancybox.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="../css/styleClient.css" rel="stylesheet">

    <!--<link href="../js/dataTable/dataTables.bootstrap5.min.css" rel="stylesheet">-->
    <link href="../js/dataTable/data/jquery.dataTables.min.css" rel="stylesheet">

    <link href="../css/zebra/css/flat/zebra_dialog.css" rel="stylesheet">

    <script src="../js/sweetalert/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    // Inicia la sesión
    session_start();

    // Verifica si la variable de sesión "user" está configurada
    if (isset($_SESSION["user"])) {
        // Accede al valor de la variable de sesión "user"
        $nombreUsuario = $_SESSION["user"];
        $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario
    


        $url = "../";
        $links = array(
            "movimientos" => "listadoPrestamos",
            "cuentas" => "listadoCuotas",
            "socios" => "listadoSocios",
            "roles" => "listadoRoles",
            "usuarios" => "listadoUsuarios",
            "tipoCuenta" => "listadoTipoCuenta",
            "tipoOperacion" => "listadoTipoOperacion",
            "tipoMovimiento" => "listadoTipoMovimiento",
            "cuotas" => "listadoCuotas",
            "cerrarSesion" => "cerrar",
            "amorti" => "listadoAmortPorSocio",
            "interes" => "listaInteres",
            "mora" => "listadoCuotaMora",
            "poranio" => "generar_reporte",
            "estadosp" => "generar_reporte_estado",
            "home" => "../index"
        );
        
        if (!isset($_SESSION["user"])) { ?>
            <script>location.href = "formularioInicio.php";</script>
        <?php }
        
        // Inicia la sesión
        
        $links = "";
        
        if ($_SESSION["rol"] == "Socio") {
        
            $links = array(
                "movimientos" => "listadoPrestamosSocio",
                "cuotas" => "listadoCuotasSocios",
                "cerrarSesion" => "cerrar",
                "home" => "../index"
            );
            include "menu/menuSocios.php";
        
        } else if ($_SESSION["rol"] == "Admin") {
            $links = array(
                "movimientos" => "listadoPrestamos",
                "cuentas" => "listadoCuotas",
                "socios" => "listadoSocios",
                "roles" => "listadoRoles",
                "usuarios" => "listadoUsuarios",
                "tipoCuenta" => "listadoTipoCuenta",
                "tipoOperacion" => "listadoTipoOperacion",
                "tipoMovimiento" => "listadoTipoMovimiento",
                "cerrarSesion" => "cerrar",
                "amorti" => "listadoAmortPorSocio",
                "mora" => "listadoCuotaMora",
                "interes" => "listaInteres",
                "poranio" => "generar_reporte",
                "estadosp" => "generar_reporte_estado",
                "home" => "../index"
            );
        
            include "menu/menu.php";
        } else {
            $links = array(
                "movimientos" => "listadoPrestamos",
                "cuentas" => "listadoCuotas",
                "socios" => "listadoSocios",
                "roles" => "listadoRoles",
                "usuarios" => "listadoUsuarios",
                "tipoCuenta" => "listadoTipoCuenta",
                "tipoOperacion" => "listadoTipoOperacion",
                "tipoMovimiento" => "listadoTipoMovimiento",
                "cerrarSesion" => "cerrar",
                "amorti" => "listadoAmortPorSocio",
                "mora" => "listadoCuotaMora",
                "interes" => "listaInteres",
                "poranio" => "generar_reporte",
                "estadosp" => "generar_reporte_estado",
                "home" => "../index"
            );
            include "menu/menu.php";
        }
        ?>
        <div class="contact-main">
            <div class="container">
                <!-- Content Row -->
                <div class="row">
                    <!-- Map Column -->
                    <div class="col-lg-8 mb-4 contact-left">
                        <h3>Envianos un mensaje</h3>
                        <form name="sentMessage" id="contactForm" novalidate>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <input type="text" placeholder="Nombre completo" class="form-control" id="name" required
                                        data-validation-required-message="Please enter your name.">
                                    <p class="help-block"></p>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <input type="tel" placeholder="Numero de telefono" class="form-control" id="phone"
                                        required data-validation-required-message="Please enter your phone number.">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <input type="email" placeholder="Correo electronico" class="form-control" id="email"
                                        required data-validation-required-message="Please enter your email address.">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <textarea rows="5" cols="100" placeholder="Mensaje" class="form-control" id="message"
                                        required data-validation-required-message="Please enter your message"
                                        maxlength="999" style="resize:none"></textarea>
                                </div>
                            </div>
                            <div id="success"></div>
                            <button type="submit" class="btn btn-primary" id="sendMessageButton">enviar mensaje</button>
                        </form>
                    </div>
                    <!-- Contact Details Column -->
                    <div class="col-lg-4 mb-4 contact-right">
                        <h3>Detalles de contacto</h3>
                        <p>
                            3ra Av Norte
                            <br>San Vicente, San Vicente
                            <br>
                        </p>
                        <p>
                            <abbr title="Phone">P</abbr>: (503) 2389-4321
                        </p>
                        <p>
                            <abbr title="Email">E</abbr>:
                            <a href="mailto:name@example.com"> name@example.com </a>
                        </p>
                        <p>
                            <abbr title="Hours">H</abbr>: Lunes - Viernes: 9:00 AM a 5:00 PM
                        </p>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>

        <div class="map-main">
            <!-- Embedded Google Map -->
            <iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.0427480813857!2d-88.83368858582275!3d13.641377990389003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f65c7a4c843afff%3A0xe1bf4d4df89dfc14!2sSan%20Vicente%2C%20El%20Salvador!5e0!3m2!1sen!2sus!4v1641721342673!5m2!1sen!2sus"></iframe>
        </div>
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../js/imagesloaded.pkgd.min.js"></script>
        <script src="../js/isotope.pkgd.min.js"></script>
        <script src="../js/filter.js"></script>
        <script src="../js/jquery.appear.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/jquery.fancybox.min.js"></script>
        <script src="../js/zebraDialog/zebra_dialog.src.js"></script>

        <script>
            // Agrega un manejador de eventos al formulario
            document.getElementById('contactForm').addEventListener('submit', function (event) {
                // Detiene la acción predeterminada del formulario
                event.preventDefault();

                // Utiliza SweetAlert para mostrar el mensaje
                Swal.fire({
                    icon: 'success',
                    title: 'Mensaje enviado con éxito',
                    showConfirmButton: false,
                    timer: 3000, // Ajusta el tiempo según tus necesidades
                }).then(function () {
                    // Recarga la página después de que SweetAlert se cierre
                    location.reload();
                });
            });
        </script>
        <?php
    } else {
        // Si la variable de sesión "user" no está configurada, muestra un SweetAlert
        echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Usuario no identificado. Redirigiendo a la página de inicio de sesión...',
                  showConfirmButton: true
              }).then(function() {
                  window.location.href = '../index.php';
              });
          </script>";
    }
    ?>
</body>

</html>F