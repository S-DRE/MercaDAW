// central_editarAds.js
$(document).ready(function () {
    console.log("EDITAR ADS CARGADO");
    $(document.body).on("submit", "#formularioEditar", function (event) {
        event.preventDefault();

        /*
        var scriptTag = document.scripts[document.scripts.length - 1];
        var parentTag = scriptTag.parentNode;
        var idAnuncio = $(parentTag).data("idAnuncio");
        */


        var titulo = $("#titulo").val();
        var descripcion = $("#descripcion").val();
        var id = $("#idAnuncio").attr("value");
        var fotoFile = $("#fotoFile")[0].files[0];
        var fotoAntigua = $("#fotoAntigua").attr("value");

        if(fotoFile == undefined) {
            fotoFile = fotoAntigua;
        }

        let datosAEnviar = new FormData();

        datosAEnviar.append("titulo", titulo);
        datosAEnviar.append("descripcion", descripcion);
        datosAEnviar.append("idAnuncio", id);
        datosAEnviar.append("fotoFile", fotoFile);
        datosAEnviar.append("fotoAntigua", fotoAntigua);

        if(fotoFile == undefined) {
            fotoFile = fotoAntigua;
        }

        console.log("REPASO DE DATOS A ENVIAR EN EDITAR ADS");
        console.log(titulo);
        console.log(descripcion);
        console.log(id);
        console.log(fotoFile);
        console.log(fotoAntigua);

        console.log("DATOS A ENVIAR: ");
        for (var pair of datosAEnviar.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }

        // Aqui tiene que ser un $.ajax y no un $.post

        $.ajax({
            url: '/DWCC/jQueryMercaDAW/public/crud.php?op=6',
            data: datosAEnviar,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == "ok") {
                    console.log("La petición AJAX devolvió 'OK'");
                } else {
                    console.log("La petición AJAX devolvió otra cosa :" + res);
                    console.log("Respuesta: " + res);

                    $(".container").remove();
                    $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
                }
            },
            error: function (res) {
                console.log("La petición AJAX devolvió un error");
            }
        });

        /*
        $.post("/DWCC/jQueryMercaDAW/public/crud.php?op=6", { titulo: titulo, descripcion: descripcion, idAnuncio: id, fotoFile: fotoFile, fotoAntigua: fotoAntigua }, function (result) {
            console.log(result);
            $(".container").remove();
            $(".cuerpo").load("/DWCC/jQueryMercaDAW/inc/central_buscarAds.php");
        });
        */
    });
});