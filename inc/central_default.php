<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/menu.js"></script>

<main role="main" class="container">

    <div class="starter-template">
            <h1>MERCADAW</h1>
            <p class="lead">Compra y vende lo que quieras.<br/>Somos unos 30 usuarios.<br>Vende, cambia, empeña, trueca y compra productos usados.</p>
            <?php
            if (session_status() == PHP_SESSION_NONE) {

                session_start();
        
            }
            // echo $_SESSION;
            print_r($_SESSION);
            if (isset($_SESSION['mensajeflash']))
            {
                echo "<div class=\"alert ".$_SESSION['tipoFlash']."\" role=\"alert\">{$_SESSION['mensajeflash']}</div>";
                unset($_SESSION['mensajeflash']);
            }

            ?>
    </div>
</main>
