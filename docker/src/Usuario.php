<?php

/**
 * Clase que implementa un objeto de tipo Usuario para el acceso a la web.
 *
 * @author José Martínez Estrada
 */
abstract class Usuario
{
    private $nombre;
    private $contrasena;
    private $direccion;
    private $correo;
    private DateTime $fechaNacimiento;

    /**
     * Constructor que crea un usuario.
     * @param mixed $nombre nombre del usuario
     * @param mixed $contrasena contraseña del usuario
     * @param mixed $direccion dirección de la localización del usuario
     * @param mixed $correo correo electrónico del usuario
     * @param DateTime $fechaNacimiento fehca de nacimiento del usuario
     */
    public function __construct($nombre, $contrasena, $direccion, $correo, DateTime $fechaNacimiento)
    {
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->fechaNacimiento = $fechaNacimiento;
    }
}
