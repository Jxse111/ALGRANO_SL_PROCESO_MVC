<?php
session_start();
if ($_SESSION['rol'] != 'cliente') {
    header('Location: /ALGRANO_SL_PROCESO_MVC/index.php?error=No tienes permisos para acceder a esta página.');
    exit;
} else {
    require_once '../Modelo/Producto.php';
    $codigoProducto = filter_input(INPUT_POST, 'producto_id');

    if (isset($codigoProducto)) {
        $_SESSION['cesta'] = $codigoProducto;
        $_SESSION['cantidad'] = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
        header('Location: ../Vista/carrito.php?success=Producto añadido al carrito con éxito.');
    } else {
        header('Location: ../Vista/menu.php?error=Error al añadir un producto al carrito de la compra.');
    }
}
?>