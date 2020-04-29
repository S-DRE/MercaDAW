<?php

    if (session_status() == PHP_SESSION_NONE) {

        session_start();

    }
    
    // echo "Pasando por el NOT defined";
    define ('DS3', DIRECTORY_SEPARATOR);

    $rutaBase = dirname(dirname(__FILE__)).DS3;

    $config['inc'] = $rutaBase.'inc'.DS3;
    $config['class'] = $rutaBase.'class'.DS3;
    $config['img'] = $rutaBase.'images'.DS3;

    define('DB3_SERVIDOR', 'localhost');
    define('DB3_PUERTO', '3306');
    define('DB3_BASEDATOS', 'anuncios');
    define('DB3_USUARIO', 'anuncios');
    define('DB3_PASSWORD', 'abc123.');
    

    require_once '/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/class/basedatos.php';
    require_once '/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/inc/funciones.php';
?>