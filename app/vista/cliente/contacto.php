<?php
include_once '../../modelo/Sesion.php';
include_once '../../modelo/usuario.php';
session_start();

if (isset($_SESSION['sesion'])) {
    $sesion = $_SESSION['sesion'];

    if (isset($_GET['logout'])) {
        $sesion->cerrarSesion($sesion->usuario->getId());
        header("Location: tienda.php");
        session_destroy();
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andres Espinoza motos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/admin_dashboard.css">
    <script src="../../../public/assets/js/utils.js"></script>
</head>

<body style="background: url('../../../public/assets/img/1711.jpg') no-repeat center;">

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top p-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../../../public/assets/img/logo-txt-235x43px.png" alt="Logo Andres Espinoza Motos">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" href="./tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contacto.php">Contacto</a>
                        </li>
                    </ul>
                    <?php

                    if (isset($_SESSION['sesion'])) {
                        $sesion = $_SESSION['sesion'];
                        $usuario = $sesion->usuario;

                        if ($usuario) {
                    ?>
                            <div class="nav-item dropdown ms-auto align-items-center">
                                <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-3" style="font-size: x-large;"></i><?php echo $usuario->getNombre() ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Mi cuenta</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="?logout=true">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="ms-auto">
                            <button class="btn" id="btnMostrarPopup" style="border-radius: 30px; background-color: rgba(240, 84, 41); color: white;">Iniciar sesión</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <section class="vh-100" style="margin-top: 150px;">
        <div class="container mt-4 h-100">
            <div class="d-flex align-items-center justify-content-center">
                <div class="card p-2" style="max-width: 420px;">
                    <div class="card-body">
                        <h2 class="fw-semibold card-title mb-4">Contacto</h2>
                        <p>¿Tienes alguna pregunta? ¡Contáctanos!</p>

                        <form action="../../controlador/cliente/registro.php" method="post">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Correo electrónico:</label>
                                <input type="email" class="form-control" id="email" placeholder="tucorreo@example.com">
                            </div>
                            <div class="form-group mb-4">
                                <label for="mensaje">Mensaje:</label>
                                <textarea class="form-control" id="mensaje" rows="4" placeholder="Escribe tu mensaje aquí"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalInicioSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-container p-3">
                        <form action="../../controlador/ingresar.php" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mt-4">
                                <label for="pass">Contraseña:</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                                <input type="hidden" class="form-control" id="prevRoute" name="prev_route" value="tienda.php" required>
                            </div>
                            <div class="form-group mt-2">
                                <input type="checkbox" class="form-check-input" id="cbxrecordar" name="cbxrecordar">
                                <label class="form-check-label" for="cbxrecordar">Recordarme</label>
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" class="btn mt-4 text-white" style="border-radius: 30px; background-color: rgba(240, 84, 41);">Iniciar sesión</button>
                                <p class="mt-4"><a href="#" data-bs-toggle="modal" data-bs-target="#modalRegistro" style="color: rgba(240, 84, 41);">Registrarme</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-container p-3">
                        <form action="../../controlador/ingresar.php" method="post">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="email">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col">
                                    <label for="apellidos">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col">
                                    <label for="pass">Contraseña:</label>
                                    <input type="password" class="form-control" id="pass" name="pass" required>
                                    <input type="hidden" class="form-control" id="prevRoute" name="prev_route" value="tienda.php" required>
                                    <label for="pass2">Vuelve a escribir la contraseña:</label>
                                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn mt-4 text-white" style="border-radius: 30px; background-color: rgba(240, 84, 41);">Registrarme</button>
                                <p class="mt-4">Ya eres miembro? <a href="#" style="color: rgba(240, 84, 41);">Inicia sesión</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <p>&copy; 2023 Andrés Espinoza Motos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#btnMostrarPopup").click(function() {
                $("#modalInicioSesion").modal('show');
            });
        });
    </script>
</body>

</html>