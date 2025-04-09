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
        header("location: ../Vista/areaAdmin.php");
        exit;
    } else {
        echo "no se ha podido eliminar el usuario.";
    }
} else {
    echo "No se ha podido eliminar el usuario, no se han recibido los datos del formulario.";
}
?>