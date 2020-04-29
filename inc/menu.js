// INDEX JS -> Para sustituír los headers por cargas de la página mediante JS
console.log("________________________");
console.log("Pasando por el menu.js");



if (jQuery) {
    console.log("jQuery está cargado");
} else {
    console.log("jQuery NO está cargado");
}

$(document).ready(function () {
    console.log("Cargando Script del menú...");
    $("#inicioLink").on("click", function (event) {
        event.preventDefault();
        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_default.php");
    });

    $("#buscarAnunciosLink").on("click", function (event) {
        event.preventDefault();
        console.log("Buscar Anuncios...");

        // TODO: Hacer que reconozca la base de datos.
        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
    });

    $("#publicarAnunciosClick").on("click", function (event) {
        event.preventDefault();
        console.log("Publicar anuncios...");

        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/publicarAds.php");
    });

    $(document.body).on("click", "#registroLink", function (event) {
        console.log("Click en registro...");
        event.preventDefault();
        // TODO: Intentar que se vea la cabecera.

        /*
        $.get("/DWCC/jQueryMercaDAW/inc/cabecera.php").html(datos).appendTo(document.body);
        $.get("/DWCC/jQueryMercaDAW/inc/menu.php").html(datos).appendTo(document.body);
        $.get("/DWCC/jQueryMercaDAW/inc/central_registro.php").html(datos).appendTo(document.body);
        */

        /*
        $(document.body).load("/DWCC/jQueryMercaDAW/inc/cabecera.php");
        $(document.body).append("/DWCC/jQueryMercaDAW/inc/menu.php");
        */

        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_registro.php");
    });

    $("#publicarAnunciosLink").on("click", function (event) {
        event.preventDefault();
        $(".container").remove();
        $(".cuerpo").load("./publicarAds.php");
    });

    $(document.body).on("click", "#botonLoginLink", function (event) {
        console.log("Click en login...");
        event.preventDefault();
        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/login.php");
    });

    $(document.body).on("click", "#botonLogoutLink", function (event) {
        // Pedir que haga una petición al crud.
        event.preventDefault();

        console.log("Click en logout...");
        console.log("Previniendo el logout de pasar por el CRUD...");

        $.post("../public/crud.php?op=3", function (sesionDevuelta) {
            console.log("SESION");
            console.log(sesionDevuelta);

            Sesion = sesionDevuelta;
            
            $(".container").remove();
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/public/index.php?load=#");
        });
    });
});