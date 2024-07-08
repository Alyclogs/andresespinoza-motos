<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/producto.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/tienda-virtual/app/modelo/dao/DataSource.php';

class ProductoDAO
{
    private $dao = null;

    function leerProductos()
    {
        $this->dao = new DataSource();
        $sql = "SELECT * FROM productos";
        $data_table = $this->dao->ejecutarConsulta($sql);
        $arrproductos = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $producto = new Producto();
                $producto->setId($clave["id"]);
                $producto->setMarca($clave["marca"]);
                $producto->setModelo($clave["modelo"]);
                $producto->setPrecio($clave["precio"]);
                $producto->setStock($clave["stock"]);
                $producto->setImagen($clave["imagen"]);
                $producto->setTipo($clave["tipo"]);
                array_push($arrproductos, $producto);
            }
        }
        return $arrproductos;
    }

    /**
     * @param Producto $producto El producto a agregar
     */
    function agregarProducto($producto)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO productos
        VALUES (:id, :marca, :modelo, :precio, :imagen, :tipo)';

        try {
            $this->dao->ejecutarActualizacion(
                $sql,
                array(
                    ':id' => $producto->getId(),
                    ':marca' => $producto->getMarca(),
                    ':modelo' => $producto->getModelo(),
                    ':precio' => $producto->getPrecio(),
                    ':stock' => $producto->getStock(),
                    ':imagen' => $producto->getImagen()
                )
            );
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function obtenerProductoPorId($producto_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from productos WHERE id = :id";

        try {
            $resultado = $this->dao->ejecutarConsulta($sql, array(
                ':id' => $producto_id
            ));

            $producto = new Producto();
            if (count($resultado) > 0) {
                $producto->setId($resultado[0]['id']);
                $producto->setMarca($resultado[0]['marca']);
                $producto->setModelo($resultado[0]['modelo']);
                $producto->setPrecio($resultado[0]['precio']);
                $producto->setStock($resultado[0]['stock']);
                $producto->setImagen($resultado[0]['imagen']);
                $producto->setTipo($resultado[0]['tipo']);
            }
            return $producto;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
