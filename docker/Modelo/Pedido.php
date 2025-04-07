<?php

class Pedido
{
    private $codigo;
    private $nombre;
    private $tipo;
    private $precioTotal;
    private $fechaPedido;
    private $estado;

    public function __construct($codigo, $nombre, $tipo, $precioTotal, $fechaPedido, $estado)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->precioTotal = $precioTotal;
        $this->fechaPedido = $fechaPedido;
        $this->estado = $estado;
    }

    //Getter
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getPrecioTotal()
    {
        return $this->precioTotal;
    }

    public function getFechaPedido()
    {
        return $this->fechaPedido;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    //Setter
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setPrecioTotal($precioTotal)
    {
        $this->precioTotal = $precioTotal;
    }

    public function setFechaPedido($fechaPedido)
    {
        $this->fechaPedido = $fechaPedido;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public static function obtenerPedidosCliente($idCliente)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $pedidos = [];
        $consulta = $conexionBD->prepare('SELECT p.* FROM pedido p INNER JOIN usuario u ON p.id_usuario = u.id WHERE u.id = ? AND u.rol = 1');
        $consulta->bind_param('i', $idCliente);
        if ($consulta->execute()) {
            $pedidos = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return $pedidos;
    }
}
