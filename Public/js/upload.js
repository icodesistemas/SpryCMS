var input=document.createElement('input');
input.type="file";

var objHtml;
var cantidad_imagen = 6;
//$(input).click();

$(function(){
    $(input).change(function(e){
        handleFileSelect(e);
    });
});
function uploadImage(obj){
    objHtml = obj;
    $(input).click();
}
function handleFileSelect(evt) {

    var files = evt.target.files[0]; // FileList object

    if (files.type == 'image/jpg' || files.type == 'image/jpeg' || files.type == 'image/png' || files.type == 'image/gif') {
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
                    if (image.width < 400) {
                        alert("Por favor ingrese una imagen mas grande");
                        return false;
                    } else if (image.height < 300) {
                        alert("Por favor ingrese una imagen mas grande");
                        return false;
                    }
                    //console.log(image.width);
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(image, 0, 0);
                    var MAX_WIDTH = 800;
                    var MAX_HEIGHT = 800;
                    var width = image.width;
                    var height = image.height;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(this, 0, 0, width, height);

                    var dataurl = canvas.toDataURL("image/jpg");
                    /*es la imagen que se muestra en el primer momento que cargan el formulario de subir imagenes*/
                    var imgReferencia = $('#' + objHtml + " img").attr('src');
                    $('#' + objHtml + " img").attr('src', dataurl);
                    $('#' + objHtml + " i").remove();

                    document.getElementById('hidden_data').value = dataurl;
                    var fd = new FormData(document.forms["form1"]);

                    //var formElement = document.querySelector("form");
                    $('#barra-progreso').show();
                    if (window.XMLHttpRequest) {
                        var xmlhttp = new XMLHttpRequest();
                    } else {
                        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }

                    xmlhttp.open("POST", "/Applications/Ajax/SubirImagen.php");
                    xmlhttp.upload.onprogress = function (e) {
                        if (e.lengthComputable) {
                            var percentUploaded = Math.floor(e.loaded * 100 / e.total);
                            //console.log('Cargando archivo '+percentUploaded+'%');
                            $('#barra-progreso progress').val(percentUploaded);
                            $('#barra-progreso p').text(percentUploaded + "%");

                        }
                    };
                    xmlhttp.send(fd);
                    xmlhttp.onreadystatechange = function () {
                        $('#barra-progreso').hide();
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            $('#barra-progreso').hide();
                            element = '<input type = "hidden" id = "input_'+objHtml+'" name = "galeria_image[]" value = "' + xmlhttp.responseText + '"> ';
                            deleteElement = '<i class="delete" onclick="eliminarImagen(\''+xmlhttp.responseText+'\',\''+objHtml+'\')">Eliminar</i>';
                            $('#' + objHtml).append(element+deleteElement);
                            $('#continuar-paso-2').show();
                            cantidad_imagen = cantidad_imagen - 1;
                        } else if (xmlhttp.status == 413) {
                            $('#' + objHtml + " img").attr('src', imgReferencia);
                            alert('Imagen no soportada, es muy grande');

                        }
                    };
                };
            };
        })(files);
        // Read in the image file as a data URL.
        reader.readAsDataURL(files);

        //}
    }else{
        alert("Archivo no soportado");
    }

}
function eliminarImagen(img, obj){
    if(confirm('Desea eliminar la imagen?')){

        if (window.XMLHttpRequest) {
            var xmlhttp = new XMLHttpRequest();
        } else {
            var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "/Applications/Ajax/SubirImagen.php?action=eliminar_imagen&img="+img, true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $('#input_'+obj).on().remove();
                $('#' + obj + " img").attr('src', '/Public/img/ico-photo.png');
                $('#' + obj + " i").on().remove();
                cantidad_imagen = cantidad_imagen + 1;
                if(cantidad_imagen == 6){
                    $("#continuar-paso-2").hide();
                }
            }
        };
    }

}