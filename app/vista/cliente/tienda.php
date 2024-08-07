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
</head>

<body>

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
                            <a class="nav-link" href="../../../public/index.html">Inicio</a>
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
                            <button class="btn" id="btnMostrarPopup" data-bs-toggle="modal" data-bs-target="#modalInicioSesion" style="border-radius: 30px; background-color: rgba(240, 84, 41); color: white;">Iniciar sesión</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container px-5 align-items-center" style="margin-top: 150px;">
        <?php

        include_once('../../modelo/dao/DataSource.php');

        $productoDAO = new DataSource();
        $productos = $productoDAO->ejecutarConsulta("SELECT * FROM productos");

        ?>
        <div class="row w-100">
            <div class="col w-100">
                <div class="card" style="border-radius: 1rem;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="text-secondary"><?php echo count($productos) ?> motos encontradas</span>
                        <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill me-2"></i>Filtros
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Precio más bajo</a></li>
                            <li><a class="dropdown-item" href="#">...</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 w-100 justify-content-center">
            <?php
            foreach ($productos as $producto) {
            ?>
                <div class="col-md-3 mb-4 d-flex">
                    <a href="detalle_producto.php?id_producto=<?php echo $producto["id"]; ?>" class="text-decoration-none text-dark">
                        <div class="card shadow-2-strong">
                            <?php
                            if ($producto['imagen']) echo '<img src="data:image/jpeg;base64,' . base64_encode($producto["imagen"]) . '" class="card-img-top mx-auto" alt="' . $producto["modelo"] . '"max-width:90%;">';
                            else echo '<img src="../../../public/assets/img/no-image.png" class="card-img-top mx auto" style="max-width:90%;"></img>';
                            ?>
                            <div class="card-body">
                                <h5 class="card-title text-start"> <?php echo $producto['modelo']; ?></h5>
                                <p class="card-text text-start"> <?php echo $producto['marca']; ?></p>
                                <h6 class="card-text text-end">S/. <?php echo $producto['precio']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="modal fade" id="modalInicioSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-container p-3">
                        <form action="../../controlador/ingresar.php" id="loginForm" method="post">
                            <div class="my-2 d-none" id="usuario-no-existe">
                                <div class="alert alert-danger">El usuario ingresado no existe</div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mt-4">
                                <label for="pass">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="pass" required>
                                <input type="hidden" class="form-control" id="prev_route" name="prev_route" value="tienda.php" required>
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
                    <form action="../../controlador/cliente/registro.php" method="post">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre_cliente" required>
                            </div>
                            <div class="col">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos_cliente" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email_cliente" required>
                            </div>
                            <div class="col">
                                <label for="pass">Contraseña:</label>
                                <input type="password" class="form-control" id="pass" name="pass_cliente" required>
                                <input type="hidden" class="form-control" id="prev_route" name="prev_route" value="cliente/tienda.php" required>
                                <label for="pass2">Vuelve a escribir la contraseña:</label>
                                <input type="password" class="form-control" id="pass2" name="pass2" required>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn mt-4 text-white" style="border-radius: 30px; background-color: rgba(240, 84, 41);">Registrarme</button>
                            <p class="mt-4">Ya eres miembro? <a href="#" data-bs-toggle="modal" data-bs-target="#modalInicioSesion" style="color: rgba(240, 84, 41);">Inicia sesión</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-3 mt-3">
        <p>&copy; 2023 Andrés Espinoza Motos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../../../public/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../../public/assets/js/app.min.js"></script>
    <script src="../../../public/assets/js/utils.js"></script>

</body>

</html>