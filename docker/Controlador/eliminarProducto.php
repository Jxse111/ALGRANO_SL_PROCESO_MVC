<?php
session_start();
if ($_SESSION['rol'] != "empleado") {
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
        header("location: ../Vista/areaEmpleado.php?success=Producto eliminado con éxito.");
        exit;
    } else {
        header(header: "location: ../Vista/areaEmpleado.php?error=ERROR:El producto no se ha podido eliminar.");
    }
} else {
    header(header: "location: ../Vista/areaEmpleado.php?error=ERROR:Producto no encontrado en el sistema.");
}
