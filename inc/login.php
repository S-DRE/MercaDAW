<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/login.js"></script>
<div class="container">
    <form class = "text-center border border-light p-5" id = "formularioLogin" action="../public/crud.php?op=2" method="post">
        <p class = "h4 mb-4">Login de usuarios</p>
        <div class = "form-row mb-4">
            <div class="col">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" maxlength="30" required>
            </div>
            <div class="col">
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" maxlength="50" required>
            </div>
        </div>
        <label id = "forgotPassword" class = "text-primary" name = "forgotPassword"><a id ="forgotPasswordLink" href = "/index.php?load=recuperarPass">Forgot your password?</a></label>
        <button class="btn btn-info my-4 btn-block" type="submit">Log In</button>
        <?php
            if (isset($_SESSION['mensajeflash']))
            {
                echo "<div class=\"alert ".$_SESSION['tipoFlash']."\" role=\"alert\">{$_SESSION['mensajeflash']}</div>";
                unset($_SESSION['mensajeflash']);
            }
        ?>
    </form>
</div>