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
