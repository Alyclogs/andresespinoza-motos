<?php

class Conexion
{
    private $host = 'localhost';
    private $dbname = 'andresespinozamotos';
    private $usuario = 'root';
    private $contrasena = '';
    public $conexion = null;

    public function __construct()
    {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }
}
