<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/conexion.php');

class DataSource
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conexion();
    }

    public function ejecutarConsulta($query = "", $params = array())
    {
        $stmt = $this->conn->conexion->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ejecutarActualizacion($query = "", $params = array())
    {
        try {
            $stmt = $this->conn->conexion->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
