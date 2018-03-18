$(document).ready(function()
{
    "use strict";
    var formulario=$('form[name="archivo"]');
    var url=formulario.attr('action');

    $("#cargadorArchivos").uploadFile({
        url:url,
        dynamicFormData: function()
        {
            return formulario.serializeObject();
        },
        fileName: 'archivo[archivo]',
        multiple: false,
        showStatusAfterSuccess: false,
        uploadStr: 'Carga',
        dragDropStr: "<span><b>Area para arrastrar y soltar archivos</b></span>",
        onSuccess: function(files,data,xhr)
        {
            $("#sessionFlash").empty().append(tmpl('plantillaHighlight',data.mensaje));
            $("table#listaArchivos tbody").prepend(tmpl('archivoRow',data.archivo));
            $(".borrarFila").borraFila();
        }
    });
});