<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    require_once './funcionesValidacion.php';
    require_once '../Modelo/funcionesBaseDeDatos.php';
    require_once '../Modelo/Algrano.php';
    //creación de la conexión
    $conexionBD = Algrano::conectarAlgranoMySQLi();

    if (filter_has_var(INPUT_POST, "crearCuenta")) {
        try {
            //Validación de los datos recogidos
            $usuarioValidado = validarUsuario(filter_input(INPUT_POST, "usuario"), $conexionBD);
            $contraseñaValidada = validarContraseña(filter_input(INPUT_POST, "contraseña"), $conexionBD);
            $direcciónValidada = validarDireccion(filter_input(INPUT_POST, "dirección"), $conexionBD);
            $correoValidado = validarCorreo(filter_input(INPUT_POST, "correo"), $conexionBD);
            $fechaNacimientoValidada = validarFechaNacimiento(filter_input(INPUT_POST, "fec_nac"), $conexionBD);
            $camposValidados = $codigoClienteValidado && $usuarioValidado && $contraseñaValidada && $direcciónValidada && $correoValidado && $fechaNacimientoValidada;
            //echo var_dump(códigoValidado,$usuarioValidado, $contraseñaValidada,direcciónValidada,$correoValidado,fechaNacimientoValidada);
            if ($camposValidados) {
                $mensajeExito .= "Datos recibidos y validados correctamente. ";
                $usuarioRegistro = new Usuario($codigoClienteValidado, $usuarioValidado, $contraseñaValidada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada,'1');
                if ($usuarioRegistro->guardarUsuario()) {
                    header(header: "Location: ../Vista/login.html");
                } else {
                    header(header: "Location: ../ERRORES/ERROR_LOGIN.html");
                }
            } else {
                header(header: "Location: ../ERRORES/ERROR_DATOS_INCORRECTOS.html");
            }
        } catch (Exception $ex) {
            $mensajeError .= "ERROR: " . $ex->getMessage();
            $conexionBD->close();
        }
    }
    ?>
</body>

</html>