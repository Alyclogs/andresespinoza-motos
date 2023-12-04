<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/usuario.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';

class UsuarioDAO
{
    private $dao = null;

    function leerUsuarios()
    {
        $this->dao = new DataSource();
        $sql = "SELECT * FROM usuarios";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrUsuarios = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $usuario = new Usuario();
                $usuario->setId($data_table[$clave]["id"]);
                $usuario->setNombre($data_table[$clave]["nombre"]);
                $usuario->setContrasena($data_table[$clave]["contrasena"]);
                $usuario->setRol($data_table[$clave]["rol"]);
                array_push($arrUsuarios, $usuario);
            }
        }
        return $arrUsuarios;
    }

    /**
     * @param Usuario $usuario El usuario a agregar
     */
    function agregarUsuario($usuario)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO usuarios
        VALUES (null, :nombre, :email, :contrasena, :rol)';

        return $this->dao->ejecutarActualizacion(
            $sql,
            array(
                ':nombre' => $usuario->getNombre(),
                ':email' => $usuario->getEmail(),
                ':contrasena' => $usuario->getContrasena(),
                ':rol' => $usuario->getRol()
            )
        );
    }

    function obtenerUsuarioPorId($usuario_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(':id' => $usuario_id));

        if (!empty($resultado)) {
            $primerResultado = $resultado[0];
            $usuario = new Usuario();
            $usuario->setId($primerResultado['id']);
            $usuario->setNombre($primerResultado['nombre']);
            $usuario->setEmail($primerResultado['email']);
            $usuario->setContrasena($primerResultado['contrasena']);
            $usuario->setRol($primerResultado['rol']);

            return $usuario;
        } else {
            return null;
        }
    }

    function obtenerIdUsuario($email, $contrasena)
    {
        $this->dao = new DataSource();
        $sql = "SELECT id FROM usuarios WHERE email = :email AND contrasena = :contrasena";

        $resultado = $this->dao->ejecutarConsulta($sql, array(':email' => $email, ':contrasena' => $contrasena));

        if (!empty($resultado)) {
            return $resultado[0]['id'];
        } else {
            return null;
        }
    }

    function obtenerIdUsuarioPorToken($token)
    {
        $this->dao = new DataSource();
        $sql = "SELECT idUsuario from tokens WHERE token = :token";
        try {
            $resultado = $this->dao->ejecutarConsulta($sql, array(
                ':token' => $token
            ));

            if (!empty($resultado)) {
                return $resultado[0]['idUsuario'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error al obtener el token de usuario: " . $e->getMessage();
        }
    }

    function guardarTokenDeUsuario($usuario_id = "", $token = "")
    {
        $this->dao = new DataSource();

        try {
            if (!empty($usuario_id) && !empty($token)) {
                $sql = "INSERT INTO tokens (id, idUsuario, token) VALUES (null, :idUsuario, :token)";
                $this->dao->ejecutarActualizacion($sql, array(
                    ':idUsuario' => $usuario_id,
                    ':token' => $token
                ));
            }
        } catch (PDOException $e) {
            echo "Error al guardar el token: " . $e->getMessage();
        }
    }

    function eliminarTokenDeUsuario($usuario_id = "")
    {
        $this->dao = new DataSource();
        $sql = "DELETE FROM tokens WHERE idUsuario = :idUsuario";
        $this->dao->ejecutarActualizacion($sql, array(
            ':idUsuario' => $usuario_id
        ));
    }
}
