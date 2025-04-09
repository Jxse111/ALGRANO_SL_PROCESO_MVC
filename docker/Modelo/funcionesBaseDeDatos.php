<?php
require_once 'patrones.php';

function noExisteCodigoCliente($codigo, $conexionBD)
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
        if ($usuarioExistente['DNI'] != $dni) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function noExisteContraseña($contraseña, $conexionBD)
{
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM usuario");
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
    $consultaCorreosExistentes = $conexionBD->query('SELECT correo FROM usuario');
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
    $consultaDireccionesExistentes = $conexionBD->query('SELECT direccion FROM usuario');
    $direcciones = $consultaDireccionesExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($direcciones as $direccionExistente) {
        if ($direccionExistente['direccion'] != $direccion) {
            $direccionNoExiste = true;
        }
    }
    return $direccionNoExiste ? true : false;
}

function noExisteFechaNacimiento($fecha, $conexionBD)
{
    $fechaNoExiste = false;
    $consultaFechasExistentes = $conexionBD->query('SELECT fec_nac FROM usuario');
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
    $consultaUsuariosExistentes = $conexionBD->query("SELECT usuario FROM usuario");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['usuario'] == $usuario) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function existeDni($dni, $conexionBD)
{
    $usuarioNoExiste = false;
    $consultaUsuariosExistentes = $conexionBD->query("SELECT DNI FROM usuario");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['DNI'] == $dni) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function existeContraseña($contraseña, $conexionBD)
{
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM usuario");
    $contraseñas = $consultaContraseñasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($contraseñas as $constraseñasExistentes) {
        if ($constraseñasExistentes['contraseña'] == $contraseña) {
            $contraseñaNoExiste = true;
        }
    }
    return $contraseñaNoExiste ? true : false;
}

function noExisteProducto($idProducto, $conexionBD)
{
    $productoNoExiste = false;
    $consultaProductosExistentes = $conexionBD->query("SELECT id_producto FROM producto");
    $productos = $consultaProductosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($productos as $productoExistente) {
        if ($productoExistente['id_producto'] != $idProducto) {
            $productoNoExiste = true;
        }
    }
    return $productoNoExiste ? true : false;
}

function existeProducto($idProducto, $conexionBD)
{
    $productoExiste = false;
    $consultaProductosExistentes = $conexionBD->query("SELECT id_producto FROM producto");
    $productos = $consultaProductosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($productos as $producto) {
        if ($producto['id_producto'] == $idProducto) {
            $productoExiste = true;
        }
    }
    return $productoExiste ? true : false;
}

function existeProductoDetalle($idProducto, $conexionBD)
{
    $productoExiste = false;
    $consultaProductosExistentes = $conexionBD->query("SELECT id_productos_detalle FROM producto");
    $productos = $consultaProductosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($productos as $producto) {
        if ($producto['id_producto_detalle'] == $idProducto) {
            $productoExiste = true;
        }
    }
    return $productoExiste ? true : false;
}