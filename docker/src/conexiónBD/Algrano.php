<?php
/**
 * Clase que implementa métodos de conexión a la base de datos Algrano.
 *
 * @author José Martínez Estrada
 */
class Algrano
{

    private static $conexionBD = null;

    /**
     * Método que establece  una conexión con la base de datos de Algrano mediante MySQLi
     * devuelve el objeto con la conexión establecida.
     */
    public static function conectarEspectaculosMySQLi()
    {
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $bd = "algrano";
        if (is_null(Algrano::$conexionBD)) {
            Algrano::$conexionBD = new mysqli();
            self::$conexionBD->connect($host, $usuario, $contrasena, $bd);
        }
        return Algrano::$conexionBD;
    }
}
