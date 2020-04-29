<?php
require '../inc/config.php';
require_once "../inc/funciones.php";
$pdo = Basedatos3::getConexion();

if (isset($_GET['op']) && $_GET['op']!='')
{
    switch ($_GET['op'])
    {
        case 1: // Alta de usuarios
        $_POST=limpiarFiltrar($_POST);

        if (camposObligatoriosOK(['nombre','apellidos','nick','email','password'],'post'))
        {

            /* Insertamos en la base de datos*/
            try {
                // Primero, quiero comprobar que no exista nadie con ese email o ese nick: 

                $stmt=$pdo->prepare("SELECT * FROM usuarios WHERE nick = ?");

                $stmt->bindParam(1, $_POST["nick"]);
                
                $stmt->execute();

                if ($stmt->rowCount() >= 1) {
                    $_SESSION['mensajeflash']="El nick {$_POST['nick']} ya existe.";
                    $_SESSION['tipoFlash'] = "alert-danger";
                    die();
                } else {

                    $stmt=$pdo->prepare("SELECT * FROM usuarios WHERE email = ?");

                    $stmt->bindParam(1, $_POST["email"]);
                
                    $stmt->execute();

                    if ($stmt->rowCount() >= 1) {
                        $_SESSION['mensajeflash']="El email {$_POST['email']} ya existe.";
                        $_SESSION['tipoFlash'] = "alert-danger";
                        die();
                    } else {

                        $stmt=$pdo->prepare('insert into usuarios(nick,nombre,apellidos,email,password) values(?,?,?,?,?)');
                        /* Vinculamos los parámetros con los datos del formulario.*/
                        $encriptada=encriptar($_POST['password']);

                        $stmt->bindParam(1,$_POST['nick']);
                        $stmt->bindParam(2,$_POST['nombre']);
                        $stmt->bindParam(3,$_POST['apellidos']);
                        $stmt->bindParam(4,$_POST['email']);
                        $stmt->bindParam(5,$encriptada);
                        $stmt->execute();
                    
                        // Almacenamos en la variable de sesión mensajeflash el texto que se mostrará en el index.php

                        $_SESSION['mensajeflash']="Registrado correctamente el usuario {$_POST['nombre']} con el nick {$_POST['nick']}.";
                        $_SESSION['tipoFlash'] = "alert-success";
                    }
                }
            } catch (PDOException $e) {
                echo "Error en sentencia SQL ".$e->getMessage();
            }

        }
        else
            echo "no todo ok";

        break;

        // Ahora hacemos el login: 

        case 2:
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?;");

            $stmt->bindParam(1, $_POST['email']);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $fila = $stmt->fetch();
                $contraseña = $fila['password'];

                echo "CONTRASEÑA = ".$contraseña;
            
                echo "<br>CONTRASEÑA INTRODUCIDA = ".$_POST["password"];

                if (hash_equals($contraseña, crypt($_POST["password"], $contraseña)) == true) {
                    echo "<br><br/>LOG-IN CORRECTO";
                
                    $_SESSION['loggedUser'] = true;
                    $_SESSION['id'] = $fila['id'];
                    $_SESSION['nombre'] = $fila['nombre'];
                    $_SESSION['apellidos'] = $fila['apellidos'];
                    $_SESSION['nick'] = $fila['nick'];
                    $_SESSION['email'] = $fila['email'];

                    // var_dump($_SESSION); // Printea por pantalla.

                    $_SESSION['mensajeflash']="Usuario {$_POST['email']} con el nick {$_SESSION['nick']} logueado correctamente.";
                    $_SESSION['tipoFlash'] = "alert-success";

                    $json = json_encode($_SESSION);
                } else {
                    // echo "<br><br/>Los credenciales no son correctos.";
                    $_SESSION['mensajeflash']="La contraseña introducida para ".$_POST['email']." no es correcta.";
                    $_SESSION['tipoFlash'] = "alert-danger";

                    $json = json_encode($_SESSION);
                }
            } else {
                $_SESSION['mensajeflash']="El usuario introducido no existe";
                $_SESSION['tipoFlash'] = "alert-danger";

                $json = json_encode($_SESSION);
            }
        } catch (PDOException $excepcion) {
            // echo "Ha habido un error validando la contraseña: ".$excepcion->getMessage();
            $_SESSION['mensajeflash']="Ha habido un error validando la contraseña: ".$excepcion->getMessage();
            $_SESSION['tipoFlash'] = "alert-danger";

            $json = json_encode($_SESSION);
        }
        break;

        
        // El LOGOUT
        case 3: 
            session_destroy();
            session_start();
            $_SESSION['loggedUser'] = false;
            

            $json = json_encode("Hola");

            break;

        // BUSCAR ADS
        case 4:
            $stmt = $pdo->prepare("SELECT * FROM anuncios;");
            $stmt->execute();

            if ($stmt->rowCount() >= 1) {
                $fila = $stmt->fetch();
                for ($i = 0; $i < $stmt->rowCount(); $i++) {
                    $SESSION['idusuario'] = $fila['idusuario'];
                    $SESSION['titulo'] = $fila['titulo'];
                    $SESSION['descripcion'] = $fila['descripcion'];
                    $SESSION['foto'] = $fila['foto'];

                    header("location: buscarAds.php");
                }
            }
        break;

        // PUBLICAR ADS
        
        case 5:
            // Aquí se publicarán los anuncios, deberán subirse a la BD.
            $_POST = limpiarFiltrar($_POST);

            /*
            foreach ($_FILES as $file) {
                echo $file;
            }
            
            $ficheros = $_FILES['fotoFile'];
            echo $ficheros;
            */

            if (camposObligatoriosOK(['titulo', 'descripcion'], 'post')) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO anuncios (idusuario, titulo, descripcion, foto) VALUES (?,?,?,?)");

                    $stmt->bindParam(1, $_SESSION['id']); //Sacar id usuario.
                    $stmt->bindParam(2,$_POST['titulo']);
                    $stmt->bindParam(3,$_POST['descripcion']);

                    // Subida de la fotografía: 
                    $subida = subir_fichero("/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/images/", 'fotoFile');

                    /*
                    $estado = json_decode($subida. true);
                    if ($estado['status'] == 'ok')
                        $stmt->bindParam(4, $estado['data']);
                    */


                    if (!$subida) {
                        $_SESSION['mensajeFlash'] = "Ha habido un error subiendo la fotografía";
                        $_SESSION['tipoFlash'] = "alert-danger";

                        die();
                    }


                    $stmt->bindParam(4, $subida); // Como enviar la foto.

                    $stmt->execute();

                    $_SESSION['mensajeflash']="Insertado correctamente el anuncio {$_POST['titulo']}.";
                    $_SESSION['tipoFlash'] = "alert-success";
                    

                    echo("Insertado correctamente.");
                } catch (PDOException $e) {
                    $_SESSION['mensajeflash'] = "Error en sentencia SQL ".$e->getMessage();
                    $_SESSION['tipoFlash'] = "alert-danger";
                    echo "Error en sentencia SQL ".$e->getMessage();
                }
            } else {
                $_SESSION['mensajeflash'] = "Error en los campos obligatorios. Revisar por qué.";
                $_SESSION['tipoFlash'] = "alert-danger";
                echo("Error en los campos obligatorios. Revisar por qué.");
            }
        break;

        case 6:
            try{
                // UPDATEAMOS EL ANUNCIO:
                $subida = subir_fichero("/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/images/", 'fotoFile');

                if ((!$subida) || ($subida == "")) {
                    $subida = $_POST['fotoAntigua'];
                }
                if(isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] == true && $_SESSION['nick'] == "root") { 


                    $stmt = $pdo->prepare("UPDATE anuncios SET titulo = ?, descripcion = ?, foto = ? WHERE id = ?");

                    $stmt->bindParam(1, $_POST['titulo']);
                    $stmt->bindParam(2, $_POST['descripcion']);

                    // $stmt->bindParam(3, $_FILES['fotoFile']['name']);
                    $stmt->bindParam(3, $subida);
                    $stmt->bindParam(4, $_POST['idAnuncio']);
                } else {
                    $stmt = $pdo->prepare("UPDATE anuncios SET titulo = ?, descripcion = ?, foto = ? WHERE id = ? AND idusuario = ?");

                    $stmt->bindParam(1, $_POST['titulo']);
                    $stmt->bindParam(2, $_POST['descripcion']);

                    // $stmt->bindParam(3, $_FILES['fotoFile']['name']);
                    $stmt->bindParam(3, $subida);
                    $stmt->bindParam(4, $_POST['idAnuncio']);
                    $stmt->bindParam(5, $_SESSION['id']);
                }

                $stmt->execute();
                // header('location: index.php?load=buscarAds');

                $_SESSION['mensajeflash']="Editado correctamente el anuncio con ID ".$_POST['idAnuncio']." y el nuevo título ".$_POST['titulo'];
                // $_SESSION['mensajeFlash'] = "Subida: ".$subida;
                $_SESSION['tipoFlash'] = "alert-success";
            } catch (PDOException $e) {
                echo "Error en sentencia SQL ".$e->getMessage();
            }
        break;

        // BORRAR ANUNCIO
        case 7:
            try{
                // DELETEAMOS EL ANUNCIO
                $id = $_GET['id'];
                $stmt = $pdo->prepare("DELETE FROM anuncios WHERE id = ? AND idusuario = ?");

                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $_SESSION['id']);

                $stmt->execute();

                
                $_SESSION['mensajeflash']="El anuncio con ID ".$id." ha sido borrado";
                $_SESSION['tipoFlash'] = "alert-success";

                $json = json_encode($_SESSION);
            } catch (PDOException $e) {
                echo "Error en sentencia SQL ".$e->getMessage();

                
                $_SESSION['mensajeflash']="Ha ocurrido un error borrando el anuncio";
                $_SESSION['tipoFlash'] = "alert-danger";

                $json = json_encode($_SESSION);
            }

        break;

        // RECUPERAR CONTRASEÑA
        case 8:
        try{
            // Enviar el correo necesario para checkear la contraseña
            $stmt = $pdo->prepare("SELECT email, nick FROM usuarios WHERE email = ?;");

            $stmt->bindParam(1, $_POST['email']);
            $stmt->execute();

            $fila = $stmt->fetch();

            if ($fila['email'] && $fila['email'] != "") {
                // El usuario existe, creamos el código de recuperación.
                $date = date('d/m/Y-h:i:s-a', time());
                
                $codigoRecuperación = $date.$fila['nick'].rand(1000, 100000);

                // INSERTAMOS EL CODIGO DE RECUPERACIÓN EN LA BASE DE DATOS

                $stmt = $pdo->prepare("UPDATE usuarios SET codigoRecuperacion = ? WHERE email = ?");

                $stmt->bindParam(1, $codigoRecuperación);
                $stmt->bindParam(2, $_POST['email']); // Probar con $_POST

                $stmt->execute();

                $cuerpoCorreo = "Hemos recibido una solicitud de recuperación de contraseña para su cuenta. ".
                                "Procedemos a facilitarle un código de recuperación con el que podrá ".
                                "acceder de nuevo a su cuenta. \n\n".
                                "CÓDIGO DE RECUPERACIÓN: ".$codigoRecuperación."\n\n".
                                "Para cambiar su contraseña, diríjase a este link e introduzca el código: ". 
                                "a19andresaa.mywire.org/DWCC/jQueryMercaDAW/public/index.php?load=codigoPass&email=".$_POST['email']."\n\n".
                                "Si no ha solicitado una recuperación de su contraseña, puede ignorar este correo".
                                ", aunque le recomendamos que cambie su contraseña por seguridad. \n\n\n".
                                "Un saludo, el equipo de MercaDAW";

                $mailOutput = mail($fila['email'], 'RECUPERACIÓN DE CONTRASEÑA - MERCADAW', $cuerpoCorreo);

                // header('location: index.php?load=recuperarPass');
                $_SESSION['mensajeflash']="Se le ha enviado un correo con el código de recuperación. La funcion mail devuelve esto: ".$mailOutput."."; // Cuerpo del correo: ".$cuerpoCorreo."<--";
                $_SESSION['tipoFlash'] = "alert-success";
            } else {
                // header('location: index.php?load=recuperarPass');
                $_SESSION['mensajeflash']="El correo ".$_POST['email']." no está registrado.";
                $_SESSION['tipoFlash'] = "alert-danger";
            }
        } catch (PDOException $e) {
            $_SESSION['mensajeflash']="Ha ocurrido un error enviando el correo de recuperación.";
            $_SESSION['tipoFlash'] = "alert-danger";
        }
        break;

        // REESTABLECER CONTRASEÑA (CODIGO PASS)
        case 9:
            // Comprobar que el código sea el correcto y, si lo es, autorizar 
            // el cambio de la contraseña: 
            try{
                $stmt = $pdo->prepare("SELECT codigoRecuperacion, password FROM usuarios WHERE email = ?;");
                $stmt->bindParam(1, $_POST["email"]);

                $stmt->execute();

                if ($stmt->rowCount() >= 1) {
                    $fila = $stmt->fetch();

                    $codigoIntroducido = $_POST['codigoRecuperacion'];
                    $codigoBD = $fila['codigoRecuperacion'];

                    if($codigoIntroducido == $codigoBD) {
                        // Hacer un update de la contraseña con la nueva y encriptarla.
                        $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE email = ?");

                        $passwordEncriptada = crypt($_POST['password'], $fila['password']);

                        if ($_POST['password'] == $_POST['confirmarPassword']) {
                            $stmt->bindParam(1, $passwordEncriptada);
                            $stmt->bindParam(2, $_POST['email']);

                            $stmt->execute();
                            
                            $stmt = $pdo->prepare("UPDATE usuarios SET codigoRecuperacion = '' WHERE email = ?");
                            $stmt->bindParam(1, $_POST['email']);

                            $stmt->execute();

                            header("location: index.php?load=login");
                            $_SESSION['mensajeflash']="Su contraseña ha sido actualizada con éxito.";
                            $_SESSION['tipoFlash'] = "alert-success";
                        } else {
                            header("location: index.php?load=codigoPass&email=".$_POST['email']);
                            $_SESSION['mensajeflash']="Las contraseñas no coinciden.";
                            $_SESSION['tipoFlash'] = "alert-danger";
                        }
                    } else {
                        header("location: index.php?load=recuperarPass");
                        $_SESSION['mensajeflash']="El código introducido no es correcto.";
                        $_SESSION['tipoFlash'] = "alert-danger"; 
                    }
                } else {
                    header("location: index.php?load=recuperarPass");
                    $_SESSION['mensajeflash']="No se ha encontrado un código asociado a tu usuario con email: ".$_POST["email"];
                    $_SESSION['tipoFlash'] = "alert-danger";
                }
            } catch (PDOException $e) {
                $_SESSION['mensajeflash']="Ha ocurrido un error en el manejo de la BD.";
                $_SESSION['tipoFlash'] = "alert-danger";
            }
        break;
    }
}