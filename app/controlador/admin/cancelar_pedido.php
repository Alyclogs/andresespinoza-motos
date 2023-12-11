<?php
include_once '../../modelo/dao/pedidoDAO.php';

$id_pedido = $_POST['pedidoId'];
$nuevo_estado = $_POST['nuevoEstado'];

$dao = new PedidoDAO();

try {
    $pedido = $dao->obtenerPedidoPorId($id_pedido);
    $pedido->setEstado($nuevo_estado);

    $dao->modificarPedido($pedido);
    header('Location: ../../vista/admin/sales-system/pedidos.php');
} catch (Exception $e) {
    echo $e->getMessage();
}
