<?php
class Producto
{
    private $idProducto;
    private $nombre;
    private $tipo;
    private $descripcion;
    private $stock;
    private $fechaCreacion;
    private $origen;
    private $precioUnitario;

    public function __construct($idProducto, $nombre, $tipo = "Grano", $descripcion, $stock = 1, $fechaCreacion, $origen, $precioUnitario)
    {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->stock = $stock;
        $this->fechaCreacion = $fechaCreacion;
        $this->origen = $origen;
        $this->precioUnitario = $precioUnitario;
    }

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getOrigen()
    {
        return $this->origen;
    }

    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }

    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }

    //Métodos de la estáticos
    //Método que elimina el usuario existente de la base de datos
    public static function eliminarProducto($idProducto)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (!noExisteProducto($$idProducto, $conexionBD)) {
            $consultaEliminacionProducto = $conexionBD->prepare('DELETE FROM producto WHERE id_producto = ?');
            $consultaEliminacionProducto->bind_param('s', $idProducto);
            if ($consultaEliminacionProducto->execute()) {
                $esValido = true;
            }
        }
        return $esValido ? true : false;
    }

    //Método de búsqueda de usuario, devuelve los datos del usuario encontrado en formato de array.
    public static function buscarProducto($idProducto)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (!noExisteProducto($idProducto, $conexionBD)) {
            $consultaBusquedaProducto = $conexionBD->prepare('SELECT * FROM producto WHERE id_producto = ?');
            $consultaBusquedaProducto->bind_param('s', $idProducto);
            if ($consultaBusquedaProducto->execute()) {
                $datosProducto = $consultaBusquedaProducto->fetch_all();
                $esValido = true;
            }
        }
        return $esValido ? $datosProducto : false;
    }

    //Método que devuelve todos los productos de la base de datos en formato de array.
    public static function listarProductos(){
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        try{
            $consultaBusquedaProductos = $conexionBD->prepare('SELECT * FROM producto');
            if ($consultaBusquedaProductos->num_rows > 0) {
                $datosProducto = $consultaBusquedaProductos->fetch_all();
                $esValido = true;
            }
        }catch(Exception $ex){
            echo "Error: ".$ex->getMessage();
        }
        return $esValido ? $datosProducto : false;
    }
    //Método que guarda un Usuario, lo inserta o lo actualiza.
    public function crearProducto()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        $idProducto = $this->idProducto;
        $nombreProducto = $this->nombre;
        $tipoProducto = $this->tipo;
        $descripcionProducto = $this->descripcion;
        $stockProducto = $this->stock;
        $fechaCreacionProducto = $this->fechaCreacion;
        $origenProducto = $this->origen;
        $precioUnitarioProducto = $this->precioUnitario;
        if (noExisteProducto($idProducto, $conexionBD)) {
            $consultaInsercionProducto = $conexionBD->prepare('INSERT INTO producto VALUES (?,?,?,?,?,?,?,?)');
            $consultaInsercionProducto->bind_param('ssssdssd', $idProducto, $nombreProducto, $tipoProducto, $descripcionProducto, $stockProducto, $fechaCreacionProducto, $origenProducto, $precioUnitarioProducto);
            if ($consultaInsercionProducto->execute()) {
                $esValido = true;
            }
        } else {
            $consultaInsercionProducto = $conexionBD->prepare('UPDATE producto SET nombre = ? , tipo = ?, descripcion = ?, stock = ?, fecha_creacion = ?, origen = ?, precio_ud  WHERE id_producto = ?');
            $consultaInsercionProducto->bind_param('sssdssds', $nombreProducto, $tipoProducto, $descripcionProducto, $stockProducto, $fechaCreacionProducto, $origenProducto, $precioUnitarioProducto, $idProducto);
            if ($consultaInsercionProducto->execute()) {
                $esValido = true;
            }
        }
        return $esValido ? true : false;
    }

}
?>