<?php
include_once '../app/modelo/dao/usuarioDAO.php';

if (isset($_COOKIE['recuerdame_token'])) {

    $dao = new UsuarioDAO();
    $token = $_COOKIE['recuerdame_token'];
    $usuario_id = $dao->obtenerIdUsuarioPorToken($token);

    if ($usuario_id) {
        //header('Location: app/vista/tienda.php');
    }
} else {
    header('Location: dashboard.php');
}
