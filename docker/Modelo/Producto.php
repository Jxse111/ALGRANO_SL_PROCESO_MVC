<?php
require_once 'Algrano.php';
require_once 'funcionesBaseDeDatos.php';
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

    public function __construct($idProducto, $nombre, $descripcion, $fechaCreacion, $origen, $precioUnitario, $stock = 1, $tipo = "Grano")
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
        if (existeProducto($idProducto, $conexionBD)) {
            $consultaEliminacionProducto = $conexionBD->prepare('DELETE FROM producto WHERE id_producto = ?');
            $consultaEliminacionProducto->bind_param('s', $idProducto);
            if ($consultaEliminacionProducto->execute()) {
                $esValido = true;
            }
        }
        return $esValido ? true : false;
    }

    public static function eliminarProductoDetallado($idProducto)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (existeProducto($$idProducto, $conexionBD)) {
            $consultaEliminacionProducto = $conexionBD->prepare('DELETE FROM productos_detalle WHERE id_producto_detalle = ?');
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
        if (existeProducto($idProducto, $conexionBD)) {
            $consultaBusquedaProducto = $conexionBD->prepare('SELECT * FROM producto WHERE id_producto = ?');
            $consultaBusquedaProducto->bind_param('s', $idProducto);
            if ($consultaBusquedaProducto->execute()) {
                $datosProducto = $consultaBusquedaProducto->get_result()->fetch_all(MYSQLI_ASSOC);
                $esValido = true;
            }
        }
        return $esValido ? $datosProducto : false;
    }

    public static function buscarProductoDetallado($idProducto)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (existeProducto($idProducto, $conexionBD)) {
            $consultaBusquedaProducto = $conexionBD->prepare('SELECT * FROM productos_detalle WHERE id_producto_detalle = ?');
            $consultaBusquedaProducto->bind_param('s', $idProducto);
            if ($consultaBusquedaProducto->execute()) {
                $datosProducto = $consultaBusquedaProducto->get_result()->fetch_all(MYSQLI_ASSOC);
                $esValido = true;
            }
        }
        return $esValido ? $datosProducto : false;
    }

    //Método que devuelve todos los productos de la base de datos en formato de array.
    public static function listarProductos()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $productos = [];
        $consultaBusquedaProductos = $conexionBD->prepare('SELECT * FROM producto');
        if ($consultaBusquedaProductos->execute()) {
            $productos = $consultaBusquedaProductos->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        return $productos;
    }

    public static function listarProductosDetallados()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $productos = [];
        $consultaBusquedaProductos = $conexionBD->prepare('SELECT * FROM productos_detalle');
        if ($consultaBusquedaProductos->execute()) {
            $productos = $consultaBusquedaProductos->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        return $productos;
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
        if (!existeProducto($idProducto, $conexionBD)) {
            $consultaInsercionProducto = $conexionBD->prepare('INSERT INTO producto VALUES (?,?,?)');
            $consultaInsercionProducto->bind_param('sss', $idProducto, $nombreProducto, $precioUnitarioProducto);
            if ($consultaInsercionProducto->execute()) {
                $consultaInsercionProductoDetalle = $conexionBD->prepare('INSERT INTO productos_detalle VALUES (?,?,?,?,?,?,?)');
                $consultaInsercionProductoDetalle->bind_param('ssssdss', $idProducto, $nombreProducto, $tipoProducto, $descripcionProducto, $stockProducto, $fechaCreacionProducto, $origenProducto);
                if ($consultaInsercionProductoDetalle->execute()) {
                    $esValido = true;
                }
            }
        } else {
            $consultaInsercionProducto = $conexionBD->prepare('UPDATE producto SET nombre = ? , precio_ud = ? WHERE id_producto = ?');
            $consultaInsercionProducto->bind_param('sss', $nombreProducto, $precioUnitarioProducto, $idProducto);
            if ($consultaInsercionProducto->execute()) {
                $consultaInsercionProductoDetalle = $conexionBD->prepare('UPDATE productos_detalle SET nombre = ? , tipo = ?, descripcion = ?, stock = ?, fecha_creacion = ?, origen = ? WHERE id_producto_detalle = ?');
                $consultaInsercionProductoDetalle->bind_param('sssdsss', $nombreProducto, $tipoProducto, $descripcionProducto, $stockProducto, $fechaCreacionProducto, $origenProducto, $idProducto);
                if($consultaInsercionProductoDetalle->execute()){
                    $esValido = true;
                }
            }
        }
        return $esValido ? true : false;
    }

}
?>