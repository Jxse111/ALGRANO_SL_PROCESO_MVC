<?php
require_once('conexiónBD/Algrano.php');
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

    /**
     * Constructor que crea un usuario.
     * @param mixed $nombre nombre del usuario
     * @param mixed $contrasena contraseña del usuario
     * @param mixed $direccion dirección de la localización del usuario
     * @param mixed $correo correo electrónico del usuario
     * @param mixed $fechaNacimiento fehca de nacimiento del usuario
     */
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento)
    {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->fechaNacimiento = $fechaNacimiento;
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
        if (!noExisteUsuario($dniUsuario, $conexionBD)) {
            $consultaEliminacionUsuario = $conexionBD->prepare('DELETE FROM usuario WHERE dni = ?');
            $consultaEliminacionUsuario->bind_param('s', $dniUsuario);
            if ($consultaEliminacionUsuario->execute()) {
                $esValido = true;
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
            $consultaBusquedaUsuario = $conexionBD->prepare('SELECT * FROM usuario WHERE dni = ?');
            $consultaBusquedaUsuario->bind_param('s', $dniUsuario);
            if ($consultaBusquedaUsuario->execute()) {
                $datosUsuario = $consultaBusquedaUsuario->fetch_all();
                $esValido = true;
            }
        }
        return $esValido ? $datosUsuario : false;
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
        if (noExisteUsuario($dniUsuario, $conexionBD)) {
            $consultaInsercionUsuario = $conexionBD->prepare('INSERT INTO usuario VALUES (?,?,?,?,?,?)');
            $consultaInsercionUsuario->bind_param('ssssss', $dniUsuario, $nombreUsuario, $contraseñaUsuario, $direccionUsuario, $correoUsuario, $fechaNacUsuario);
            if ($consultaInsercionUsuario->execute()) {
                $esValido = true;
            }
        } else {
            $consultaInsercionUsuario = $conexionBD->prepare('UPDATE usuario SET nombre = ? , contraseña = ?, direccion = ?, correo = ?, fecha_nac = ? WHERE DNI = ?');
            $consultaInsercionUsuario->bind_param('ssssss', $nombreUsuario, $contraseñaUsuario, $direccionUsuario, $correoUsuario, $fechaNacUsuario, $dniUsuario);
            if ($consultaInsercionUsuario->execute()) {
                $esValido = true;
            }
        }
        return $esValido ? true : false;
    }


}
