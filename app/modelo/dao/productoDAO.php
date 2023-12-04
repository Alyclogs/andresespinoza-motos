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
        $arrUsuarios = array();

        if (count($data_table) > 0) {
            foreach ($data_table as  $clave) {
                $usuario = new Producto();
                $usuario->setId($data_table[$clave]["id"]);
                $usuario->setMarca($data_table[$clave]["nombre"]);
                $usuario->setModelo($data_table[$clave]["modelo"]);
                $usuario->setPrecio($data_table[$clave]["precio"]);
                $usuario->setImagen($data_table[$clave]["imagen"]);
                $usuario->setTipo($data_table[$clave]["tipo"]);
                array_push($arrUsuarios, $usuario);
            }
        }
        return $arrUsuarios;
    }

    /**
     * @param Producto $producto El producto a agregar
     */
    function agregarProducto($producto)
    {
        $this->dao = new DataSource();
        $sql = 'INSERT INTO productos
        VALUES (:id, :marca, :modelo, :precio, :imagen, :tipo)';

        return $this->dao->ejecutarActualizacion(
            $sql,
            array(
                ':id' => $producto->getId(),
                ':marca' => $producto->getMarca(),
                ':modelo' => $producto->getModelo(),
                ':precio' => $producto->getPrecio(),
                ':imagen' => $producto->getImagen()
            )
        );
    }

    function obtenerProductoPorId($producto_id)
    {
        $this->dao = new DataSource();
        $sql = "SELECT * from productos WHERE id = :id";
        $resultado = $this->dao->ejecutarConsulta($sql, array(
            ':id' => $producto_id
        ));
        if (count($resultado) > 0) return $resultado[0];
    }
}
