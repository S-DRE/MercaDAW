<?php
/**
* Función que encripta una password utilizando SHA-512 y 10000 vueltas por defecto
*
* @param string $password
* @param int $vueltas Número de vueltas, opcional. Por defecto 10000.
* @return string
*/
function encriptar($password, $vueltas = 10000) {
// Empleamos SHA-512 con 10000 vueltas por defecto.

    $salt = substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);

    return crypt((string) $password, '$6$' . "rounds=$vueltas\$$salt\$");

// Forma de comprobación de contraseña en login:
// Es recomendable comparar las cadenas de hash con hash_equals que es una comparación segura contra ataques de timing.

// Ejemplo de uso (hash_equals para evitar ataques de Timing)

// if (hash_equals(crypt($passRecibidaFormulario, $passwordAlmacenadaBD),$passwordAlmacenadaBD))

// Es necesario pasarle a la función crypt la $passwordAlmacenadaEncriptada para que pueda extraer la semilla, el tipo de encriptación y el número de vueltas.
}


/**
 * @param array Se le pasa un array y lo devuelve filtrado.

 */
function limpiarFiltrar($arrayFormulario)
{
    foreach ($arrayFormulario as $campo => $valor)
    {
        $arrayFormulario[$campo]=htmlspecialchars(trim($arrayFormulario[$campo]));
    }

    return $arrayFormulario;
}


/**
 * Función que comprueba los campos obligatorios de un formulario y los filtra.
 * @param array [Array con los campos que se consideran obligatorios. Ejemplo: array('nombre','apellidos','dni') ]
 * @param metodoRecepcion   post|get
 */

function camposObligatoriosOK($arrayCamposObligatorios,$metodoRecepcion)
{
    if (strtoupper($metodoRecepcion)=='POST')
        $arrayRecibidos=&$_POST;
    else
        $arrayRecibidos=&$_GET;

    for($i=0; $i<count($arrayCamposObligatorios); $i++)
    {
        $campo=$arrayCamposObligatorios[$i];

        if (!isset($arrayRecibidos[$campo]))
            return false;

        if (isset($arrayRecibidos[$campo]) && $arrayRecibidos[$campo]=='')
            return false;
    }

    return true;
}

/**
 * Almacena mensaje flash en variable de sesión.
 * @param  [string] $textoMensaje [description]
 * @param  [string] $tipoMensaje  [los de bootstrap, 'warning', 'danger', 'success',...]
 */
function mensajeFlash($textoMensaje,$tipoMensaje)
{
    $_SESSION['mensajeflash']=$textoMensaje;
    $_SESSION['tipoflash']=$tipoMensaje;
}



/**
 * [valorErroneo description]
 * @param  string $campo nombre del campo a comprobar en SESSION['errores']
 * @return [string]       Devuelve el valor del campo almacenado en la sesión.
 */
function valorErroneo($campo)
{
    if (isset($_SESSION['errores'][$campo]) && $_SESSION['errores'][$campo]!='')
        return $_SESSION['errores'][$campo];
    else
        return '';
}

function subir_fichero($directorio_destino, $nombre_fichero) {
    $tmp_name = $_FILES[$nombre_fichero]['tmp_name'];
    
    // Si hemos enviado un directorio que existe realmente y hemos subido el archivo...: 
    if (is_dir($directorio_destino) && is_uploaded_file($tmp_name)) {
        $img_file = $_FILES[$nombre_fichero]['name'];
        $img_type = $_FILES[$nombre_fichero]['type'];

        $nuevoNombre = $_SESSION['id']."_".$img_file;
        $directorioCompleto = $directorio_destino.$nuevoNombre;
        echo 1;
        $_SESSION['mensajeFlash'] = "El directorio existe y se ha subido el archivo";

        // Si se trata de una imagen: 
        if (strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type, "jpg") || strpos($img_type, "png")) {

            $_SESSION['mensajeFlash'] = "El archivo es fotografía, el tmp_name es: ".$_FILES[$nombre_fichero]['tmp_name']." y el directorio completo es ".$directorioCompleto;
            // ¿Tenemos permisos para subir la imagen?
            echo 2;

            // ACTUALMENTE DEVUELVE ERROR EN ESTA LINEA POR ALGUNA RAZÓN
            if (move_uploaded_file($tmp_name, $directorioCompleto)) {
                $_SESSION['mensajeFlash'] = "Hay permisos para subir la imagen.";
                return $nuevoNombre;
            }
        }
    } else {
        if (is_uploaded_file($tmp_name) == true)
            $_SESSION['mensajeFlash'] = "El directorio ".$directorio_destino." no existe.";
        else if (is_uploaded_file($tmp_name) == false)
            $_SESSION['mensajeFlash'] = "El archivo no se ha subido.";
        else 
            $_SESSION['mensajeFlash'] = "is_uploaded_file no ha devuelto nada";

    }

    // Si llegamos hasta aquí es que algo ha fallado: 
    // "Ha habido un error durante la subida"
    return false;
}
?>