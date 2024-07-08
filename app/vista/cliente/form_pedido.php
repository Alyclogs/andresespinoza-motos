<?php
include_once '../../modelo/dao/usuarioDAO.php';
include_once '../../modelo/dao/productoDAO.php';
include_once '../../modelo/Sesion.php';
include_once '../../modelo/ubigeo.php';
include_once '../../modelo/usuario.php';
session_start();

$id = $_GET['id_producto'];

$dao = new ProductoDAO();
$udao = new UsuarioDAO();
$moto = $dao->obtenerProductoPorId($id);

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andrés Espinoza Motos - Pedir moto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../../../public/assets/css/form_pedido.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
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
                    include_once '../../controlador/ingresar.php';

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
    <div class="container" style="margin-top: 120px; margin-bottom: 60px">
        <div class="row align-items-center mt-4">
            <div class="col-md-4">
                <p class="mb-4">Llena los siguientes campos y nos pondremos en contacto contigo muy pronto</p>
                <div class="card custom-card" style="border-radius: 1rem;">
                    <div class="card-body align-items-center">
                        <h5 class="card-title">Descripción del producto</h5>
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($moto->getImagen()) ?>" alt="<?php echo $moto->getModelo() ?>">
                        <div class="row">
                            <div class="col">
                                <h6 class="card-text mt-4"><?php echo $moto->getMarca() ?></h6>
                                <h5 class="card-text"><?php echo $moto->getModelo() ?></h5>
                            </div>
                            <div class="col mt-auto text-end">
                                <h5 class="card-text">S/. <?php echo $moto->getPrecio() ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form action="../../controlador/cliente/confirmacion_pedido.php" method="post">
                    <h5>Ingresa tus datos:</h5>
                    <?php
                    $cliente = null;
                    $existe = false;

                    if (isset($_SESSION['sesion'])) {
                        $sesion = $_SESSION['sesion'];
                        $cliente = $udao->obtenerClientePorIdUsuario($sesion->usuario->getId());

                        if ($cliente != null) $existe = true;
                    }
                    ?>
                    <input type="hidden" name="nomProducto" value="<?php echo $moto->getMarca() . ' ' . $moto->getModelo() ?>">
                    <input type="hidden" name="producto_id" value="<?php echo $moto->getId() ?>">
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="nombre_cliente" class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" value="<?php echo $existe ? $cliente->getNombre() : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo $existe ? $cliente->getApellidos() : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="email_cliente" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email_cliente" id="email_cliente" value="<?php echo $existe ? $cliente->getCorreo() : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $existe ? $cliente->getTelefono() : ''; ?>" maxlength="9" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="tipodoc" class="form-label">Tipo de documento</label>
                                <select id="tipoDocumento" name="tipoDocumento" class="form-select" required>
                                    <option value="dni" <?php if ($existe && $cliente->getTipo_doc() === "1") echo 'selected' ?>>DNI</option>
                                    <option value="extranjero" <?php if ($existe && $cliente->getTipo_doc() === "2") echo 'selected' ?>>Carnet de Extranjería</option>
                                    <option value="pasaporte" <?php if ($existe && $cliente->getTipo_doc() === "3") echo 'selected' ?>>Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="numdoc" class="form-label">Número de documento</label>
                                <input type="text" class="form-control" name="numdoc" id="numdoc" value="<?php echo $existe ? $cliente->getNum_doc() : '' ?>" maxlength="8" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="departamento" class="form-label">Departamento</label>
                                <select id="departamento" name="departamento" class="form-select" required>
                                    <option value="">Selecciona un departamento</option>
                                    <?php
                                    foreach ($ubigeo_peru_departments as $department) {
                                        if ($existe && $cliente->getDepartamento() === $department['name']) {
                                            echo "<option value='{$department['id']}' selected>{$department['name']}</option>";
                                        } else {
                                            echo "<option value='{$department['id']}'>{$department['name']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="provincia" class="form-label">Provincia</label>
                                <select id="provincia" name="provincia" class="form-select" disabled required>
                                    <option value="">Selecciona un departamento primero</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <div class="form-group mt-3">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $existe ? $cliente->getDireccion() : '' ?>" required>
                            <input type="hidden" name="cliente-existe" value="<?php echo $existe ?>">
                        </div>
                    </div>
                    <div class="d-grid gap-2" style="margin-top: 55px;">
                        <input type="submit" class="btn btn-secondary btn-lg" value="Realizar pedido">
                    </div>
                </form>
            </div>
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
                                <input type="hidden" class="form-control" id="prevRoute" name="prev_route" value="tienda.php" required>
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

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        $('#departamento').change(function() {
            var departamentoId = $(this).val();

            if (departamentoId !== '') {
                $.ajax({
                    url: '../../modelo/ubigeo.php',
                    type: 'GET',
                    data: {
                        departamento_id: departamentoId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#provincia').empty().prop('disabled', false);

                        $.each(data, function(index, provincia) {
                            $('#provincia').append('<option value="' + provincia.name + '">' + provincia.name + '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error al cargar las provincias');
                    }
                });
            } else {
                $('#provincia').empty().prop('disabled', true);
            }
        });

        $('#tipoDocumento').change(function() {
            var tipoDocumento = $(this).val();

            if (tipoDocumento === 'dni') {
                $('#numdoc').attr('maxlength', '8');
            } else {
                $('#numdoc').attr('maxlength', '12');
            }
        });
    </script>
</body>

</html>