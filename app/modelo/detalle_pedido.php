<?php

class Detalle_pedido
{

    private $id_pedido;
    private $id_producto;
    private $cant_producto;

    public function getId_pedido()
    {
        return $this->id_pedido;
    }

    public function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    public function getId_producto()
    {
        return $this->id_producto;
    }

    public function setId_pedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    public function getCant_producto()
    {
        return $this->cant_producto;
    }

    public function setCant_producto($cant_producto)
    {
        $this->cant_producto = $cant_producto;
    }
}
