<?php

require_once 'Usuario.php';

class Empleado extends Usuario
{
    // Aquí puedes agregar propiedades y métodos específicos para la clase Empleado
    private $puesto;
    private $departamento;
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario = '03', $puesto, $departamento)
    {
        parent::__construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario);
        $this->puesto = $puesto;
        $this->departamento = $departamento;
    }
}
?>