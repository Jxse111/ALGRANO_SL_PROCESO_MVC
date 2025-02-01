<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    require_once './funcionesValidacion.php';
    require_once './funcionesBaseDeDatos.php';
    //creación de la conexión
    $conexionBD = new mysqli();
    $mensajeError = "Mensajes de error: ";
    $mensajeExito = "Mensajes de exito: ";

    try {
        $conexionBD->connect("localhost", "root", "", "algrano");
    } catch (Exception $ex) {
        $mensajeError .= "ERROR: " . $ex->getMessage();
    }
    if ($conexionBD) {
        try {
            $busquedaUltimoCodigo = $conexionBD->query("SELECT codigo FROM cliente ORDER BY codigo ASC LIMIT 1");
            if ($busquedaUltimoCodigo->num_rows > 0) {
                $ultimoCodigoCliente = $busquedaUltimoCodigo->fetch_all(MYSQLI_ASSOC);
                foreach ($ultimoCodigoCliente as $codigoCliente) {
                    $codigoClienteValidado = $codigoCliente;
                }
            }
        } catch (Exception $ex) {
            $mensajeError .= "" . $ex->getMessage();
        }
    }
    if (filter_has_var(INPUT_POST, "enviar")) {
        try {
            //Extraer el codigo anterior registrado en la base de datos ('SELECT codigo FROM cliente ORDER BY codigo ASC LIMIT 1';)
            //Extraer en query y obtener el codigo anterior y sumar para asignar al siguiente cliente

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
                $consultaInsercionUsuarios = $conexionBD->stmt_init();
                $consultaInsercionUsuarios->prepare("INSERT INTO cliente (codigo,usuario,contraseña,dirección,correo,fec_nac) VALUES (?,?,?,?,?,?)");
                $contraseñaEncriptada = hash("sha512", $contraseñaValidada);
                $consultaInsercionUsuarios->bind_param("ssssss", $codigoClienteValidado, $usuarioValidado, $contraseñaEncriptada, $direcciónValidada, $correoValidado, $fechaNacimientoValidada);
                if ($consultaInsercionUsuarios->execute()) {
                    $mensajeExito .= "Registro insertado correctamente. ";
                    $conexionBD->close();
                } else {
                    $mensajeError .= "La inserción no se ha podido realizar. ";
                }
            } else {
                $mensajeError .= "Los datos son inválidos o incorrectos. ";
            }
        } catch (Exception $ex) {
            $mensajeError .= "ERROR: " . $ex->getMessage();
            $conexionBD->close();
        }
    ?>
        <h2>LISTA DE MENSAJES: </h2>
        <ul>
            <li><?php echo $mensajeError ?></li>
        </ul><br>
        <ul>
            <li><?php echo $mensajeExito ?></li>
        </ul>
    <?php } ?>
</body>

</html>