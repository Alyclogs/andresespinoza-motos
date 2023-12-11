<?php
include_once '../../modelo/dao/ventaDAO.php';
include_once '../../modelo/dao/pedidoDAO.php';
include_once '../../modelo/venta.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $dao = new ventaDAO();
    $pdao = new PedidoDAO();

    $ventaNueva = new Venta();
    $ventaNueva->setTipo_comprobante($_POST["tipo_comprobante"]);
    $ventaNueva->setIdVendedor($_POST["id_vendedor"]);
    $ventaNueva->setIdCliente($_POST["id_cliente"]);
    $ventaNueva->setIdProducto($_POST["id_producto"]);
    $ventaNueva->setSubtotal($_POST["subtotal"]);
    $ventaNueva->setDescuento($_POST["descuento"]);
    $ventaNueva->setIgv($_POST["igv"]);
    $ventaNueva->setTotal($_POST["total"]);

    $id_pedido = $_POST['pedidoId'];
    $nuevo_estado = $_POST['nuevoEstado'];
    $pedido = $pdao->obtenerPedidoPorId($id_pedido);
    $pedido->setEstado($nuevo_estado);

    try {
        $pdao->modificarPedido($pedido);
        echo $dao->agregarventa($ventaNueva);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
