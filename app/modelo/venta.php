<?php

class Venta
{
    private $id;
    private $fecha;
    private $tipo_comprobante;
    private $idVendedor;
    private $idCliente;
    private $idProducto;
    private $subtotal;
    private $descuento;
    private $igv;
    private $total;

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getTipo_comprobante()
    {
        return $this->tipo_comprobante;
    }

    public function getIdVendedor()
    {
        return $this->idVendedor;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getSubtotal()
    {
        return $this->subtotal;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function getIgv()
    {
        return $this->igv;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setTipo_comprobante($tipo_comprobante)
    {
        $this->tipo_comprobante = $tipo_comprobante;
    }

    public function setIdVendedor($idVendedor)
    {
        $this->idVendedor = $idVendedor;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    public function setIgv($igv)
    {
        $this->igv = $igv;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }
}
