<?php
include_once '../../modelo/dao/usuarioDAO.php';
include_once '../../modelo/dao/productoDAO.php';
include_once '../../modelo/Sesion.php';
include_once '../../modelo/ubigeo.php';
include_once '../../modelo/usuario.php';
session_start();

$id = $_GET['id_producto'];

$dao = new ProductoDAO();
$moto = $dao->obtenerProductoPorId($id);

if (!isset($_SESSION['sesion'])) {
    header("Location: tienda.php");
} else {
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
                            <a class="nav-link" href="./inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" href="./tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacto</a>
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
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($moto["imagen"]) ?>" alt="<?php echo $moto["modelo"] ?>">
                        <div class="row">
                            <div class="col">
                                <h6 class="card-text mt-4"><?php echo $moto["marca"] ?></h6>
                                <h5 class="card-text"><?php echo $moto["modelo"] ?></h5>
                            </div>
                            <div class="col mt-auto text-end">
                                <h5 class="card-text">S/. <?php echo $moto["precio"] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form action="../../controlador/cliente/confirmacion_pedido.php" method="post">
                    <h5>Ingresa tus datos:</h5>
                    <input type="hidden" name="nomProducto" value="<?php echo $moto['marca'] . ' ' . $moto['modelo'] ?>">
                    <input type="hidden" name="producto_id" value="<?php echo $moto['id'] ?>">
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="nombre_cliente" class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="email_cliente" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email_cliente" id="email_cliente" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="9" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="tipodoc" class="form-label">Tipo de documento</label>
                                <select id="tipoDocumento" name="tipoDocumento" class="form-select" required>
                                    <option value="dni">DNI</option>
                                    <option value="extranjero">Carnet de Extranjería</option>
                                    <option value="pasaporte">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3">
                                <label for="numdoc" class="form-label">Número de documento</label>
                                <input type="text" class="form-control" name="numdoc" id="numdoc" maxlength="8" required>
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
                                        echo "<option value='{$department['id']}'>{$department['name']}</option>";
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
                            <input type="text" class="form-control" name="direccion" id="direccion" required>
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

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
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
                                $('#provincia').append('<option value="' + provincia.id + '">' + provincia.name + '</option>');
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

            $("#btnMostrarPopup").click(function() {
                $("#modalInicioSesion").modal('show');
            });
        });
    </script>
</body>

</html>