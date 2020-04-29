<?php
require '../inc/config.php';

require '../inc/cabecera.php';
require '../inc/menu.php';

if (isset($_GET['load'])) {
    switch ($_GET) {
        case $_GET['load'] == "registro": 
            require_once $config["inc"]."central_registro.php";
            break;
        case $_GET['load'] == "login": 
            require_once $config["inc"]."login.php";
            break;
        case $_GET['load'] == "logout":
            require_once $config["inc"]."logout.php";
            break;
        case $_GET['load'] == "buscarAds": 
            require_once $config["inc"]."central_buscarAds.php";
            break;
        case $_GET['load'] == "filtrarAds":
            require_once $config["inc"]."central_filtrarAds.php";
            break;
        case $_GET['load'] == "publicarAds": 
            require_once $config["inc"]."publicarAds.php";
            break;
        case $_GET['load'] == "editarAds": 
            require_once $config["inc"]."central_editarAds.php";
            break;
        case $_GET['load'] == "register":
            require_once $config["inc"]."register.php";
            break;
        case $_GET['load'] == "recuperarPass":
            require_once $config["inc"]."central_recuperarPass.php";
            break;
        case $_GET['load'] == "codigoPass":
            require_once $config["inc"]."central_codigoPass.php";
            break;
        default:
            require_once $config["inc"]."central_default.php";
            break;
    }
} else {
    // require  $config['inc'].'central_default.php';
}


if (isset($_GET['cargar']) && $_GET['cargar']!='' && file_exists($config['inc'].'central_'.strtolower($_GET['cargar']).'.php'))
    require  $config['inc'].'central_'.strtolower($_GET['cargar']).'.php';


// require_once $config['inc']."login.php";
require '../inc/pie.php';
