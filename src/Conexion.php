<?php
namespace Departamentos;

use PDO;
use PDOException;

class Conexion {
    protected static $conexion;

    public function __construct() {
        if (self::$conexion == null) {
            self::crearConexion();
        }
    }

    public static function crearConexion() {
        //1. Leemos archivo de configuracion
        $archivo = dirname(__DIR__, 1)."/.conf";
        //2. Parseamos los datos
        $opciones = parse_ini_file($archivo);
        $host = $opciones['host'];
        $dbname = $opciones['dbname'];
        $user = $opciones['user'];
        $pass = $opciones['pass'];
        //3. Una vez parseamos los datos, creamos el dns
        $dns = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        //4. Creamos la conexion
        try {
            self::$conexion = new PDO($dns, $user, $pass);
            //Esta linea es para desarrollo
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error al crear la conexion: ".$ex->getMessage());
        }
    }
}