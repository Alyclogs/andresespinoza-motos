<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/pedido.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';

class PedidoDAO
{
    private $dao = null;

    function leerPedidos()
    {
        $this->dao = new DataSource();
        $sql = "SELECT * FROM pedidos";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrPedidos = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $pedido = new Pedido();
                $pedido->setId($data_table[$clave]["id"]);
                $pedido->setId_cliente($data_table[$clave]["id_cliente"]);
                $pedido->setId_producto($data_table[$clave]["id_producto"]);
                $pedido->setEstado($data_table[$clave]["estado"]);
                array_push($arrPedidos, $pedido);
            }
        }
        return $arrPedidos;
    }

    /**
     * @param Pedido $pedido El pedido a agregar
     */
    function agregarPedido($pedido)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO pedidos VALUES (null, CURRENT_TIMESTAMP(), :id_cliente, :id_producto, :estado)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':id_cliente' => $pedido->getId_cliente(),
                    ':id_producto' => $pedido->getId_producto(),
                    ':estado' => $pedido->getEstado()
                )
            );
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function obtenerPedidoPorId($Pedido_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from pedidos WHERE id = :id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(
            ':id' => $Pedido_id
        ));
        if (count($resultado) > 0) return $resultado[0];
    }
}
