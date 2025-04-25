<?php
require_once './funcionesValidacion.php';
require_once '../Modelo/funcionesBaseDeDatos.php';
require_once '../Modelo/Algrano.php';
require_once '../Modelo/Usuario.php';
// Creación de la conexión
$conexionBD = Algrano::conectarAlgranoMySQLi();
if (filter_has_var(INPUT_POST, "crearCuenta")) {
    try {
        // Validación de los datos recogidos
        $dniValidado = validarDNI(filter_input(INPUT_POST, "DNI"));
        $usuarioValidado = validarUsuario(filter_input(INPUT_POST, "usuario"), $conexionBD);
        $contraseñaValidada = validarContraseña(filter_input(INPUT_POST, "contraseña"), $conexionBD);
        $direcciónValidada = validarDireccion(filter_input(INPUT_POST, "direccion"), $conexionBD);
        $correoValidado = validarCorreo(filter_input(INPUT_POST, "correo"), $conexionBD);
        $fechaNacimientoValidada = validarFechaNacimiento(filter_input(INPUT_POST, "fec_nac"), $conexionBD);
        $camposValidados = $dniValidado && $usuarioValidado && $contraseñaValidada && $direcciónValidada && $correoValidado && $fechaNacimientoValidada;
        //echo var_dump($dniValidado, $usuarioValidado, $contraseñaValidada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada);

        if ($camposValidados) {
            $usuarioRegistro = new Usuario($dniValidado, $usuarioValidado, $contraseñaValidada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada);
            //print_r($usuarioRegistro);
            if ($usuarioRegistro->guardarUsuario()) {
                header("Location: ../Vista/login.html");
                exit;
            }
        }else{
            echo nl2br("Los campos no son válidos o son erróneos." . "\n");
        }
    } catch (Exception $ex) {
        echo nl2br("ERROR: " . $ex->getMessage() . "\n"); ;
        $conexionBD->close();
    }
} else {
    echo nl2br("No se ha podido crear la cuenta, no se han recibido los datos del formulario." . "\n");
}
?>