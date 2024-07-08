<?php

class Cliente
{

    private $id;
    private $user_id;
    private $nombre;
    private $apellidos;
    private $tipo_doc;
    private $num_doc;
    private $correo;
    private $telefono;
    private $departamento;
    private $provincia;
    private $direccion;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getTipo_doc()
    {
        return $this->tipo_doc;
    }

    public function setTipo_doc($tipo_doc)
    {
        $this->tipo_doc = $tipo_doc;
    }

    public function getNum_doc()
    {
        return $this->num_doc;
    }

    public function setNum_doc($num_doc)
    {
        $this->num_doc = $num_doc;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
}
