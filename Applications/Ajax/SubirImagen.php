<?php
    session_start();
    ini_set("display_errors", 1);

    define("__APPLICATION_PATH",$_SESSION["__APPLICATION_PATH"]);
    define("__APPLICATION_FOLDER_MODEL", "Applications/Model");
    define("__APPLICATION_FOLDER_CONTROLLER", "Applications/Controller");
    define("__APPLICATION_FOLDER_VIEW", "Applications/View");
    require_once  __APPLICATION_PATH."/Spry/Spry.Configure.php";

    $upload_dir = $_SESSION["__APPLICATION_PATH"]."/Cluster/";

    if(isset($_REQUEST['action'])){
        switch($_REQUEST['action']){
            case 'subir_imagen':
                subirImagen();
                break;
            case 'eliminar_imagen':
                eliminarImagen();
                break;
        }
    }

    function eliminarImagen(){
        $img = $_SESSION["__APPLICATION_PATH"].$_GET['img'];
        SpryImage::setDeleteImage($img);
        SpryImage::setDeleteThumbnail($img);

    }

    function subirImagen(){
        global $upload_dir;
        $img = $_POST['hidden_data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $file = $upload_dir . mktime() . ".png";

        $success = file_put_contents($file, $data);
        SpryImage::setImagen($file,1200,1200);
        SpryImage::setCreateThumbnail($file,100,100);
        echo "/Cluster/".str_replace($upload_dir,'',$file);
    }
?>