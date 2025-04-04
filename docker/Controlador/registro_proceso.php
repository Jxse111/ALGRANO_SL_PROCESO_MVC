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
    require_once '../Modelo/Usuario.php';
    //creación de la conexión
    $conexionBD = Algrano::conectarAlgranoMySQLi();
    $mensajeError = "Lista de mensajes de error: ";
    $mensajeExito = "Lista de mensajes de éxito: ";
    echo "Buenos dias, bienvenido a la página de registro de Algrano. <br>";
    if (filter_has_var(INPUT_POST, "crearCuenta")) {
        try {
            //Validación de los datos recogidos
            $dniValidado = validarDNI(filter_input(INPUT_POST, "DNI"));
            $usuarioValidado = validarUsuario(filter_input(INPUT_POST, "usuario"), $conexionBD);
            $contraseñaValidada = validarContraseña(filter_input(INPUT_POST, "contraseña"), $conexionBD);
            $direcciónValidada = validarDireccion(filter_input(INPUT_POST, "direccion"), $conexionBD);
            $correoValidado = validarCorreo(filter_input(INPUT_POST, "correo"), $conexionBD);
            $fechaNacimientoValidada = validarFechaNacimiento(filter_input(INPUT_POST, "fec_nac"), $conexionBD);
            $camposValidados = $dniValidado && $usuarioValidado && $contraseñaValidada && $direcciónValidada && $correoValidado && $fechaNacimientoValidada;
            echo var_dump($dniValidado, $usuarioValidado, $contraseñaValidada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada);
            if ($camposValidados) {
                $mensajeExito .= "Datos recibidos y validados correctamente. ";
                $usuarioRegistro = new Usuario($dniValidado, $usuarioValidado, $contraseñaValidada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada);
                print_r($usuarioRegistro);
                echo "Usuario en proceso de registro...";
                if ($usuarioRegistro->guardarUsuario()) {
                    header("Location: ../Vista/login.html");
                }
            }
        } catch (Exception $ex) {
            $mensajeError .= "ERROR: " . $ex->getMessage();
            $conexionBD->close();
        }
    } else {
        echo "No se ha podido crear la cuenta, no se han recibido los datos del formulario.";
    }
    ?>
</body>

</html>