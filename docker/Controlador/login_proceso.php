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

if (filter_has_var(INPUT_POST, "entrar") || filter_has_var(INPUT_POST, "entrar")) {
    // Check if user is already logged in
    if (isset($_SESSION['cliente'])) {
        header("Location: ../Vista/index.php");
        exit();
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
                //echo var_dump($usuarioLogin);
                // Validate the user exists
                if (empty($usuarioLogin)) {
                    $mensajeError .= "El nombre de usuario no puede estar vacío.\n";
                } else {
                    // Validate the user with the database
                    $usuarioLogin = validarUsuarioExistente($usuarioLogin, $conexionBD);
                    if ($usuarioLogin) {
                        // Extract the password of the registered user
                        $conexionBD->autocommit(false);
                        $consultaSesiones = $conexionBD->query("SELECT contraseña FROM usuario WHERE usuario='$usuarioLogin'");

                        if ($consultaSesiones && $consultaSesiones->num_rows > 0) {
                            $contraseña = $consultaSesiones->fetch_all(MYSQLI_ASSOC);

                            foreach ($contraseña as $contraseñaExistente) {
                                //echo var_dump($contraseñaExistente['contraseña']);
                                // If the two encrypted passwords are exact, the session login is successful.
                                $contraseñaEncriptada = hash("sha512", filter_input(INPUT_POST, "contraseñaExistente"));
                                //echo var_dump(value: $contraseñaEncriptada);
                                $esValida = $contraseñaEncriptada === $contraseñaExistente['contraseña'];
                                $registroExistoso = $consultaSesiones->num_rows > 0 && $esValida;

                                if ($esValida) {
                                    // Set the user in the session
                                    $_SESSION['usuario'] = $usuarioLogin;

                                    $mensajeExito .= "Inicio de Sesión realizado con éxito. \n";
                                    $buscarRolUsuarioRegistrado = $conexionBD->query("SELECT id_rol_usuario FROM usuario WHERE usuario='$usuarioLogin'");

                                    if ($buscarRolUsuarioRegistrado) {
                                        $mensajeExito .= "Rol recuperado con éxito.\n";
                                        $rolUsuarioRegistrado = $buscarRolUsuarioRegistrado->fetch_column();
                                        $buscarTipoRolUsuarioRegistrado = $conexionBD->query("SELECT rol FROM rol WHERE id_rol='$rolUsuarioRegistrado'");

                                        if ($buscarTipoRolUsuarioRegistrado) {
                                            $mensajeExito .= "Tipo de rol encontrado.\n";
                                            $rol = $buscarTipoRolUsuarioRegistrado->fetch_column();
                                            $_SESSION['rol'] = $rol;

                                            // Redirect based on user role
                                            switch ($_SESSION['rol']) {
                                                case "cliente":
                                                    header("Location: ../Vista/index.php");
                                                    break;
                                                case "empleado":
                                                    header("Location: ../Vista/index.php");
                                                    break;
                                                case "administrador":
                                                    header("Location: ../Vista/index.php");
                                                    break;

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