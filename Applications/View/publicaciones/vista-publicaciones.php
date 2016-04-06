<?php
    include(__APPLICATION_FOLDER_VIEW.'/components/header.php');
    echo '<div id = "left">';

    include(__APPLICATION_FOLDER_VIEW.'/components/nav.php');

    echo '</div>';

?>
<div id="right">
    <?php
        if($Spry->getParameterUrl(2) == 'listado'){
            if($Spry->getParameterUrl(3) == "eliminar" && is_numeric($Spry->getParameterUrl(4))){
                $Spry->Services()->Controller->setDelete($Spry->getParameterUrl(4));
            }

            include 'listado.php';
        }else{
            if($Spry->getParameterUrl(2) =='buscar' && is_numeric($Spry->getParameterUrl(3))){

                $rs = $Spry->Services()->Controller->getDatosPublicacion($Spry->getParameterUrl(3));

                $action = 'actualizar-articulo';
            }else{
                $action = 'guardar-articulo';
            }
            include 'agregar-actualizar.php';
        }
    ?>
</div>
