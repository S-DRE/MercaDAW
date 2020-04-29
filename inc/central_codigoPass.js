//central_codigoPass.js
$(document).ready(function () {
    $(".container").remove();
    $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_codigoPass.php");

    $(document.body).on("submit", "form#formularioRecuperarPass", function(event) {
        event.preventDefault();
        
    });
});