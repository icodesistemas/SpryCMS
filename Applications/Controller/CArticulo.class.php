<?php
   class CArticulo extends SpryController{

       public function action(){
            if(isset($_REQUEST["action"])){
                switch($_REQUEST['action']){
                    case 'guardar-articulo':
                        $this->setGuardarEditarPublicacion('agregar');
                        break;
                    case 'actualizar-articulo':
                        $this->setGuardarEditarPublicacion('actualizar');
                        break;
                }
            }
       }
       private function  setGuardarEditarPublicacion($action){
            $url = $this->Component()->Functions->getCrearUrl($_POST["titulo_publicacion"]);
            if(isset($_POST['publicacion-activa'])){
               $status = 'A';
            }else{
               $status = 'I';
            }
            $this->Model()->setBeginTrans();
            $msj = "";
            $data =  array(
                'titulo' => addslashes(strip_tags($_POST["titulo_publicacion"])),
                'descripcion' => $_POST["textarea-descripcion"],
                'url' => $url,
                'estado' => $status,
                'fk_pk_pagina' => addslashes(strip_tags($_POST["pk_pagina"])),
                'fecha_publicacion' => addslashes(strip_tags($_POST["fecha_publicacion"]))
            );


            if($action == 'actualizar'){
                $pk_publicacion = $_POST["pk"];
                $data = array_merge($data, array('pk_publicacion' =>intval($_POST["pk"]) ));
                $this->Model()->setUpdate('tb_publicaciones', $data);
                $msj = "Publicacion actualizada con exito";
            }else{
                $pk_publicacion = $this->Model()->setInsert('tb_publicaciones',$data);
                $msj = "Pagina registrada con exito";
            }

            $this->setGuardarImagenes($pk_publicacion);
            Spry::setMessageApplication($msj);
            $this->Model()->setCommit(true);
       }
       private function setGuardarImagenes($pk_publicacion){

            if(!isset($_POST['galeria_image'])){
                return false;
            }
            $this->Model()->setEliminarMultimedia($pk_publicacion);
            foreach($_POST['galeria_image'] as $key => $val){
                $data = array(
                    'fk_pk_publicacion' => $pk_publicacion,
                    'url_archivo' => addslashes(strip_tags($_POST["galeria_image"][$key])),
                    'tipo_archivo' => 'imagen'
                );

                $this->Model()->setInsert('tb_multimedia', $data);
            }
            return true;
       }
       public function Datos(){
           return $this->Model()->getData();
       }
       public function  getListadoPublicaciones(){
           $campos = ' pk_publicacion, a.titulo, a.url, estado, fecha_publicacion, pagina ';
           $where = ' pk_pagina = fk_pk_pagina';
           $rs = $this->Model()->getData(' tb_publicaciones a, tb_paginas b ', $campos, $where);
           return $rs;
       }
       public function getDatosPublicacion($pk){
            /* primero busco los datos de la publicacion */
           $datos = array();
           $campos = ' * ';
           $where = '  pk_publicacion = '.intval(addslashes($pk)).' ';
           $rs = $this->Model()->getData(' tb_publicaciones a ', $campos, $where);

            /*a#ado al array de datos el resultado de la busqueda anterior*/
           $datos = array_merge($datos, array('datos' =>$rs[0]));

           /*ahora se buscar los videos multimedia de la publicacion*/
           $campos = ' url_archivo, tipo_archivo ';
           $where = '  fk_pk_publicacion = '.intval(addslashes($pk)).' ';
           $rs = $this->Model()->getData(' tb_multimedia ', $campos, $where);
           $datos = array_merge($datos, array('multimedia' =>$rs));

           return $datos;
       }
       public function setDelete($pk){
           $array_archivo = $this->Model()->getRutaArchivoPublicacion($pk);
           $where = "pk_publicacion = ?";
           $data = array(addslashes(strip_tags($pk)));
           if($this->Model()->setDelete('tb_publicaciones', $where, $data)){
               $this->setBorrarArchivoPublicacion($array_archivo);
               Spry::setMessageApplication("Publicacion eliminada");
           }
       }
       private function setBorrarArchivoPublicacion($array){
           foreach($array as $key => $val){
                unlink($_SESSION['__APPLICATION_PATH'].$val['url_archivo']);
           }
       }
   }