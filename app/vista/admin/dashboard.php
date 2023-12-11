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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Ventas | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../../public/assets/css/admin_dashboard.css">
</head>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between mt-2">
                    <a href="./dashboard.php" class="d-flex align-items-center text-secondary">
                        <img src="../../../public/assets/img/logo-75x31px.png" alt="">
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
                            <a class="sidebar-link" href="./index.php" aria-expanded="false">
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
                            <a class="sidebar-link" href="./sales-system/pedidos.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-building-store"></i>
                                </span>
                                <span class="hide-menu">Pedidos</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./sales-system/ventas.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="hide-menu">Ventas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./sales-system/clientes.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Clientes</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./sales-system/productos.php" aria-expanded="false">
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
                                        <a href="?logout=true" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 d-flex align-items-strech">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Resumen de ventas</h5>
                                    </div>
                                    <div>
                                        <select class="form-select">
                                            <option value="11">Noviembre 2023</option>
                                            <option value="12" selected>Diciembre 2023</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card overflow-hidden">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-9 fw-semibold">Ventas anuales</h5>
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h4 class="fw-semibold mb-3">S/.36,358</h4>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-arrow-up-left text-success"></i>
                                                    </span>
                                                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                    <p class="fs-3 mb-0">que el año pasado</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-4">
                                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                        <span class="fs-2">2023</span>
                                                    </div>
                                                    <div>
                                                        <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                        <span class="fs-2">2022</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex justify-content-center">
                                                    <div id="breakup"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row alig n-items-start">
                                            <div class="col-8">
                                                <h5 class="card-title mb-9 fw-semibold"> Ganancias mensuales </h5>
                                                <h4 class="fw-semibold mb-3">S/.6,820</h4>
                                                <div class="d-flex align-items-center pb-1">
                                                    <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-arrow-down-right text-danger"></i>
                                                    </span>
                                                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                    <p class="fs-3 mb-0">que el año pasado</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex justify-content-end">
                                                    <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-currency-dollar fs-6"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="earning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="card-title fw-semibold">Movimientos recientes</h5>
                                </div>
                                <ul class="timeline-widget mb-0 position-relative mb-n5">
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Pago de S/.2500 recibido por Daniel Gutierrez</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">10:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-info flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">Nueva venta registrada <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Pago de S/.1500 enviado a Hector Suarez</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-warning flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">Nueva venta registrada <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">Nuevo producto registrado
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Pago realizado</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-semibold mb-4">Transacciones recientes</h5>
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Id</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Vendedor</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Producto</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Cliente</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">Total venta</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">1</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Victor Sosa</h6>
                                                    <span class="fw-normal">Vendedor</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Modelo4-1</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">Carlos Sanchez</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">S/.5555</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">2</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Alicia Romero</h6>
                                                    <span class="fw-normal">Vendedor</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Modelo1-8</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">José Medina</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">S/.4575</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">3</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Alicia Romero</h6>
                                                    <span class="fw-normal">Vendedor</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Modelo2-2</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">Miguel Ruiz</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">S/.6151</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">4</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">Norma Benitez</h6>
                                                    <span class="fw-normal">Vendedor</span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">Modelo7-17</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">José Medina</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 fs-4">S/.1256</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../../public/assets/js/sidebarmenu.js"></script>
    <script src="../../../public/assets/js/app.min.js"></script>
    <script src="../../../public/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../../../public/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../../../public/assets/js/dashboard.js"></script>

</body>

</html>