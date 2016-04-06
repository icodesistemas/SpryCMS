<?php
    /* si la accion sera actualiazr entonces mostramos de una ves el flecha de continuar */
    $imagenes = "";
    if($action == 'actualizar-articulo'){
        $style = 'style = "display:block" ';
        /* cargar todas las imagenes para ser mostradas al usuario */

        $key = 0;
        foreach($rs['multimedia'] as $key => $val){
            $imagenes .= '
                <div class="icon-foto" id="photo'.$key.'">
                    <img src="'.$val['url_archivo'].'"  onclick="uploadImage(\'photo'.$key.'\')">
                    <i onclick="eliminarImagen(\''.$val['url_archivo'].'\',\'photo'.$key.'\')" class="delete">Eliminar</i>
                    <input type="hidden" value="'.$val['url_archivo'].'" name="galeria_image[]" id="input_photo1">
                </div>
            ';
        }
        /* si $key es menor que 6 se le coloca al usuario la posibilidad de cargar mas fotos */
        if($key < 6){
            for($i = $key + 1; $i <6; $i++){
                $imagenes .= '
                    <div class="icon-foto" id="photo'.$i.'">
                        <img src="/Public/img/ico-photo.png"  onclick="uploadImage(\'photo'.$i.'\')">
                        <i></i>
                    </div>
                ';
            }
        }
    }else{
        $style = 'style = "display:none" ';
        for($i = 0; $i <6; $i++){
            $imagenes .= '
                    <div class="icon-foto" id="photo'.$i.'">
                        <img src="/Public/img/ico-photo.png"  onclick="uploadImage(\'photo'.$i.'\')">
                        <i></i>
                    </div>
                ';
        }
    }

?>
<div <?= $style ?> class="continuar" id="continuar-paso-2">
    <span class="mif-arrow-right icon"></span>
</div>
<div id="barra-progreso">
    <progress></progress>
    <p>100 %</p>
</div>

<strong>Imagenes:</strong>
<hr class="thin bg-grayLighter">
<div style="width: 50%; float: left">
    <?= $imagenes ?>
    <div class="clear"></div>
</div>

<div class="clear"></div>