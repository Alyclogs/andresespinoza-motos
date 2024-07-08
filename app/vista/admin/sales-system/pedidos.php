<?php
include_once '../../../modelo/Sesion.php';
include_once '../../../modelo/usuario.php';
session_start();

if (isset($_SESSION['sesion'])) {
    $sesion = $_SESSION['sesion'];

    if ($sesion->usuario->getRol() === '3') {
        session_destroy();
        header("Location: ../login.php");
    }
    if (isset($_GET['logout'])) {
        $sesion->cerrarSesion($sesion->usuario->getId());
        session_destroy();
        header("Location: ../login.php");
    }
} else {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Ventas | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../../../public/assets/css/admin_dashboard.css">
</head>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between mt-2">
                    <a href="./dashboard.php" class="d-flex align-items-center text-secondary">
                        <img src="../../../../public/assets/img/logo-75x31px.png" alt="">
                        <h5 class="ms-2">Andrés Espinoza Motos</h5>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Inicio</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../dashboard.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Admin</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./pedidos.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-building-store"></i>
                                </span>
                                <span class="hide-menu">Pedidos</span>
                                <span class="p-2 bg-danger rounded-circle ms-auto" id="news">
                                    <span class="visually-hidden">Nuevos pedidos</span>
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./ventas.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="hide-menu">Ventas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./clientes.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Clientes</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./productos.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-archive"></i>
                                </span>
                                <span class="hide-menu">Productos</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Control de acceso</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-key"></i>
                                </span>
                                <span class="hide-menu">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <?php
                            $sesion = $_SESSION['sesion'];
                            ?>
                            <span><?php echo $sesion->usuario->getNombre() ?></span>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-user-circle"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">Mi cuenta</p>
                                        </a>
                                        <a href="?logout=true" class="btn btn-outline-primary mx-3 mt-2 d-block">Cerrar sesión</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex bd-highlight p-2 my-2 align-items-center">
                            <div class="me-auto bd-highlight">
                                <h5 class="card-title fw-semibold">Lista de pedidos</h5>
                            </div>
                            <div class="bd-highlight">
                                <select class="form-select">
                                    <option value="11">Noviembre 2023</option>
                                    <option value="11" selected>Diciembre 2023</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="me-auto p-2 bd-highlight">
                                <select class="form-select" id="ordenar-por">
                                    <option value="0">Ordenar por</option>
                                    <option value="1">Fecha</option>
                                    <option value="3">Pendientes</option>
                                    <option value="4">Enviados</option>
                                    <option value="5">Cancelados</option>
                                </select>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="./pedidos.php" class="btn btn-warning"><i class="ti ti-refresh"></i></a>
                            </div>
                        </div>
                        <div class="table-container p-2">
                            <?php
                            include_once '../../../modelo/dao/pedidoDAO.php';
                            include_once '../../../modelo/dao/productoDAO.php';
                            include_once '../../../modelo/dao/clienteDAO.php';

                            $dao = new PedidoDAO();
                            $pdao = new ProductoDAO();
                            $cdao = new ClienteDAO();
                            $pedidos = $dao->leerPedidosDetallado();

                            if (count($pedidos) == 0) {
                                echo '<p class="text-center" style="margin-top:50px; margin-bottom:50px">Todavía no hay pedidos</p>';
                            } else {
                            ?>
                                <div class="table-responsive table-bordered">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Id</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Fecha</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Cliente</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Producto</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Estado</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Transcurrido</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($pedidos as $pedido) {
                                                $producto = $pdao->obtenerProductoPorId($pedido["id_producto"]);
                                                $cliente = $cdao->obtenerClientePorId($pedido["id_cliente"])
                                            ?>
                                                <tr data-bs-toggle="modal" data-bs-target="#myModal" data-producto-id="<?php echo $producto->getId() ?>" data-producto-image="<?php echo base64_encode($producto->getImagen()) ?>" data-producto-precio="<?php echo $producto->getPrecio() ?>" data-producto-nombre="<?php echo $producto->getMarca() . ' ' . $producto->getModelo() ?>" data-cliente-id="<?php echo $cliente->getId() ?>" data-cliente-numdoc="<?php echo $cliente->getNum_doc() ?>" style="cursor:pointer;">
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-semibold"><?php echo $pedido["id"] ?></p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal"><?php echo $pedido["fecha"] ?></p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal"><?php echo $pedido["cliente"] ?></p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal"><?php echo $pedido["producto"] ?></p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <span class="badge <?php
                                                                            switch ($pedido["estado"]) {
                                                                                case "Pendiente":
                                                                                    echo "bg-warning ";
                                                                                    break;
                                                                                case "Cancelado":
                                                                                    echo "bg-danger ";
                                                                                    break;
                                                                                case "Confirmado":
                                                                                    echo "bg-success ";
                                                                                    break;
                                                                            }
                                                                            ?>rounded-3 fw-semibold"><?php echo $pedido["estado"] ?></span>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-semibold text-primary" id="tiempo-transcurrido">
                                                            <?php
                                                            if ($pedido["estado"] == "Pendiente") {
                                                                echo $dao->obtenerDiferenciaFecha($pedido["fecha"]);
                                                            }
                                                            ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detalle de pedido</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="datos-pedido"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../../../public/assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../../../../public/assets/js/sidebarmenu.js"></script>
        <script src="../../../../public/assets/js/app.min.js"></script>
</body>

</html>