// Login.js
$(document).ready(function() {
    $(document.body).on("submit", "form#formularioLogin", function(event) {
        // Pedir que haga una petición al crud.
        event.preventDefault();

        console.log("PASANDO POR LOGIN.JS, PREVINIENDO LA REDIRECCIÓN AL CRUD");
        
        emailVal = $("input#email").val();
        passwordVal = $("input#password").val();

        console.log("Antes del post");

        // Hacemos una petición post
        $.post("../public/crud.php?op=2", {email: emailVal, password: passwordVal}, function(sesionDevuelta) {
            console.log("Volviendo del crud del login: ");
            console.log(sesionDevuelta);

            sessionStorage.setItem("sesion", sesionDevuelta);

            $(".container").remove();
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/public/index.php?load=#");
        });
    });
    $("#forgotPasswordLink").on("click", function (event) { 
        event.preventDefault();

        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_recuperarPass.php");
    });
});