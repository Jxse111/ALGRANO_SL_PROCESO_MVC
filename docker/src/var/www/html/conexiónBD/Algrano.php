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
     * Método que establece  una conexión con la base de datos mediante MySQLi
     * @return Algrano::conexionBD el objeto con la conexión establecida
     */
    public static function conectarAlgranoMySQLi()
    {
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $bd = "algrano";
        if (is_null(Algrano::$conexionBD)) {
            Algrano::$conexionBD = new mysqli();
            self::$conexionBD->connect($host, $usuario, $contrasena, $bd);
        }
        return self::$conexionBD;
    }

    /**
     * Método que establece una coneión con la base de datos mediante PDO
     * @return Algrano::conexionBD el objeto con la conexión establecida
     */
    public static function conectarAlgranoPDO()
    {
        $driver = "mysql";
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $bd = "algrano";
        if (is_null(Algrano::$conexionBD)) {
            Algrano::$conexionBD = new PDO("$driver:host=$host;dbname=$bd", $usuario, $contrasena);
            Algrano::$conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexionBD;
    }
}
