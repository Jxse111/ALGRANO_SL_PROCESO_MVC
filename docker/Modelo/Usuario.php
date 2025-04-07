<?php
require_once('Algrano.php');
/**
 * Clase que implementa un objeto de tipo Usuario para el acceso a la web.
 *
 * @author José Martínez Estrada
 */
class Usuario
{
    private $dni;
    private $nombre;
    private $contrasena;
    private $direccion;
    private $correo;
    private $fechaNacimiento;

    private $idRolUsuario;
    /**
     * Constructor que crea un usuario.
     * @param mixed $nombre nombre del usuario
     * @param mixed $contrasena contraseña del usuario
     * @param mixed $direccion dirección de la localización del usuario
     * @param mixed $correo correo electrónico del usuario
     * @param mixed $fechaNacimiento fehca de nacimiento del usuario
     */
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario = '1')
    {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->idRolUsuario = $idRolUsuario;
    }

    //Métodos getter y setter

    public function getDni()
    {
        return $this->dni;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }
    public function getdireccion()
    {
        return $this->direccion;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    //Métodos de la estáticos
    //Método que elimina el usuario existente de la base de datos
    public static function eliminarUsuario($dniUsuario)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (existedni($dniUsuario, $conexionBD)) {
            // Eliminar el usuario de la base de datos
            try {
                $consultaEliminacionUsuario = $conexionBD->prepare('DELETE FROM usuario WHERE DNI = ?');
                $consultaEliminacionUsuario->bind_param('s', $dniUsuario);
                if ($consultaEliminacionUsuario->execute()) {
                    $esValido = true;
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        return $esValido ? true : false;
    }

    //Método de búsqueda de usuario, devuelve los datos del usuario encontrado en formato de array.
    public static function buscarUsuario($dniUsuario)
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        if (!noExisteUsuario($dniUsuario, $conexionBD)) {
            $consultaBusquedaUsuario = $conexionBD->prepare('SELECT * FROM usuario WHERE DNI = ?');
            $consultaBusquedaUsuario->bind_param('s', $dniUsuario);
            if ($consultaBusquedaUsuario->execute()) {
                $datosUsuario = $consultaBusquedaUsuario->fetch_all();
                $esValido = true;
            }
        }
        return $esValido ? $datosUsuario : false;
    }

    //Método que lista todos los usuarios de la base de datos
    public static function listarUsuarios()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $usuarios = [];

        $consultaListadoUsuarios = $conexionBD->prepare('SELECT * FROM usuario');
        if ($consultaListadoUsuarios->execute()) {
            $usuarios = $consultaListadoUsuarios->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        return $usuarios;
    }



    //Método que guarda un Usuario, lo inserta o lo actualiza.
    public function guardarUsuario()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $esValido = false;
        $dniUsuario = $this->dni;
        $nombreUsuario = $this->nombre;
        $contraseñaUsuario = $this->contrasena;
        $direccionUsuario = $this->direccion;
        $correoUsuario = $this->correo;
        $fechaNacUsuario = $this->fechaNacimiento;
        $idRolUsuario = $this->idRolUsuario;
        if (noExisteUsuario($dniUsuario, $conexionBD)) {
            // Encriptar la contraseña antes de guardarla
            $contraseñaUsuario = hash("sha512", $contraseñaUsuario);
            try {
                $consultaInsercionUsuario = $conexionBD->prepare('INSERT INTO usuario VALUES (?,?,?,?,?,?,?)');
                $consultaInsercionUsuario->bind_param('sssssss', $dniUsuario, $nombreUsuario, $contraseñaUsuario, $direccionUsuario, $correoUsuario, $fechaNacUsuario, $idRolUsuario);
                if ($consultaInsercionUsuario->execute()) {
                    $esValido = true;
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            $consultaInsercionUsuario = $conexionBD->prepare('UPDATE usuario SET nombre = ? , contraseña = ?, direccion = ?, correo = ?, fecha_nac = ?, id_rol_usuario = ?  WHERE DNI = ?');
            $consultaInsercionUsuario->bind_param('ssssss', $nombreUsuario, $contraseñaUsuario, $direccionUsuario, $correoUsuario, $fechaNacUsuario, $idRolUsuario, $dniUsuario);
            if ($consultaInsercionUsuario->execute()) {
                $esValido = true;
            }
        }
        return $esValido ? true : false;
    }


}
