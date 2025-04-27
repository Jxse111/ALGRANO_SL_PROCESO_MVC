<?php
session_start();
if ($_SESSION['rol'] != "cliente") {
    header("Location: ./index.php");
    exit();
}

require_once '../Modelo/Pedido.php';
require_once '../Modelo/Producto.php';
require_once '../Modelo/Algrano.php';
require_once '../Modelo/funcionesBaseDeDatos.php';
require_once '../Modelo/Usuario.php';

$precioTotalPedido = $_SESSION['total'];
$subtotalesPedido = $_SESSION['subtotales'];
$cantidadesPedido = $_SESSION['cantidad'];
$productosCesta = $_SESSION['cesta'];
$datosCliente = Usuario::buscarUsuarioPorNombre($_SESSION['usuario']);
$dniCliente = $datosCliente[0]['DNI'];
$conexionBD = Algrano::conectarAlgranoMySQLi();

if (isset($_POST['pagar'])) {
    // Obtener último código de pedido
    $ultimoPedido = $conexionBD->query("SELECT codigo_pedido FROM pedido ORDER BY codigo_pedido DESC LIMIT 1");
    $row = $ultimoPedido->fetch_assoc();
    $numeroPedido = empty($row) ? 1 : intval(substr($row['codigo_pedido'], 3)) + 1;
    $codigoPedido = 'PED' . str_pad($numeroPedido, 3, '0', STR_PAD_LEFT);

    date_default_timezone_set('Europe/Madrid');
    $fechaPedido = date('Y-m-d H:i:s');
    $estadoPedido = "Pagado";

    // Insertar el pedido principal
    $pedido = new Pedido($codigoPedido, $dniCliente, null, null, $precioTotalPedido, $fechaPedido, $estadoPedido, null, null, null);

    if ($pedido->crearPedido()) {
        // Procesar cada producto en la cesta
        foreach ($productosCesta as $index => $producto) {
            // Obtener último código de detalle
            $ultimoDetalle = $conexionBD->query("SELECT codigo_detalle FROM pedidos_detalle ORDER BY codigo_detalle DESC LIMIT 1");
            $rowDetalle = $ultimoDetalle->fetch_assoc();
            $numeroDetalle = empty($rowDetalle) ? 1 : intval(substr($rowDetalle['codigo_detalle'], 3)) + 1;
            $codigoDetalle = 'DET' . str_pad($numeroDetalle, 3, '0', STR_PAD_LEFT);

            $datosProducto = Producto::buscarProductoDetallado($producto);
            // Crear detalle del pedido
            $pedido = new Pedido(
                $codigoPedido,
                $dniCliente,
                $producto,
                isset($datosProducto[0]['tipo']) ? $datosProducto[0]['tipo'] : null,
                $precioTotalPedido,
                $fechaPedido,
                $estadoPedido,
                $codigoDetalle,
                $subtotalesPedido[$index],
                $cantidadesPedido[$index]
            );

            $pedido->crearPedido();

            // Actualizar stock del producto
            $conexionBD->query("UPDATE productos_detalle SET stock = stock - " . $cantidadesPedido[$index] .
                " WHERE id_producto_detalle = '" . $producto . "'");
        }

        // Limpiar la sesión
        unset($_SESSION['cesta']);
        unset($_SESSION['total']);
        unset($_SESSION['subtotales']);
        unset($_SESSION['cantidad']);

        header("Location: ../Vista/pedidos.php");
        exit();
    } else {
        echo "Error al crear el pedido.";
    }
}
