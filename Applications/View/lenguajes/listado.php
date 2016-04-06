
<h1 class="text-light">Listado de página web<span class="mif-section place-right"></span></h1>
<hr class="thin bg-grayLighter"><br>

<a href="/paginas" class = "button primary"><span class="mif-plus"></span> Nuevo</a>
<a class="button warning" onclick="accionBoton('actualizar','/idiomas/buscar')"><span class="mif-loop2"></span> Actualizar</a>
<a class="button alert" onclick="accionBoton('eliminar','/idiomas/listado/eliminar')"><span class="mif-cross"></span> Eliminar</a>

<hr class="thin bg-grayLighter"><br>

<table class="dataTable border bordered no-footer" >
    <thead>
    <tr>
        <th style="width: 40px"></th>
        <th class="sortable-column">Código</th>
        <th class="sortable-column">Descripcion</th>
        <th style="width: 80px" class="sortable-column">Estatus</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $rs =  $Spry->Services()->Controller->getListadoIdiomas();

    if(!is_null($rs)){
        foreach ($rs as $key => $value) {
            if($value['status_idioma'] == 'A'){
                $check = 'checked = checked ';
            }else{
                $check = '';
            }
            echo '
                    <tr>
                        <td>
                            <label class="input-control checkbox small-check no-margin">
                                <input type="radio" name="item" class="check-item" id = "'.$value["pk_idioma"].'">
                                <span class="check"></span>
                            </label>
                        </td>
                        <td>'.$value['pk_idioma'].'</td>
                        <td>'.$value['nombre_idioma'].'</td>
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