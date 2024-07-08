<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/Cliente.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/usuarioDAO.php';

class ClienteDAO
{
    private $dao = null;

    function leerClientes()
    {
        $this->dao = new DataSource();
        $sql = "SELECT * FROM clientes";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrClientes = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $cliente = new Cliente();
                $cliente->setId($clave["id"]);
                $cliente->setUser_id($clave["user_id"]);
                $cliente->setNombre($clave["nombre"]);
                $cliente->setTipo_doc($clave["tipo_doc"]);
                $cliente->setNum_doc($clave["num_doc"]);
                $cliente->setApellidos($clave["apellidos"]);
                $cliente->setCorreo($clave["correo"]);
                $cliente->setTelefono($clave["telefono"]);
                $cliente->setDepartamento($clave["departamento"]);
                $cliente->setProvincia($clave["provincia"]);
                $cliente->setDireccion($clave["direccion"]);
                array_push($arrClientes, $cliente);
            }
        }
        return $arrClientes;
    }

    /**
     * @param Cliente $cliente El Cliente a agregar
     */
    function agregarCliente($cliente)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO clientes VALUES (null, :user_id, :nombre, :apellidos, :tipo_doc, :num_doc, :correo, :telefono, :departamento, :provincia, :direccion)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':user_id' => $cliente->getUser_id(),
                    ':nombre' => $cliente->getNombre(),
                    ':apellidos' => $cliente->getApellidos(),
                    ':tipo_doc' => $cliente->getTipo_doc(),
                    ':num_doc' => $cliente->getNum_doc(),
                    ':correo' => $cliente->getCorreo(),
                    ':telefono' => $cliente->getTelefono(),
                    ':departamento' => $cliente->getDepartamento(),
                    ':provincia' => $cliente->getProvincia(),
                    ':direccion' => $cliente->getDireccion()
                )
            );
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @param Cliente $cliente El Cliente a agregar
     */
    function registroCliente($cliente)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO clientes VALUES (null, :user_id, :nombre, :apellidos, :correo)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':user_id' => $cliente->getUser_id(),
                    ':nombre' => $cliente->getNombre(),
                    ':apellidos' => $cliente->getApellidos(),
                    ':correo' => $cliente->getCorreo(),
                )
            );
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @param Cliente $cliente El Cliente a modifircar
     */
    function modificarCliente($cliente)
    {
        $this->dao = new DataSource();
        $sql = 'UPDATE clientes SET user_id=:user_id, nombre=:nombre, apellidos=:apellidos, tipo_doc=:tipo_doc, num_doc=:num_doc,
        correo=:correo, telefono=:telefono, departamento=:departamento, provincia=:provincia, direccion=:direccion
        WHERE id=:id';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':user_id' => $cliente->getUser_id(),
                    ':nombre' => $cliente->getNombre(),
                    ':apellidos' => $cliente->getApellidos(),
                    ':tipo_doc' => $cliente->getTipo_doc(),
                    ':num_doc' => $cliente->getNum_doc(),
                    ':correo' => $cliente->getCorreo(),
                    ':telefono' => $cliente->getTelefono(),
                    ':departamento' => $cliente->getDepartamento(),
                    ':provincia' => $cliente->getProvincia(),
                    ':direccion' => $cliente->getDireccion(),
                    ':id' => $cliente->getId()
                )
            );
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function obtenerClientePorId($cliente_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from clientes WHERE id = :id";
        try {
            $resultado = $this->dao->ejecutarConsulta($sql, array(
                ':id' => $cliente_id
            ));

            $cliente = new Cliente();
            if (count($resultado) > 0) {
                $cliente->setId($resultado[0]["id"]);
                $cliente->setNombre($resultado[0]["nombre"]);
                $cliente->setApellidos($resultado[0]["apellidos"]);
                $cliente->setTipo_doc($resultado[0]["tipo_doc"]);
                $cliente->setNum_doc($resultado[0]["num_doc"]);
                $cliente->setCorreo($resultado[0]["correo"]);
                $cliente->setTelefono($resultado[0]["telefono"]);
                $cliente->setDepartamento($resultado[0]["departamento"]);
                $cliente->setProvincia($resultado[0]["provincia"]);
                $cliente->setDireccion($resultado[0]["direccion"]);
            }
            return $cliente;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    function obtenerIdCliente($usuario_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from clientes WHERE user_id = :user_id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(
            ':user_id' => $usuario_id
        ));
        if (count($resultado) > 0) return $resultado[0]['id'];
    }
}
