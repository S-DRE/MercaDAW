// central_buscarAds.js
$(document).ready(function () {
    $(document.body).on("click", ".editarLink", function (event) {
        event.preventDefault();
        var id = $(this).attr("href").split("id=")[1];


        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_editarAds.php?id=" + id);
    });


    $(document.body).on("click", ".borrarLink", function (event) {
        event.preventDefault();
        console.log("ANTES DE BORRAR...");
        var id = $(this).attr("href").split("id=")[1];

        $.get("/DWCC/jQueryMercaDAW/public/crud.php", { op: 7, id: id }, function (result) {
            console.log("RESULT");
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");

        });

        // $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/crud.php?op=3");

    });

    $(document.body).on("click", "#publicarAdsButton", function (event) {
        event.preventDefault();

        console.log("CLICK EN PUBLICARADSBUTTON");
        
        $(".container").remove();
        $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/publicarAds.php");
    });

    $(document.body).on("submit", "#formularioFiltrar", function (event) {
        event.preventDefault();
        console.log("Pasando por el submit de formularioFiltrar");
        // debugger;



        // $(".container").remove();
        // $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php?filtro=activo");


        var textoInputVal = $("#textoInput").val();

        console.log("Antes del post");
        $.post("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php?filtro=activo", { textoInput: textoInputVal }, function (result) {
            console.log("El post ha terminado.");
            $(".cuerpo").html(result);
        });
    });
});