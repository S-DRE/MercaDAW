// central_recuperarPass.js
$(document).ready(function () {
    console.log("central_recuperarPass.js");
    $(document.body).on("submit", "form#formularioRecuperarPass", function(event) {
        event.preventDefault();
        emailVal = $("#email").val();

        console.log("Email: " + emailVal);

        console.log("ANTES DEL POST DE RECUPERAR PASS.");
        $.post("/DWCC/jQueryMercaDAW/public/crud.php?op=8", {email: emailVal}, function(sesion) {
            $(".container").remove();
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/login.php");
        });
    });
});