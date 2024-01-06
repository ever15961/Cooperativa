<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> Zonebiz - Business Consulting Bootstrap4 Responsive Template </title>
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

    <link href="../css/styleClient.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper-main p-5">
        <div class="container">
            <div class="card col-10 mx-auto border">
                <div class="row pt-4">
                    <div class="col-12 text-center">
                        <h4 class="text-center">Recuperación de cuenta</h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <form action="" id="claves">
                            <div class="form-group row" >
                                <div class="col-md-6">
                                    <label for="claveAct" class="bmd-label-floating">Contraseña</label>
                                    <input type="password" class="form-control" name="claveAct" id="claveAct"
                                        pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                                    <div class="progress mt-2">
                                        <div id="passwordStrengthBar1" class="progress-bar" role="progressbar"
                                            style="width: 0%;"></div>
                                    </div>
                                    <small id="passwordStrength1" class="form-text text-muted"></small>
                                </div>
                                <div class="col-md-6">
                                    <label for="claveAct2" class="bmd-label-floating">Repetir contraseña</label>
                                    <input type="password" class="form-control" name="claveAct2" id="claveAct2"
                                        pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <input type="submit" value="Actualizar" id="btnActualizar"
                                        class="btn btn-success active mt-4">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div id="fondo"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/filter.js"></script>
    <script src="../js/jquery.appear.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.fancybox.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/usuario/usuarioScript.js"></script>
    <script>
        $(document).ready(function () {
            $('#claveAct').on('input', function () {
                var password = $(this).val();
                var strength = 0;

                // Ajusta tus reglas para evaluar la fortaleza aquí
                // Puedes agregar más reglas según tus requisitos

                // Longitud mínima
                if (password.length >= 8) {
                    strength += 1;
                }

                // Contiene al menos un número
                if (/\d/.test(password)) {
                    strength += 1;
                }

                // Contiene al menos una letra minúscula y una letra mayúscula
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                    strength += 1;
                }

                // Contiene al menos un carácter especial
                if (/[$@.-]/.test(password)) {
                    strength += 1;
                }

                // Actualiza la barra de colores y el mensaje según la fortaleza
                var progress = (strength / 4) * 100;
                $('#passwordStrengthBar1').width(progress + '%');

                if (strength === 0) {
                    $('#passwordStrength1').text('Contraseña débil');
                    $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-danger');
                } else if (strength <= 2) {
                    $('#passwordStrength1').text('Contraseña moderada');
                    $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-warning');
                } else {
                    $('#passwordStrength1').text('Contraseña fuerte');
                    $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-success');
                }
            });
        });
    </script>
</body>

</html>