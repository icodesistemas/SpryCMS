<?php
    include(__APPLICATION_FOLDER_VIEW.'/components/header.php');
    echo '<div id = "left">';

    include(__APPLICATION_FOLDER_VIEW.'/components/nav.php');

    echo '</div>';

?>
<div id="right">
    <?php
    if($Spry->getParameterUrl(2) == 'listado'){
        if($Spry->getParameterUrl(3) == "eliminar" && !empty($Spry->getParameterUrl(4))){
            $Spry->Services()->Controller->setDeleteIdiomas($Spry->getParameterUrl(4));
        }

        include 'listado.php';
    }else{
        if($Spry->getParameterUrl(2) =='buscar' && !empty($Spry->getParameterUrl(3))){
            $rs = $Spry->Services()->Controller->getDatosIdioma($Spry->getParameterUrl(3));
            $action = 'actualizar-idioma';
            $soloLentura = "readonly = \"readonly\" ";
        }else{
            $soloLentura = "";
            $action = 'guardar-idioma';
        }
        include 'agregar-actualizar.php';
    }
    ?>
</div>
