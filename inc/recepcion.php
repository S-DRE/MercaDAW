<?php
require_once 'funciones.php';

if (!empty($_POST)) {
    if (subir_fichero('imagenes', 'fotoFile'))
        echo "Archivo recibido correctamente.";
}
?>