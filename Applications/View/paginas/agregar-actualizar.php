<h1 class="text-light">Administración de secciones de la página web<span class="mif-section place-right"></span></h1>
<hr class="thin bg-grayLighter"><br>
<button form = "form-section" class = "button primary"><span class="mif-floppy-disk"></span> Guardar...</button>
<a href="/paginas/listado" class="button warning"><span class="mif-list2"></span> Listados</a>
<a href="/paginas" class="button default"><span class="mif-layers"></span> Limpiar</a>

<hr class="thin bg-grayLighter"><br>

<form id="form-section" method="post" action="" data-role="validator"
      data-on-error-input="notifyOnErrorInput"
      data-show-error-hint="false">

    <input type="hidden" name="action" value="<?=$action?>">
    <input type="hidden" name="pk" value="<?= (isset($rs["pk_pagina"]) ? $rs["pk_pagina"] : '') ?>">


    <section style="width:80%; float:left;">
        <div class="input-control text" style="width: 100%">
            <label>Sección</label>
            <input type="text" autofocus="on" placeholder="Nombre o Título de la Sección" value = "<?= (isset($rs["pagina"]) ? $rs["pagina"] : '') ?>" name="seccion" data-validate-func="required"
                   data-validate-hine="This field can not be empty!">
            <span class="input-state-error mif-warning"></span>

        </div>
        <div class="clear"></div>
        <br><br>
        <div class="input-control text" style="width: 44%">
            <label>Título</label>
            <input type="text" placeholder="Título de la sección" value="<?= (isset($rs["titulo"]) ? $rs["titulo"] : '') ?>" name="titulo" required="required" data-validate-func="required"
                   data-validate-hine="This field can not be empty!">
        </div>
        <div class="input-control text">
            <label>URL</label>
            <input type="text" value="<?=(isset($rs["url"]) ? $rs["url"] : '') ?>" name="URL">
        </div>

        <div class="input-control text">
            <label>Abrir URL en:</label>
            <select name="open-URL" id = "open-URL">
                <option value="">Misma Ventana</option>
                <option value="_blank">Otra Venta</option>
            </select>
        </div>
        <div class="clear"></div>
        <br><br>
        <div class="input-control text" style="width: 100%">
            <label>Descripción</label>
            <input type="text" placeholder="Descripcion de la razon de la sección" value="<?=(isset($rs["descripcion"]) ? $rs["descripcion"] : '') ?>" maxlength="200" name="descrip" required="required" data-validate-func="required"
                   data-validate-hine="This field can not be empty!">
        </div>
        <div class="clear"></div>
        <br>
        <label class="switch">Sección Activa?</label>
        <label class="switch">
            <input type="checkbox" name="pagina-activa" <?=(isset($rs["status"]) ? 'checked = "checked"' : '') ?>>
            <span class="check"></span>
        </label>
        <div class="input-control text">
            <label>Página padre</label>
            <select name="cb-padre" id="cb-padre">
                <option value="/">Raiz</option>
                <?php
                    $where = ' status = "A" ';
                    echo $Spry->Services()->Functions->getLoadCombo('tb_paginas', 'pk_pagina, pagina',$where);
                ?>
            </select>
        </div>

        <div class="clear"></div>
    </section>
</form>



<script>
    $(function(){
        <?php
            if(isset($rs["abrir"]) && !empty($rs["abrir"])){
                echo '$("#open-URL option[value='.$rs["abrir"].']").attr("selected",true);';
            }
            if(isset($rs["pk_pagina_padre"])){
                echo '$("#cb-padre option[value='.$rs["pk_pagina_padre"].']").attr("selected",true);';
            }
        ?>
    })
    function notifyOnErrorInput(input){
        var message = input.data('validateHint');
        $.Notify({
            caption: 'Error',
            content: message,
            type: 'alert'
        });
    }
</script>