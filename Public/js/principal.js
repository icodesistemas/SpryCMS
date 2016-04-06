/*$(function(){
    $('.check-select').click(function(){

        var id = $(this).attr('id');
        $('.check-select').removeAttr('checked');
        $('#'+id).attr('checked', 'checked');
    });
})*/

function accionBoton(accion, url){
    var chck = false;
    var valor = "";
    $('.check-item').each( function() {

        if($(this).is(':checked')){
            chck = true;
            valor = $(this).attr('id');

        }
    });
    if(!chck){
        alert("Debe seleccionar una elemento de la lista");
        return;
    }
    if(accion == "actualizar"){
        location.href = url+'/'+valor;
    }else if(accion == "eliminar"){
        if(confirm('¿Desea eliminar el articulo?')){
            location.href = url+'/'+valor;
        }


    }
}