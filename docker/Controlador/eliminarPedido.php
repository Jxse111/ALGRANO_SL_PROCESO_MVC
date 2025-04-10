<?php
session_start();
if ($_SESSION['rol'] != "empleado") {
    header("location: ../Vista/index.php");
}
if (filter_has_var(INPUT_GET, "id")) {
    require_once '../Modelo/funcionesBaseDeDatos.php';
    require_once '../Modelo/Algrano.php';
    require_once '../Modelo/Pedido.php';
    $conexionBD = Algrano::conectarAlgranoMySQLi();
    $codigoPedido = filter_input(INPUT_GET, 'id');
    //echo $dniUsuario;
    if (Pedido::eliminarPedido($codigoPedido) && Pedido::eliminarPedidoDetallado($codigoPedido)) {
        header("location: ../Vista/areaEmpleado.php");
        exit;
    } else {
        echo "no se ha podido eliminar el pedido.";
    }
} else {
    echo "No se ha podido eliminar el pedido, no se han recibido los datos del formulario.";
}
?>