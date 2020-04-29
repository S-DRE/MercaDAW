<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/central_buscarAds.js"></script>
<div class="container">
<form id = "formularioFiltrar" class = "my-2 my-lg-0 text-center" action = "/index.php?load=buscarAds&filtro=activo" method = "post">

        <h3>Búsqueda de anuncios</h3>

        <!-- <input class="form-control mr-sm-2" type="text" placeholder="Búsqueda" aria-label="Search"> -->
        <table id = "tablaBuscarAds" style = "border: 2px solid black; padding: 15px; text-align: center;">
            <input type="text" id = "textoInput" name = "textoInput" placeholder="Search...">
            <button type="submit" id = "submit" name = "submit">Filtrar</button>
            <br><br/>
            
            <?php
                require '/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/class/basedatos.php';

                $pdo = BaseDatos3::getConexion();

                if (isset($_GET['filtro']) && $_GET['filtro'] != "") {

                    $filtro = '%'.$_POST['textoInput'].'%';
                    
                    if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"]) {
                        if ($_SESSION['nick'] == "root") {
                            $stmt = $pdo->prepare("SELECT anuncios.*, usuarios.nick FROM anuncios JOIN usuarios ON anuncios.idusuario = usuarios.id WHERE titulo LIKE ?");
                            $stmt->bindParam(1, $filtro);
                        } else {
                            $stmt = $pdo->prepare("SELECT anuncios.*, usuarios.nick FROM anuncios JOIN usuarios ON anuncios.idusuario = usuarios.id WHERE idusuario = ? AND titulo LIKE ?");
                            $stmt->bindParam(1, $_SESSION['id']);
                            $stmt->bindParam(2, $filtro);
                            // echo "[DEBUG] HAY ALGUIEN LOGUEADO";
                        }
                    } else {
                        $stmt = $pdo->prepare("SELECT anuncios.*, usuarios.nick FROM anuncios JOIN usuarios ON anuncios.idusuario = usuarios.id  WHERE titulo LIKE ?");
                        $stmt->bindParam(1, $filtro);
                        // echo "[DEBUG] NO HAY NADIE LOGUEADO ASÍ QUE PASA POR AQUÍ";
                    }

                    $stmt->execute();

                    $contador = 0;

                    if ($stmt->rowCount() >= 1) {
                        echo '<thead style = "border: 2px solid black; background-color: #00208a; color: #e3e3e3;">
                                <th>TÍTULO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>FOTO</th>
                                <th>FECHA DE PUBLICACIÓN</th>';

                        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] && $_SESSION['nick'] == "root") {
                            echo '<th>USUARIO</th>
                                  <th>PANEL DE CONTROL</th>';
                        } else if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] && $_SESSION['nick'] != "root") {
                            echo '<th>PANEL DE CONTROL</th>';
                        } else {
                            echo '<th>USUARIO</th>';
                        }

                        echo '</thead>';
                        
                        while($fila = $stmt->fetch()) { // recorre los registros de la base de datos
                            // while ($contador <= $stmt->rowCount()) {
                            $_SESSION['idusuario'] = $fila['idusuario'];
                            $_SESSION['titulo'] = $fila['titulo'];
                            $_SESSION['descripcion'] = $fila['descripcion'];
                            $_SESSION['foto'] = $fila['foto'];
                            
                            // Convirtiendo la fecha
                            $fecha = new DateTime($fila['fecha']);
                            $fechaConvertida = $fecha->format('d/m/Y');
                            
                            if (isset($_SESSION['titulo'])){
                                echo "<tr>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fila['titulo'] ."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'>".$fila['descripcion']."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'> <img src = https://a19andresaa.mywire.org/DWCC/jQueryMercaDAW/images/".$fila['foto']." width = 250px height = 180px></td>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fechaConvertida."</td>";

                                    if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] && $_SESSION['nick'] == "root") {
                                        echo "<td style = 'border: 1px solid black; padding: 10px; width: 150px;'>".$fila['nick']."</td>
                                              <td style = 'border: 1px solid black; padding: 10px; width: 200px;'> <a class = 'editarLink' href = http://a19andresaa2.mywire.org/index.php?load=editarAds&id=".$fila['id'].">Editar</a> | <a class = 'borrarLink' href = http://a19andresaa2.mywire.org/crud.php?op=7&id=".$fila['id'].">Borrar</a></td>";
                                    } else if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] && $_SESSION['nick'] != "root") {
                                        echo "<td style = 'border: 1px solid black; padding: 10px; width: 200px;'> <a class = 'editarLink' href = http://a19andresaa2.mywire.org/index.php?load=editarAds&id=".$fila['id'].">Editar</a> | <a class = 'borrarLink' href = http://a19andresaa2.mywire.org/crud.php?op=7&id=".$fila['id'].">Borrar</a></td>";
                                    } else {
                                        echo "<td style = 'border: 1px solid black; padding: 10px; width: 150px;'>".$fila['nick']."</td>";
                                    }
                                echo "</tr>";

                            }
                        }
                    } else {
                        echo "No hay anuncios que correspondan a los criterios seleccionados\n";
                        // echo "<br><br/>[DEBUG]CRITERIOS: TEXTO ->".$_POST['textoInput'];
                        // echo "<br><br/>USER -> ".$_SESSION['id'];
                    }
                } else if(isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] == true && $_SESSION['nick'] != "root") {
                    
                    $stmt = $pdo->prepare("SELECT * FROM anuncios WHERE idusuario = ? ORDER BY fecha;");
                    $stmt->bindParam(1, $_SESSION['id']);

                    echo "<p style = 'font-size: 16px'>Mostrando resultados para el usuario: ".$_SESSION['nick']."</p>";

                    $stmt->execute();
                    $contador = 0;

                    if ($stmt->rowCount() >= 1) {
                        echo '<thead style = "border: 2px solid black; background-color: #00208a; color: #e3e3e3;">
                                <th>TÍTULO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>FOTO</th>
                                <th>FECHA DE PUBLICACIÓN</th>
                                <th>PANEL DE CONTROL</th>
                              </thead>';

                        // http://a19andresaa2.mywire.org/Project5/public/index.php?load=buscarAds

                        while($fila = $stmt->fetch()) { // recorre los registros de la base de datos
                            // while ($contador <= $stmt->rowCount()) {
                            $_SESSION['idusuario'] = $fila['idusuario'];
                            $_SESSION['titulo'] = $fila['titulo'];
                            $_SESSION['descripcion'] = $fila['descripcion'];
                            $_SESSION['foto'] = $fila['foto'];
                        
                            // Convirtiendo la fecha
                            $fecha = new DateTime($fila['fecha']);
                            $fechaConvertida = $fecha->format('d/m/Y');
                        
                            if (isset($_SESSION['titulo'])){
                                echo "<tr>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fila['titulo'] ."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'>".$fila['descripcion']."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'> <img src = https://a19andresaa.mywire.org/DWCC/jQueryMercaDAW/images/".$fila['foto']." width = 250px height = 180px></td>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fechaConvertida."</td>
                                    <td style = 'border: 1px solid black; padding: 10px; width: 200px;'> <a class = 'editarLink' href = http://a19andresaa2.mywire.org/index.php?load=editarAds&id=".$fila['id'].">Editar</a> | <a class = 'borrarLink' href = http://a19andresaa2.mywire.org/crud.php?op=7&id=".$fila['id'].">Borrar</a></td>
                                </tr>";
                            }
                         }
                    
                    } else {
                        echo "No hay anuncios publicados para este usuario\n";
                    }
                } else {
                    $stmt = $pdo->prepare("SELECT anuncios.*, usuarios.nick FROM anuncios JOIN usuarios ON anuncios.idusuario = usuarios.id ORDER BY fecha;");

                    $stmt->execute();

                    if ($stmt->rowCount() >= 1) {
                        
                        echo '<thead style = "border: 2px solid black; background-color: #00208a; color: #e3e3e3;">
                                <th>TÍTULO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>FOTO</th>
                                <th>FECHA DE PUBLICACIÓN</th>
                                <th>USUARIO</th>';

                        if (isset($_SESSION['nick']))
                            echo '<th>PANEL DE CONTROL</th>';
                        
                        echo '</thead>';

                              

                        // http://a19andresaa2.mywire.org/Project5/public/index.php?load=buscarAds

                        while($fila = $stmt->fetch()) { // recorre los registros de la base de datos
                            // while ($contador <= $stmt->rowCount()) {
                            $_SESSION['idusuario'] = $fila['idusuario'];
                            $_SESSION['titulo'] = $fila['titulo'];
                            $_SESSION['descripcion'] = $fila['descripcion'];
                            $_SESSION['foto'] = $fila['foto'];
                        
                            // Convirtiendo la fecha
                            $fecha = new DateTime($fila['fecha']);
                            $fechaConvertida = $fecha->format('d/m/Y');
                        
                            if (isset($_SESSION['titulo'])){
                                echo "<tr>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fila['titulo'] ."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'>".$fila['descripcion']."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;'> <img src = https://a19andresaa.mywire.org/DWCC/jQueryMercaDAW/images/".$fila['foto']." width = 250px height = 180px></td>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fechaConvertida."</td>
                                    <td style = 'border: 1px solid black; padding: 10px;' width = 150px>".$fila['nick']."</td>";

                                if (isset($_SESSION['nick'])) {
                                    echo "<td style = 'border: 1px solid black; padding: 10px; width: 200px;'> <a class = 'editarLink' href = http://a19andresaa2.mywire.org/index.php?load=editarAds&id=".$fila['id'].">Editar</a> | <a class = 'borrarLink' href = http://a19andresaa2.mywire.org/crud.php?op=7&id=".$fila['id'].">Borrar</a></td>";
                                }
                                    echo "</tr>";
                                
                            }
                         }
                    
                    } else {
                        echo "No hay anuncios publicados en este momento.\n";
                    }
                }
            ?>
        </table>
        <?php
            if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"]) {
                echo '<button id = "publicarAdsButton" class="btn btn-secondary my-4 btn-block">Subir anuncios</button>';
            }
        ?>
        <hr>
        <?php
            if (isset($_SESSION['mensajeflash']))
            {
                echo "<div class=\"alert ".$_SESSION['tipoFlash']."\" role=\"alert\">{$_SESSION['mensajeflash']}</div>";
                unset($_SESSION['mensajeflash']);
            }
        ?>
    </form>
</div>