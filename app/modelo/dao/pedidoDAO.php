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
            foreach ($data_table as $clave) {
                $pedido = new Pedido();
                $pedido->setId($clave["id"]);
                $pedido->setFecha($clave["fecha"]);
                $pedido->setId_cliente($clave["id_cliente"]);
                $pedido->setId_producto($clave["id_producto"]);
                $pedido->setEstado($clave["estado"]);
                array_push($arrPedidos, $pedido);
            }
        }
        return $arrPedidos;
    }

    function leerPedidosDetallado()
    {
        $this->dao = new DataSource();
        $sql = "SELECT p.id, p.fecha, p.id_cliente, c.nombre, c.apellidos, p.id_producto, pr.marca, pr.modelo, p.estado FROM pedidos AS p
        INNER JOIN clientes AS c ON p.id_cliente = c.id INNER JOIN productos AS pr ON p.id_producto = pr.id";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrPedidos = array();

        if (count($data_table) > 0) {
            foreach ($data_table as $clave) {
                $pedido = array(
                    "id" => $clave["id"],
                    "fecha" => $clave["fecha"],
                    "id_cliente" => $clave["id_cliente"],
                    "cliente" => $clave["nombre"] . " " . $clave["apellidos"],
                    "id_producto" => $clave["id_producto"],
                    "producto" => $clave["marca"] . " " . $clave["modelo"],
                    "estado" => $clave["estado"],
                );
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

    /**
     * @param Pedido $pedido El pedido a modificar
     */
    function modificarPedido($pedido)
    {
        $this->dao = new DataSource();
        $sql = 'UPDATE pedidos SET fecha=:fecha, id_cliente=:id_cliente, id_producto=:id_producto, estado=:estado WHERE id=:id';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':fecha' => $pedido->getFecha(),
                    ':id_cliente' => $pedido->getId_cliente(),
                    ':id_producto' => $pedido->getId_producto(),
                    ':estado' => $pedido->getEstado(),
                    ':id' => $pedido->getId()
                )
            );
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function obtenerDiferenciaFecha($timestamp)
    {
        $fechaInicio = new DateTime($timestamp);
        $fechaActual = new DateTime();
        $diferencia = $fechaActual->diff($fechaInicio);

        $anios = $diferencia->format('%y');
        $meses = $diferencia->format('%m');
        $dias = $diferencia->format('%d');
        $horas = $diferencia->format('%h');
        $minutos = $diferencia->format('%i');

        return ($anios !== '0' ? $anios . ' años,' : '') . ($meses !== '0' ? $meses . ' meses y' : '') . ($dias !== '0' ? $dias . ' días, ' : '')
            . ($horas !== '0' ? $horas . 'h ' : '') . ($minutos !== '0' ? $minutos . 'm' : '');
    }

    function obtenerPedidoPorId($Pedido_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from pedidos WHERE id = :id";
        try {
            $resultado = $this->dao->ejecutarConsulta($sql, array(
                ':id' => $Pedido_id
            ));
            $pedido = new Pedido();
            if (count($resultado) > 0) {
                $pedido->setId($resultado[0]["id"]);
                $pedido->setFecha($resultado[0]["fecha"]);
                $pedido->setId_cliente($resultado[0]["id_cliente"]);
                $pedido->setId_producto($resultado[0]["id_producto"]);
                $pedido->setEstado($resultado[0]["estado"]);
            }
            return $pedido;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
