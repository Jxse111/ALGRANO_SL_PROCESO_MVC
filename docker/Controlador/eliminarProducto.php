<?php
session_start();
if($_SESSION['rol'] != "empleado"){
    header("location: ../Vista/index.php");
}
if (filter_has_var(INPUT_GET, "id")) {
    require_once '../Modelo/funcionesBaseDeDatos.php';
    require_once '../Modelo/Algrano.php';
    require_once '../Modelo/Producto.php';
    $conexionBD = Algrano::conectarAlgranoMySQLi();
    $codigoProducto = filter_input(INPUT_GET, 'id');
    //echo $dniUsuario;
    if (Producto::eliminarProducto($codigoProducto) && Producto::eliminarProductoDetallado($codigoProducto)) {
        header("location: ../Vista/areaEmpleado.php");
        exit;
    } else {
        echo "no se ha podido eliminar el producto.";
    }
} else {
    echo "No se ha podido eliminar el producto, no se han recibido los datos del formulario.";
}
?>