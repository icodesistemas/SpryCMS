<?php

/**
 * User: abejarano1
 * Date: 03/04/16
 * Time: 08:09 PM
 */
require_once "Thumbnails/ThumbLib.inc.php";
class SpryImage{

    /**
     * @param $src Origen de la ubicacion de la imagen
     * @param $ancho Nuevo ancho que de desea
     * @param $alto Nuevo alto para la imagen
     */
    public static function setImagen($src, $ancho, $alto){
        $thumb = PhpThumbFactory::create($src);
        $thumb->resize($ancho, $alto);
        $thumb->save($src);

    }
    public static function setCreateThumbnail($img, $ancho, $alto, $identify = "thumb_"){
        $Thumb = explode("/", $img);

        $Thumbnail = "";
        $i = 0;
        foreach ($Thumb as $key => $value) {

            if($i >= count($Thumb) -1 ) {
                $Thumbnail .= "/".$identify.$value;
            }elseif($i>0){
                $Thumbnail .= "/".$value;
            }

            $i++;
        }
        $thumb = PhpThumbFactory::create($img);
        $thumb->resize($ancho, $alto);
        $thumb->save($Thumbnail);
    }
    public static function setDeleteImage($src){
        unlink($src);
    }
    public static function setDeleteThumbnail($src, $identify = "thumb_"){
        $Thumb = explode("/", $src);
        $Thumbnail = "";
        $i = 0;
        foreach ($Thumb as $key => $value) {

            if($i >= count($Thumb) -1 ) {
                $Thumbnail .= "/".$identify.$value;
            }elseif($i>0){
                $Thumbnail .= "/".$value;
            }

            $i++;
        }
        self::setDeleteImage($Thumbnail);
    }
}