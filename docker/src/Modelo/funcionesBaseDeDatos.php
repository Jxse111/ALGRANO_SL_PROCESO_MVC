<?php

require_once 'patrones.php';
require_once 'Algrano.php';
$conexionBD = Algrano::conectarAlgranoMySQLi();

function noExisteCodigo($codigo, $conexionBD)
{
    $codigoNoExiste = false;
    $consultaCodigosExistentes = $conexionBD->query('SELECT codigo FROM cliente');
    $codigos = $consultaCodigosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($codigos as $codigoExistente) {
        if ($codigoExistente['codigo'] != $codigo) {
            $codigoNoExiste = true;
        }
    }
    return $codigoNoExiste ? true : false;
}

function noExisteUsuario($dni, $conexionBD)
{
    $usuarioNoExiste = false;
    $consultaUsuariosExistentes = $conexionBD->query("SELECT DNI FROM usuario");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['dni'] != $dni) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}


function noExisteContraseña($contraseña, $conexionBD)
{
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM cliente");
    $contraseñas = $consultaContraseñasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($contraseñas as $constraseñasExistentes) {
        if ($constraseñasExistentes['contraseña'] != $contraseña) {
            $contraseñaNoExiste = true;
        }
    }
    return $contraseñaNoExiste ? true : false;
}

function noExisteCorreo($correo, $conexionBD)
{
    $correoNoExiste = false;
    $consultaCorreosExistentes = $conexionBD->query('SELECT correo FROM cliente');
    $correos = $consultaCorreosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($correos as $correoExistente) {
        if ($correoExistente['correo'] != $correo) {
            $correoNoExiste = true;
        }
    }
    return $correoNoExiste ? true : false;
}

function noExisteDireccion($direccion, $conexionBD)
{
    $direccionNoExiste = false;
    $consultaDireccionesExistentes = $conexionBD->query('SELECT direccion FROM cliente');
    $direcciones = $consultaDireccionesExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($direcciones as $direccionExistente) {
        if ($direccionExistente['fec_nac'] != $direccion) {
            $direccionNoExiste = true;
        }
    }
    return $direccionNoExiste ? true : false;
}

function noExisteFechaNacimiento($fecha, $conexionBD)
{
    $fechaNoExiste = false;
    $consultaFechasExistentes = $conexionBD->query('SELECT correo FROM cliente');
    $fechas = $consultaFechasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($fechas as $fechaExistente) {
        if ($fechaExistente['fec_nac'] != $fecha) {
            $fechaNoExiste = true;
        }
    }
    return $fechaNoExiste ? true : false;
}

function existeUsuario($usuario, $conexionBD)
{
    $usuarioNoExiste = false;
    $consultaUsuariosExistentes = $conexionBD->query("SELECT usuario FROM cliente");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['usuario'] == $usuario) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function existeContraseña($contraseña, $conexionBD)
{
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM cliente");
    $contraseñas = $consultaContraseñasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($contraseñas as $constraseñasExistentes) {
        if ($constraseñasExistentes['contraseña'] == $contraseña) {
            $contraseñaNoExiste = true;
        }
    }
    return $contraseñaNoExiste ? true : false;
}