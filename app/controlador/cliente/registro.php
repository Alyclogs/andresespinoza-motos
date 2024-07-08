<?php
include_once '../../modelo/cliente.php';
include_once '../../modelo/usuario.php';
include_once '../../modelo/dao/clienteDAO.php';
include_once '../../modelo/dao/usuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $nombreCliente = $_POST["nombre_cliente"];
    $apellidosCliente = $_POST["apellidos_cliente"];
    $email = trim($_POST["email_cliente"]);
    $pass = trim($_POST["pass_cliente"]);
    $prev_route = $_POST["prev_route"];

    $dao = new ClienteDAO();
    $udao = new UsuarioDAO();

    $usuario = new Usuario();
    $usuario->setNombre($nombreCliente . ' ' . $apellidosCliente);
    $usuario->setEmail($email);
    $usuario->setContrasena($pass);
    $usuario->setRol('3');

    $udao->agregarUsuario($usuario);

    $usuarioNuevo = $udao->obtenerUsuarioPorCorreo($email);

    $cliente = new Cliente();
    $cliente->setUser_id($usuarioNuevo->getId());
    $cliente->setNombre($nombreCliente);
    $cliente->setApellidos($apellidosCliente);
    $cliente->setCorreo($email);

    $dao->agregarCliente($cliente);
    header('Location: ../../vista/cliente/' . $prevroute);
}
