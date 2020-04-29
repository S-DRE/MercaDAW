<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/central_editarAds.js"></script>
<div class="container" style = "width = 100%; align-content: center;">
<form id = "formularioEditar" class = "my-2 my-lg-0 text-center" style = "align-content: center;" enctype = "multipart/form-data" action="/crud.php?op=6" method = "post">
    
        <h3>Editar anuncios</h3>

        
            <?php
            require '/var/www/a19andresaa.mywire.org/public/DWCC/jQueryMercaDAW/class/basedatos.php';

            if(isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] == true && $_SESSION['nick'] == "root") {
                $pdo = BaseDatos3::getConexion();

                $id = $_GET['id'];
                $idUsuario = $_SESSION['idusuario'];

                $stmt = $pdo->prepare("SELECT titulo, descripcion, foto, idusuario FROM anuncios WHERE anuncios.id = ?;");
                $stmt->bindParam(1, $id);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    $fila = $stmt->fetch();

                    $tituloExtraido = $fila['titulo'];
                    $descripcionExtraida = $fila['descripcion'];
                    $fotoExtraida = $fila['foto'];
                    $idusuario = $fila['idusuario'];
                    

                    echo '<div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="titulo" name="titulo" class="form-control" value="'.$tituloExtraido.'" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder = "descripcion" maxlength="2000" required>'.$descripcionExtraida.'</textarea>
                        </div> 
                        <input type = "hidden" id = "idAnuncio" name = "idAnuncio" class = "form-control" value = "'.$id.'">
                        <div class = "custom-file">
                            <input type="file" id="fotoFile" name="fotoFile" class="custom-file-input" placeholder="Seleccionar archivo">
                            <label class = "custom-file-label">Escoja una fotografía para su anuncio</label>
                        </div>
                        <input type = "hidden" id = "fotoAntigua" name = "fotoAntigua" class = "form-control" value = "'.$fotoExtraida.'">
                        <button class="btn btn-info my-4 btn-block" type="submit">Editar Anuncio</button>
                        <hr>';
                } else {
                   echo "ERROR SQL";
                }
            } else {
                $pdo = BaseDatos3::getConexion();

                $id = $_GET['id'];
                $idUsuario = $_SESSION['idusuario'];

                $stmt = $pdo->prepare("SELECT titulo, descripcion, foto FROM anuncios WHERE id = ? AND idusuario = ?;");
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $idUsuario);

                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    $fila = $stmt->fetch();

                    $tituloExtraido = $fila['titulo'];
                    $descripcionExtraida = $fila['descripcion'];
                    $fotoExtraida = $fila['foto'];

                    echo '<div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="titulo" name="titulo" class="form-control" value="'.$tituloExtraido.'" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder = "descripcion" maxlength="2000" required>'.$descripcionExtraida.'</textarea>
                        </div> 
                        <input type = "hidden" id = "idAnuncio" name = "idAnuncio" class = "form-control" value = "'.$id.'">
                        <div class = "custom-file">
                            <input type="file" id="fotoFile" name="fotoFile" class="custom-file-input" placeholder="Seleccionar archivo">
                            <label class = "custom-file-label">Escoja una fotografía para su anuncio</label>
                        </div>
                        <input type = "hidden" id = "fotoAntigua" name = "fotoAntigua" class = "form-control" value = "'.$fotoExtraida.'">
                        <button class="btn btn-info my-4 btn-block" type="submit">Editar Anuncio</button>
                        <hr>';
                } else {
                   echo "ERROR SQL";
                }
            }
            ?>
</form>
</div>