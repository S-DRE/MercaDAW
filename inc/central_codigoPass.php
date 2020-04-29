<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/central_codigoPass.js"></script>
<div class="container">
    <form id = "formularioCodigo" class = "text-center border border-light p-5" action="/crud.php?op=9" method="post">
        <p class = "h4 mb-4">Reestablecer contraseña</p>
        <div class = "form-row mb-4">
            <div class = "col">
                <input type = "text" id = "codigoRecuperacion" name = "codigoRecuperacion" class = "form-control" placeholder = "Código de recuperación" maxlength = "100" required>
            </div>
        </div>
        <div class = "form-row mb-4">
            <div class="col">
                <input type = "password" id = "password" name="password" class="form-control" placeholder="Nueva contraseña" maxlength="120" required>
            </div>
        </div>
        <div class = "form-row mb-4">
            <div class = "col">
                <input type = "password" id = "confirmarPassword" name = "confirmarPassword" class = "form-control" placeholder = "Confirme la nueva contraseña" maxlength="120" required>
            </div>
        </div>
        
        <button class="btn btn-info my-4 btn-block" type="submit">Cambiar contraseña</button>
        <?php
            echo '<input type = "hidden" id = "email" name = "email" value = '.$_GET["email"].'>';
            if (isset($_SESSION['mensajeflash']))
            {
                echo "<div class=\"alert ".$_SESSION['tipoFlash']."\" role=\"alert\">{$_SESSION['mensajeflash']}</div>";
                unset($_SESSION['mensajeflash']);
            }
        ?>
    </form>
</div>