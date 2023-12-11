<?php
include_once '../../modelo/dao/productoDAO.php';
if (isset($_GET['logout'])) {
    header('Location: ./tienda.php');
}
$id = $_GET['id_producto'];

$dao = new ProductoDAO();
$moto = $dao->obtenerProductoPorId($id);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detalles del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Goldman:wght@700&family=Mulish:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/detalle_producto.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <a class="navbar-brand" href="#">
                <img src="../../../public/assets/img/logo-txt-white.png" alt="Logo Andres Espinoza Motos">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./tienda.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contacto.php">Contacto</a>
                    </li>
                </ul>
                <?php
                include_once '../../modelo/Sesion.php';
                include_once '../../modelo/usuario.php';
                session_start();

                if (isset($_SESSION['sesion'])) {
                    $sesion = $_SESSION['sesion'];
                    $usuario = $sesion->usuario;

                    if ($usuario) {
                ?>
                        <div class="nav-item dropdown ms-auto align-items-center">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        </nav>
    </header>
    <section class="vh-100" style="background: url('../../../public/assets/img/7996580.png') no-repeat center;">
        <div class="container-fluid h-100 text-white">
            <div class="row h-100">
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <img src="data:image/jpeg;base64, <?php echo base64_encode($moto->getImagen()) ?>" alt="<?php echo $moto->getModelo() ?>">
                </div>
                <div class="col-md-6 mt-4">
                    <h4 class="marca"><?php echo $moto->getMarca() ?></h4>
                    <h1 class="modelo"><?php echo strtoupper($moto->getModelo()) ?></h1>
                    <p class="mt-4 descripcion">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum odio neque molestias quidem iusto repellendus optio animi ea expedita suscipit itaque voluptates aliquam, officiis, similique dolore dicta fuga cumque eligendi.</p>
                    <div class="text-end">
                        <h1 class="precio">S/. <?php echo $moto->getPrecio() ?></h1>
                        <a href="./form_pedido.php?id_producto=<?php echo $moto->getId() ?>"><button class="btn text-white boton-comprar" style="margin-top: 30px;">ADQUIRIR MOTO</button></a>
                        <a class="text-white" href="https://wa.me/51111111111">
                            <h5 class="mt-4"><i class="bi bi-whatsapp me-2"></i>Contáctanos vía WhatsApp</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container especificaciones-container mb-4">
        <h2 style="font-family: 'Goldman', sans-serif; margin-top: 55px; margin-bottom: 20px">Especificaciones</h2>
        <div class="table-container mx-4">
            <table class="table table-bordered border-secondary">
                <thead>
                    <tr>
                        <th class="col-4">Categoría</th>
                        <th>Especificación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Modelo</td>
                        <td><?php echo $moto->getModelo() ?></td>
                    </tr>
                    <tr>
                        <td>Año</td>
                        <td>2023</td>
                    </tr>
                    <tr>
                        <td>Motor</td>
                        <td>4 tiempos, 2 cilindros</td>
                    </tr>
                    <tr>
                        <td>Desplazamiento</td>
                        <td>800 cc</td>
                    </tr>
                    <tr>
                        <td>Potencia</td>
                        <td>100 HP</td>
                    </tr>
                    <tr>
                        <td>Peso</td>
                        <td>200 kg</td>
                    </tr>
                    <tr>
                        <td>Velocidad máxima</td>
                        <td>200 km/h</td>
                    </tr>
                </tbody>
            </table>
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
                                <p class="mt-4"><a href="#" style="color: rgba(240, 84, 41);">Registrarme</a></p>
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['error']) && $_GET['error'] == 'credenciales') {
                            echo '<p>Credenciales incorrectas</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3 mt-4">
        <p>&copy; 2023 Andrés Espinoza Motos</p>
    </footer>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../../../public/assets/js/utils.js"></script>
</body>

</html>