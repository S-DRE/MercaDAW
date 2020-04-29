// publicarAds.js
$(document).ready(function() {
    $(document.body).on("submit", "form#formularioPublicacion", function(event) {
        // Pedir que haga una petición al crud.
        event.preventDefault();

        console.log("PASANDO POR PUBLICARADS.JS, PREVINIENDO LA REDIRECCIÓN AL CRUD");

        tituloVal = $("input#titulo").val();
        descripcionVal = $("#descripcion").val();
        fotografiaVal = $("input#fotoFile")[0].files[0];

        // fotografiaVal.name = "fotoFile";

        console.log("Fotografiaval");
        console.log(fotografiaVal);

        let datosAEnviar = new FormData();

        datosAEnviar.append('titulo', tituloVal);
        datosAEnviar.append("descripcion", descripcionVal);
        datosAEnviar.append("fotoFile", fotografiaVal);

        // Hacemos una petición post
        /*
        $.post("../public/crud.php?op=5", {titulo: tituloVal, descripcion: descripcionVal, fotoFile: fotografiaVal}, function(sesion) {
            $(".container").remove();
            // $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/public/index.php?load=#");

            // Queda añadir la imagen, no sé como se hace
        });
        */
        console.log("Preparando el AJAX...");
        $.ajax({
            url: '/DWCC/jQueryMercaDAW/public/crud.php?op=5',
            data: datosAEnviar,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(res){
             if (res == "ok") {
              // document.location = "https://a19andresaa.mywire.org/DWCC/jQueryMercaDAW/index.php";
              console.log("El AJAX devolvió OK: " + res);

              $(".container").remove();
              $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
             } else if (res == "") { 
                 console.log("El AJAX no devolvió nada.");
                 $(".container").remove();
                 $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
             } else {
                console.log("El AJAX devolvió otra cosa: " + res);

                $(".container").remove();
                $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/publicarAds.php");
             }
            },
            error: function(res){
                console.log("El AJAX devolvió un error");
            }
           });
    });
});