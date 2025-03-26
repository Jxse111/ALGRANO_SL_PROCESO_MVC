<?php

require_once 'Usuario.php';

class Cliente extends Usuario
{
    // Aquí puedes agregar propiedades y métodos específicos para la clase Cliente
    private $codigoCliente;
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario = '02', $codigoCliente)
    {
        parent::__construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario);
        $this->codigoCliente = $codigoCliente;
    }
}
?>