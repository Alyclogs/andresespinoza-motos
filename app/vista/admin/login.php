<?php
include_once '../../modelo/Sesion.php';
include_once '../../modelo/usuario.php';
session_start();

if (isset($_SESSION['sesion'])) {
    $sesion = $_SESSION['sesion'];

    if ($sesion->usuario->getRol() === '3') {
        session_destroy();
        header("Location: login.php");
    }
    if (isset($_GET['logout'])) {
        $sesion->cerrarSesion($sesion->usuario->getId());
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andres Espinoza motos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/assets/css/admin_login.css">
</head>

<body>
    <section id="loginSection" class="vh-100">
        <div class="container-fluid h-100">
            <div class="row px-4 h-100 align-items-center">
                <div class="col-md-4 col-md-auto">

                    <form action="../../../app/controlador/ingresar.php" class="text-center text-white" method="post">

                        <img src="../../../public/assets/img/logo-110x51px-borders.png" alt="Logo 110x51">
                        <h3 class="mb-5 mt-3">Iniciar sesión</h3>

                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="pass" id="pass" required>
                        </div>
                        <div class="mb-3 form-check text-start">
                            <input type="checkbox" class="form-check-input" id="cbxrecordar" name="cbxrecordar">
                            <label class="form-check-label" for="cbxrecordar">Recordarme</label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" style="background-color: rgba(240, 84, 41);">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="usuarioNoExisteModal" tabindex="-1" role="dialog" aria-labelledby="usuarioNoExisteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usuarioNoExisteModalLabel">Mensaje de Usuario No Existe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    El usuario ingresado no existe.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../public/script.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>