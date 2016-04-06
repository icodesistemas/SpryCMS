<h1 class="text-light">Listado de publicaciones<span class="mif-section place-right"></span></h1>
<hr class="thin bg-grayLighter"><br>

<a href="/publicacion" class = "button primary"><span class="mif-plus"></span> Nuevo</a>
<a class="button warning" onclick="accionBoton('actualizar','/publicacion/buscar')"><span class="mif-loop2"></span> Actualizar</a>
<a class="button alert" onclick="accionBoton('eliminar','/publicacion/listado/eliminar')"><span class="mif-cross"></span> Eliminar</a>
<a href="/publicacion" class="button default"><span class="mif-layers"></span> Cancelar</a>

<hr class="thin bg-grayLighter"><br>

<table class="dataTable border bordered no-footer" >
    <thead>
    <tr>
        <th style="width: 40px"></th>
        <th class="sortable-column">Título</th>
        <th class="sortable-column">Url</th>
        <th class="sortable-column">Página donde se muestra</th>
        <th class="sortable-column">Fecha de publicación</th>
        <th style="width: 80px" class="sortable-column">Estatus</th>
    </tr>
    </thead>
    <tbody>
        <?php
            $rs = $Spry->Services()->Controller->getListadoPublicaciones();

            if(!is_null($rs)){
                foreach($rs as $key => $val){
                    if($val['estado'] == 'A'){
                        $check = 'checked = checked ';
                    }else{
                        $check = '';
                    }
                    echo '
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="radio" name="item" class="check-item" id = "'.$val["pk_publicacion"].'">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>'.$val['titulo'].'</td>
                            <td>'.$val['url'].'</td>
                            <td>'.$val['pagina'].'</td>
                            <td>'.$val['fecha_publicacion'].'</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="pagina-activa" '.$check.'>
                                    <span class="check"></span>
                                </label>
                            </td>
                        </tr>
                    ';
                }

            }

        ?>

    </tbody>

</table>