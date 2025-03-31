<?php
// Start the session at the very beginning before any output
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './funcionesValidacion.php';
require_once '../Modelo/funcionesBaseDeDatos.php';
require_once '../Modelo/Algrano.php';

$mensajeError = "Mensajes de error : ";
$mensajeExito = "Mensajes de éxito: ";
$registroExistoso = false;

/* En el caso de que se pulse el boton Crear cuenta del formulario de inicio de sesión,
 *  serás redirigido al formulario de registro
 */
if (filter_has_var(INPUT_POST, "Registrarse")) {
    header("Location: ../Vista/registro.html");
    die();
} elseif (filter_has_var(INPUT_POST, "entrar") || filter_has_var(INPUT_POST, "Entrar")) {
    // Check if user is already logged in
    if (isset($_SESSION['usuario'])) {
        $mensajeSesion = "El usuario registrado tiene una sesión activa";
    } else {
        // Create database connection BEFORE trying to use it
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        
        // Validate the connection was successful
        if (!$conexionBD) {
            $mensajeError .= "No se pudo establecer conexión con la base de datos.\n";
        } else {
            try {
                // Get the username from the form
                $usuarioLogin = filter_input(INPUT_POST, "usuarioExistente");
                
                // Validate the user exists
                if (empty($usuarioLogin)) {
                    $mensajeError .= "El nombre de usuario no puede estar vacío.\n";
                } else {
                    // Validate the user with the database
                    $usuarioLogin = validarUsuarioExistente($usuarioLogin, $conexionBD);
                    
                    if ($usuarioLogin) {
                        // Extract the password of the registered user
                        $conexionBD->autocommit(false);
                        $consultaSesiones = $conexionBD->query("SELECT contraseña FROM usuarios WHERE login='$usuarioLogin'");
                        
                        if ($consultaSesiones && $consultaSesiones->num_rows > 0) {
                            $contraseña = $consultaSesiones->fetch_all(MYSQLI_ASSOC);
                            
                            foreach ($contraseña as $contraseñaExistente) {
                                // If the two encrypted passwords are exact, the session login is successful.
                                $contraseñaEncriptada = hash("sha512", filter_input(INPUT_POST, "contraseñaExistente"));
                                $esValida = $contraseñaEncriptada === $contraseñaExistente['contraseña'];
                                $registroExistoso = $consultaSesiones->num_rows > 0 && $esValida;
                                
                                if ($esValida) {
                                    // Set the user in the session
                                    $_SESSION['usuario'] = $usuarioLogin;
                                    
                                    $mensajeExito .= "Inicio de Sesión realizado con éxito. \n";
                                    $buscarRolUsuarioRegistrado = $conexionBD->query("SELECT id_rol FROM usuarios WHERE login='$usuarioLogin'");
                                    
                                    if ($buscarRolUsuarioRegistrado) {
                                        $mensajeExito .= "Rol recuperado con éxito.\n";
                                        $rolUsuarioRegistrado = $buscarRolUsuarioRegistrado->fetch_column();
                                        $buscarTipoRolUsuarioRegistrado = $conexionBD->query("SELECT tipo FROM roles WHERE id_rol='$rolUsuarioRegistrado'");
                                        
                                        if ($buscarTipoRolUsuarioRegistrado) {
                                            $mensajeExito .= "Tipo de rol encontrado.\n";
                                            $rol = $buscarTipoRolUsuarioRegistrado->fetch_column();
                                            $_SESSION['rol'] = $rol;
                                            
                                            // Redirect based on user role
                                            switch ($_SESSION['rol']) {
                                                case "Cliente":
                                                    header("Location: ../Vista/indexLogin.php");
                                                    exit();
                                                case "Empleado":
                                                    header("Location: ../Vista/areaTrabajo.php");
                                                    exit();
                                                case "invitado":
                                                    header("Location: ../Vista/index.html");
                                                    exit();
                                            }
                                        } else {
                                            $mensajeError .= "Tipo de rol no encontrado.\n";
                                        }
                                    } else {
                                        $mensajeError .= "No se ha podido recuperar el rol.\n";
                                    }
                                } else {
                                    $mensajeError .= "No se ha podido iniciar sesión, la contraseña o el usuario no son correctos.\n";
                                }
                            }
                        } else {
                            $mensajeError .= "La consulta no se ha podido realizar o el usuario no existe.\n";
                        }
                    } else {
                        $mensajeError .= "Los datos son inválidos o incorrectos.\n";
                    }
                }
            } catch (Exception $ex) {
                $mensajeError .= "ERROR: " . $ex->getMessage();
            }
            
            // Close the database connection
            Algrano::desconectar();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Proceso de Login</title>
</head>
<body>
    <h2>LISTA DE MENSAJES: </h2>
    <?php if ($mensajeError != "Mensajes de error : " && !$registroExistoso) { ?>
        <h2>Mensajes de error: </h2>
        <ul>
            <li><?php echo nl2br($mensajeError); ?></li>
        </ul>
    <?php } ?>
    
    <?php if ($mensajeExito != "Mensajes de éxito: " && $registroExistoso) { ?>
        <h2>Mensajes de éxito: </h2>
        <ul>
            <li><?php echo nl2br($mensajeExito); ?></li>
        </ul>
    <?php } ?>
    
    <br><br>
    <?php if ($registroExistoso) { ?>
        <form action="sesionUsuario.php" method="post">
            <button type="submit" name="Acceder">Acceder</button>
        </form>
    <?php } else { ?>
        <a href="../index.php">Volver al inicio</a>
    <?php } ?>
</body>
</html>