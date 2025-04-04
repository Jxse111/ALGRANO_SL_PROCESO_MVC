<?php

require_once 'Usuario.php';

class Empleado extends Usuario
{
    // Aquí puedes agregar propiedades y métodos específicos para la clase Empleado
    private $puesto;
    private $departamento;
    private $claveUnica;
    public function __construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $puesto, $departamento, $claveUnica, $idRolUsuario = '03')
    {
        parent::__construct($dni, $nombre, $contrasena, $direccion, $correo, $fechaNacimiento, $idRolUsuario);
        $this->puesto = $puesto;
        $this->departamento = $departamento;
        $this->claveUnica = $claveUnica;
    }

    public function getPuesto()
    {
        return $this->puesto;
    }


    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function getClaveUnica()
    {
        return $this->claveUnica;
    }
    //Método que lista todos los empleados de la base de datos
    public static function listarEmpleados()
    {
        $conexionBD = Algrano::conectarAlgranoMySQLi();
        $empleados = [];

        $consultaListadoEmpleados = $conexionBD->prepare('SELECT * FROM empleado');
        if ($consultaListadoEmpleados->execute()) {
            $empleados = $consultaListadoEmpleados->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        return $empleados;
    }
}
