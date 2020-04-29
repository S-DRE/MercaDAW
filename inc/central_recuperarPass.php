<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/central_recuperarPass.js"></script>
<div class="container">
    <form id = "formularioRecuperarPass" class = "text-center border border-light p-5" action="/crud.php?op=8" method="post">
        <p class = "h4 mb-4">Recuperar contraseña</p>
        <div class = "form-row mb-4">
            <div class="col">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email de la cuenta a recuperar" maxlength="30" required>
            </div>
        </div>
        <button class="btn btn-info my-4 btn-block" type="submit">Solicitar contraseña</button>
        <?php
            if (isset($_SESSION['mensajeflash']))
            {
                echo "<div class=\"alert ".$_SESSION['tipoFlash']."\" role=\"alert\">{$_SESSION['mensajeflash']}</div>";
                unset($_SESSION['mensajeflash']);
            }
        ?>
    </form>
</div>