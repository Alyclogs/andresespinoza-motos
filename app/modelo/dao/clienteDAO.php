<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/Cliente.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';

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
                $cliente->setId($data_table[$clave]["id"]);
                $cliente->setNombre($data_table[$clave]["nombre"]);
                $cliente->setApellidos($data_table[$clave]["apellidos"]);
                $cliente->setCorreo($data_table[$clave]["correo"]);
                $cliente->setTelefono($data_table[$clave]["telefono"]);
                $cliente->setDepartamento($data_table[$clave]["departamento"]);
                $cliente->setProvincia($data_table[$clave]["provincia"]);
                $cliente->setDireccion($data_table[$clave]["direccion"]);
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
        $sql = 'INSERT INTO clientes VALUES (null, :nombre, :apellidos, :correo, :telefono, :departamento, :provincia, :direccion)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':nombre' => $cliente->getNombre(),
                    ':apellidos' => $cliente->getApellidos(),
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

    function obtenerClientePorId($cliente_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from clientes WHERE id = :id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(
            ':id' => $cliente_id
        ));
        if (count($resultado) > 0) return $resultado[0];
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
