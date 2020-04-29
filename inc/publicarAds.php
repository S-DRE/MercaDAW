<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/publicarAds.js"></script>
<div class="container" style = "width = 100%; align-content: center;">
<form id = "formularioPublicacion" class = "my-2 my-lg-0 text-center" style = "align-content: center;" enctype = "multipart/form-data" action="/crud.php?op=5 " method = "post">
    
        <h3>Publicar anuncios</h3>

        <div class="form-row mb-4">
            <div class="col">
                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título" maxlength="100" required>
            </div>
        </div>

        <div class="form-row mb-4">
            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" maxlength="2000" required></textarea>
        </div>
        <div class = "input-group">
            <div class = "custom-file">
                <input type="file" id="fotoFile" name="fotoFile" class="custom-file-input" placeholder="Seleccionar archivo" required>
                <label class = "custom-file-label" for = "fotoFile">Escoja una fotografía para su anuncio</label>
            </div>
        </div>

        <script>
            $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>

        <button id = "formularioPublicacion" class="btn btn-info my-4 btn-block" type="submit">Publicar Anuncio</button>
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