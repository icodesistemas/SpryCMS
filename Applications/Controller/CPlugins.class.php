<?php

/**
 * Created by PhpStorm.
 * User: abejarano1
 * Date: 19/04/16
 * Time: 07:08 PM
 */
class CPlugins extends SpryController{


    public function action(){
        if(isset($_POST["action"])){
            switch($_POST["action"]){
                case 'actualizar':
                    $this->setSaveVideoYoutube('update');
                    break;
                case 'guardar':
                    $this->setSaveVideoYoutube('add');
                    break;
            }

        }
    }
    private function setSaveVideoYoutube($action){


         if(isset($_POST['video-activo'])){
             $status = 'A';
         }else{
             $status = 'I';
         }
         $data = array(
             'codigo' => addslashes(strip_tags($_POST['codigo_video'])),
             'status' => $status,
         );
         if($action == 'add'){
             $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$_POST['codigo_video']);
             parse_str($content, $info);
             $titulo = $info['title'];
             $duracion = $info['length_seconds'];

             $miniatura = $this->setSaveImagenVideo("http://img.youtube.com/vi/".$_POST['codigo_video']."/1.jpg");
             $normal = $this->setSaveImagenVideo("http://img.youtube.com/vi/".$_POST['codigo_video']."/0.jpg");

             $data = array_merge($data, array('Thumbnails' =>$miniatura,
                                              'Imagen' => $normal,
                                              'titulo' => $titulo,
                                              'duracion' => $this->Component()->Functions->getConversorSegundosHoras($duracion)
             ));
             if($this->Model()->setInsert('tb_plugins_youtube', $data)){
                 Spry::setMessageApplication("Video agregado al playlist");
             }
         }else{
             $data = array_merge($data, array('pk_video' => addslashes(strip_tags($_POST["pk"]))));
             if($this->Model()->setUpdate('tb_plugins_youtube', $data)){
                 Spry::setMessageApplication("Video actualizado con exito");
             }
         }

    }
    private function setSaveImagenVideo($url_File){
        $file = "/Cluster/Plugins_YouTube/". mktime() . ".jpg";
        $imageContent = file_get_contents($url_File);
        file_put_contents(__APPLICATION_PATH.$file, $imageContent);

        return $file;
    }
    public function getDatosVideo($pk){
        $campos = '*';
        $where = 'pk_video = '.intval($pk);
        $rs = $this->Model()->getData('tb_plugins_youtube',$campos,$where);
        return $rs[0];
    }
    public function getPLayList(){
        $campos = '*';
        return $this->Model()->getData('tb_plugins_youtube',$campos);
    }
    public function setDelete($pk){
        $rs = $this->getDatosVideo($pk);
        $where = 'pk_video = ?';
        $data = array(intval($pk));

        if($this->Model()->setDelete('tb_plugins_youtube', $where, $data)){
            Spry::setMessageApplication("Video eliminado del playlist");
            $this->setEliminarImagenVideo($rs["Thumbnails"]);
            $this->setEliminarImagenVideo($rs["Imagen"]);
        }
    }
    private function setEliminarImagenVideo($img){
        unlink(__APPLICATION_PATH.$img);
    }
}