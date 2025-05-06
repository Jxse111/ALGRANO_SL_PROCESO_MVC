<?php
session_start();
if($_SESSION['rol'] != "administrador"){
    header("location: ../Vista/index.php");
}
if (filter_has_var(INPUT_GET, "id")) {
    require_once '../Modelo/funcionesBaseDeDatos.php';
    require_once '../Modelo/Algrano.php';
    require_once '../Modelo/Usuario.php';
    $conexionBD = Algrano::conectarAlgranoMySQLi();
    $dniUsuario = filter_input(INPUT_GET, 'id');
    //echo $dniUsuario;
    if (Usuario::eliminarUsuario($dniUsuario)) {
        header("location: ../Vista/areaAdmin.php?success=Usuario eliminado con éxito.");
        exit;
    } else {
        header("location: ../Vista/areaAdmin.php?error=ERROR:El usuario no se ha podido eliminar.");
    }
} else {
    header("location: ../Vista/areaAdmin.php?error=EL usuario no se encuentra en el sistema.");
}
?>