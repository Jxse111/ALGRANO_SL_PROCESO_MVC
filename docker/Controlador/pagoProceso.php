<?php
session_start();
if ($_SESSION['rol'] != "cliente") {
    header("Location: ./index.php");
    exit();
}
print_r(value: $_SESSION);
require_once '../Modelo/Pedido.php';
require_once '../Modelo/Producto.php';
require_once '../Modelo/Algrano.php';
require_once '../Modelo/funcionesBaseDeDatos.php';
require_once '../Modelo/Usuario.php';

$datosCliente = Usuario::buscarUsuarioPorNombre($_SESSION['usuario']);
$datosProducto = Producto::buscarProducto($_SESSION['producto']);
$dniCliente = $datosCliente[0]['DNI'];
$idProducto = $datosProducto[0]['id_producto'];
$tipoProducto = $datosProducto[0]['tipo'];
$cantidad = $_SESSION['cantidad'];
$total = $_SESSION['total'];
$subtotal = $_SESSION['subtotales'];
$fechaPedido = date('Y-m-d H:i:s');
$estadoPedido = "Pagado";
$conexionBD = Algrano::conectarAlgranoMySQLi();

if (isset($_POST['pagar'])) {
    // Obtener último código de pedido
    $ultimoPedido = $conexionBD->query("SELECT codigo_pedido FROM pedidos ORDER BY codigo_pedido DESC LIMIT 1");
    $row = $ultimoPedido->fetch_assoc();
    $numeroPedido = empty($row) ? 1 : intval(substr($row['codigo_pedido'], 3)) + 1;
    $codigoPedido = 'PED' . str_pad($numeroPedido, 3, '0', STR_PAD_LEFT);

    // Obtener último código de detalle
    $ultimoDetalle = $conexionBD->query("SELECT codigo_detalle FROM pedido_detalle ORDER BY codigo_detalle DESC LIMIT 1");
    $rowDetalle = $ultimoDetalle->fetch_assoc();
    $numeroDetalle = empty($rowDetalle) ? 1 : intval(substr($rowDetalle['codigo_detalle'], 3)) + 1;
    $codigoDetalle = 'DET' . str_pad($numeroDetalle, 3, '0', STR_PAD_LEFT);

    $pedido = new Pedido($codigoPedido, $dniCliente, $idProducto, $tipoProducto, $total, $fechaPedido, $estadoPedido, $codigoDetalle, $subtotal, $cantidad);
    if ($pedido->crearPedido()) {
        // Actualizar el stock del producto
        //$producto = new Producto($idProducto, null, null, null, null, null, null, null);
        //$producto->crearProducto();
        // Redirigir a la página de éxito
        header("Location: ../Vista/pedidos.php");
    } else {
        echo "Error al crear el pedido.";
    }
}
