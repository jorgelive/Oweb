$.fn.borraFila = function() {
    "use strict";
    this.click(function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var url = $(this).prop('href');
        var deleting = $.ajax({
            url: url,
            type: 'DELETE',
            statusCode: {
                500: function() {
                    window.alert("500 Error Interno: No se ha eliminado la fila.");
                }
            }
        });
        deleting.done(function(data) {
            if(!data.hasOwnProperty('mensaje')){
                window.alert ('La respuesta no fue válida.');
                return false;
            }
            if(data.mensaje.exito=='si'){

                $("table#listaArchivos tr[data-id="+id+"]").remove();
                $("#sessionFlash").empty().append(tmpl('plantillaHighlight',data.mensaje));
            }else{
                $("#sessionFlash").empty().append(tmpl('plantillaError',data.mensaje));
            }
        });
    });
};
$(document).ready(function()
{
    "use strict";
    $(".borrarFila").borraFila();
});