<?php

    require_once ('/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/inc/config.php');

    class BaseDatos3 {
        // Propiedad estatica donde se almacenara la referencia de la conexion a la base de datos
        private static $conexion = FALSE;

        private function __construct() {

            try {
                
                $cadenaConexion = "mysql:host=".DB3_SERVIDOR."; port=".DB3_PUERTO."; dbname=".DB3_BASEDATOS."; charset=utf8";

                self::$conexion = new PDO($cadenaConexion, DB3_USUARIO, DB3_PASSWORD);

                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {

                die("Error conectando al servidor de base de datos").$e->getMessage();

            }

        }

        public static function getConexion() {

            if (!self::$conexion) {

                new self;

                // Otra opcion
                // self::__constuct();

            } 

            return self::$conexion;

        }

    }

?>