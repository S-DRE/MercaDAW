<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/central_registro.js"></script>
<div class="container">

    <form class="text-center border border-light p-5" id = "formularioRegistro" action="/crud.php?op=1" method="post">
        <p class="h4 mb-4">Registro de Usuarios</p>
        <!-- https://mdbootstrap.com/docs/jquery/forms/basic/ -->
        <div class="form-row mb-4">
            <div class="col">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" maxlength="30" required>
            </div>
            <div class="col">
                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" maxlength="50" required>
            </div>
        </div>
        <input type="text" id="nick" name="nick" class="form-control mb-4" placeholder="Usuario, nick.." maxlength = "30">
        <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" maxlength="100" required>
        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="120" required>
        <small id="" class="form-text text-muted mb-4">Mayúsculas, minúsculas, números y mínimo 6 caracteres.</small>
        <div class="input-group">
            <button class="btn btn-info form-control" type="submit">Registrarse</button>
            <button id = "btnLogin" class = "btn btn-secondary form-control" type = "button">Log-in</button>
        </div>
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
