<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tienda-virtual/app/modelo/usuario.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tienda-virtual/app/modelo/dao/UsuarioDAO.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tienda-virtual/app/modelo/Sesion.php';

if (!isset($_SESSION['sesion'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $dao = new UsuarioDAO();
        $usuario_id = $dao->obtenerIdUsuario($_POST['email'], $_POST['pass']);
        if ($usuario_id != null) {
            $usuario = $dao->obtenerUsuarioPorId($usuario_id);

            if ($usuario != null) {
                $sesion = new Sesion($usuario);
                $sesion->setPrevRoute($_POST['prev_route'] != null ? $_POST['prev_route'] : 'inicio.php');
                $sesion->iniciarSesion(isset($_POST['cbxrecordar']));
            }
        } else {
            header("Location: ../vista/cliente/" . $_POST['prev_route'] . "?error=credenciales");
        }
    }
}
