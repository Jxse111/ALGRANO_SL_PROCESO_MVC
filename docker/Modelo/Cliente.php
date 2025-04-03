<?php

require_once 'Usuario.php';

class Cliente extends Usuario
{
    // Aquí puedes agregar propiedades y métodos específicos para la clase Cliente
    private $codigoCliente;
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $codigoCliente, $idRolUsuario = '02', )
    {
        parent::__construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario);
        $this->codigoCliente = $codigoCliente;
    }

    public function getCodigoCliente()
    {
        return $this->codigoCliente;
    }

    //Método que lista todos los clientes de la base de datos
    public static function listarClientes()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $clientes = [];

        $consultaListadoClientes = $conexionBD->prepare('SELECT * FROM cliente');
        if ($consultaListadoClientes->execute()) {
            $clientes = $consultaListadoClientes->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        return $clientes;
    }
}
