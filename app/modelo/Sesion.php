<?php
ob_start();
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/usuario.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/usuarioDAO.php';

class Sesion
{
    private $token = "";
    public $usuario = null;
    private $prevRoute = 'inicio.php';

    /**
     * @param Usuario $usuario
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setPrevRoute($prevRoute)
    {
        $this->prevRoute = $prevRoute;
    }

    public function iniciarSesion($remember = false)
    {
        try {
            session_start();
            $_SESSION["sesion"] = $this;

            if ($remember) {
                $this->generarToken($this->usuario->getId());
            }

            if ($this->usuario->getRol() === "1") {
                header('Location: ../vista/admin/dashboard.php');
            } else {
                header("Location: ../vista/cliente/$this->prevRoute");
            }
        } catch (PDOException $e) {
            echo 'Error en la validacion de datos: ' . $e;
        }
    }

    function generarToken($usuario_id)
    {
        try {
            $this->token = bin2hex(random_bytes(32));
            if (empty($this->token)) {
                $this->token = uniqid();
            }
            setcookie('recuerdame_token', $this->token, time() + 30 * 24 * 60 * 60, '/');
            $dao = new UsuarioDAO();
            $dao->guardarTokenDeUsuario($usuario_id, $this->token);
        } catch (Exception $e) {
            echo 'Error en la generacion del token: ' . $e;
        }
    }

    function cerrarSesion($usuario_id)
    {
        try {
            setcookie('recuerdame_token', '', time() - 3600, '/');
            $dao = new UsuarioDAO();
            $dao->eliminarTokenDeUsuario($usuario_id);
            if ($this->prevRoute) {
                header('Location: ../vista/cliente/' . $this->prevRoute);
            }
        } catch (PDOException $e) {
            echo 'Error en la eliminacion del token: ' . $e;
        }
    }
}
ob_end_flush();
