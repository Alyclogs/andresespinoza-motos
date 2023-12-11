<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/venta.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';

class ventaDAO
{
    private $dao = null;

    function leerventas()
    {
        $this->dao = new DataSource();
        $sql = "SELECT v.id, v.fecha, tipo_comprobante, id_vendedor, vd.nombre AS nombre_vendedor, vd.apellidos AS apellidos_vendedor,
        id_cliente, c.nombre AS nombre_cliente, c.apellidos AS apellidos_cliente, num_doc,
        id_producto, p.marca, p.modelo, subtotal, descuento, igv, total FROM ventas AS v INNER JOIN productos AS p
        ON v.id_producto = p.id INNER JOIN clientes AS c ON v.id_cliente = c.id INNER JOIN vendedores AS vd";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrventas = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $venta = array(
                    "id" => $clave["id"],
                    "fecha" => $clave["fecha"],
                    "tipo_comprobante" => $clave["tipo_comprobante"],
                    "id_vendedor" => $clave["id_vendedor"],
                    "nombre_vendedor" => $clave["nombre_vendedor"] . ' ' . $clave["apellidos_vendedor"],
                    "id_cliente" => $clave["id_cliente"],
                    "nombre_cliente" => $clave["nombre_cliente"] . ' ' . $clave["apellidos_cliente"],
                    "doc_cliente" => $clave["num_doc"],
                    "id_producto" => $clave["id_producto"],
                    "nombre_producto" => $clave["marca"] . ' ' . $clave["modelo"],
                    "subtotal" => $clave["subtotal"],
                    "descuento" => $clave["descuento"],
                    "igv" => $clave["igv"],
                    "total" => $clave["total"]
                );
                array_push($arrventas, $venta);
            }
        }
        return $arrventas;
    }

    /**
     * @param venta $venta El venta a agregar
     */
    function agregarventa($venta)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO ventas VALUES (null, CURRENT_TIMESTAMP(), :tipo_comprobante, :id_vendedor, :id_cliente,
        :id_producto, :subtotal, :descuento, :igv, :total)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':tipo_comprobante' => $venta->getTipo_comprobante(),
                    ':id_vendedor' => $venta->getIdVendedor(),
                    ':id_cliente' => $venta->getIdCliente(),
                    ':id_producto' => $venta->getIdProducto(),
                    ':subtotal' => $venta->getSubtotal(),
                    ':descuento' => $venta->getDescuento(),
                    ':igv' => $venta->getIgv(),
                    ':total' => $venta->getTotal()
                )
            );
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function obtenerventaPorId($venta_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from ventas WHERE id = :id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(
            ':id' => $venta_id
        ));
        if (count($resultado) > 0) return $resultado[0];
    }
}
