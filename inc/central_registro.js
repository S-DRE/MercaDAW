// Central registro.js
$(document).ready(function () {
    $(document.body).on("submit", "form#formularioRegistro", function(event) {
        event.preventDefault();

        console.log("PREVINIENDO QUE REGISTRO PASE POR EL CRUD...");

        nombreVal = $("input#nombre").val();
        apellidosVal = $("input#apellidos").val();
        nickVal = $("input#nick").val();
        emailVal = $("input#email").val();
        passwordVal = $("input#password").val();

        // Hacemos una petición post
        $.post("../public/crud.php?op=1", {nombre: nombreVal, apellidos: apellidosVal, nick: nickVal, email: emailVal, password: passwordVal}, function(sesion) {
            $(".container").remove();
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/public/index.php?load=#");
        });
    });

    $(document.body).on("click", "#btnLogin", function (event) {
        event.preventDefault();

        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/login.php");
    });
});