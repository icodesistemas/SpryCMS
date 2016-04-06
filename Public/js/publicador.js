var IMG_EDITOR = 0;
tinymce.init({
    selector: "textarea#textarea-descripcion",
    language : "es",
    plugins: ["image"],
    file_browser_callback: function(field_name, url, type, win) {
        if(type=='image'){
            $('#my_form input').click();
        }
    },
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
    relative_urls: true,
    toolbar_items_size: "medium",
    schema: "html5",
    menubar: 'insert view format',
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    // Plugins
    plugins : "table link charmap autolink lists preview media textcolor image",
    // Toolbar
    toolbar1: "bold italic underline strikethrough | forecolor | backcolor | fontsizeselect | aligncenter alignleft alignjustify | formatselect | bullist numlist",
    toolbar2: "outdent indent | undo redo | link unlink anchor video_template_callback charmap | preview",
    height: "400",
    inline: false
});
$(function(){
    $("#imagen_upload2").on("change", function(e){
        if(IMG_EDITOR > 6){
            mostrarMensajes("Ha superado la cantidad de imagenes permitidas");
            return false;
        }
        //$('#progress').show();
        e.preventDefault();
        //$('#img-ajax').show();
        var formData = new FormData($("#my_form")[0]);
        var ruta = "/Applications/Ajax/SubirImagen.php";

        $.ajax({
            url: ruta,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress',function(ev) {
                        if (ev.lengthComputable) {
                            var percentUploaded = Math.floor(ev.loaded * 100 / ev.total);
                            //console.log('Cargando archivo '+percentUploaded+'%');
                            /*$('#progress').val(percentUploaded);
                             $('#porcentaje').text(percentUploaded+"%");*/
                            // update UI to reflect percentUploaded
                        } else {
                            console.info('Uploaded '+ev.loaded+' bytes');
                            // update UI to reflect bytes uploaded
                        }
                    }, false);
                }
                return myXhr;
            },
            success: function(datos){
                //$('#progress').hide();
                if(datos.message != "bien"){
                    alert(datos.message);
                }else{
                    tinyMCE.execCommand('mceInsertContent',false,'<br>'+datos.archivo)
                    IMG_EDITOR = IMG_EDITOR  + 1;
                }
            },
            error: function (err) {
                //$('#barra_progreso').hide();
                alert(err.responseText);
                //$('#img-ajax').hide();
            }

        })
    });

    $('#continuar-paso-2').click(function(){
        $('#tab-multimedia').removeClass('active');
        $('#multimedia').hide();

        $('#tab-detalle').removeClass('disabled')
        $('#tab-detalle').addClass('active');
        $('#detalle').show();
    })
})