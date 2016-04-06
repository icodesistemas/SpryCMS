<?php
    /**
     * se encarga de la administracion de que sera las diferentes paginas del front end
     */
    class CPagina extends SpryController{

        public function action(){

            if( isset($_REQUEST["action"])){
                switch($_REQUEST["action"]){
                    case 'guardar':
                        $this->setGuarEditar('guardar');
                        break;
                    case 'actualizar':
                        $this->setGuarEditar('actualizar');
                        break;
                    case 'guardar-idioma':
                        $this->setGuarEditarIdiomas('guardar');
                        break;
                    case 'actualizar-idioma':
                        $this->setGuarEditarIdiomas('actualizar');
                        break;
                }
            }

        }
        private function setGuarEditar($action){
            $url = $this->Component()->Functions->getCrearUrl($_POST["titulo"]);
            if(isset($_POST['pagina-activa'])){
                $status = 'A';
            }else{
                $status = 'I';
            }
            $data = array(
                'pagina' => addslashes(strip_tags($_POST['seccion'])),
                'url' => $url,
                'descripcion' => addslashes(strip_tags($_POST['descrip'])),
                'titulo' => addslashes(strip_tags($_POST['titulo'])),
                'abrir' => addslashes(strip_tags($_POST['open-URL'])),
                'status' => $status,
                'pk_pagina_padre' => addslashes(strip_tags($_POST['cb-padre']))
            );
            if($action == 'actualizar'){
                $data = array_merge($data, array('pk_pagina' =>intval($_POST["pk"]) ));
                if($this->Model()->setUpdate('tb_paginas', $data)){
                    Spry::setMessageApplication("Datos de la pagina actualizados con exito");
                }
            }else{
                $this->Model()->setInsert('tb_paginas',$data);
                Spry::setMessageApplication("Pagina registrada con exito");
            }

        }
        public function getListadoPaginas(){
            $campos = 'pk_pagina,pagina, titulo, url, descripcion,status';
            return $this->Model()->getData('tb_paginas',$campos);

        }
        public function getDatosPagina($pk){
            $campos = 'pk_pagina,pagina, titulo, url, descripcion,status, abrir,pk_pagina_padre';
            $where = 'pk_pagina = '.intval($pk);
            $rs = $this->Model()->getData('tb_paginas',$campos,$where);
            return $rs[0];
        }
        public function setDelete($pk){
            $where = 'pk_pagina = ?';
            $data = array(intval($pk));

            if($this->Model()->setDelete('tb_paginas', $where, $data)){

                Spry::setMessageApplication("Pagina eliminada");
            }else{

                Spry::setMessageApplication("SSSSSSSSSSSSsa");
            }
        }
        public function getDatosIdioma($pk){
            $campos = "*";
            $where = "pk_idioma = '".addslashes(strip_tags($pk))."'";

            $rs = $this->Model()->getData('tb_idiomas',$campos,$where);
            return $rs[0];

        }

        /**
         * @return array con todos los datos encontrados en la tabla
         */
        public function getListadoIdiomas(){
            $campos = '*';
            $rs = $this->Model()->getData('tb_idiomas',$campos);
            return $rs;

        }
        private function setGuarEditarIdiomas($accion){

            if(isset($_POST['idioma-activo'])){
                $status = 'A';
            }else{
                $status = 'I';
            }
            $data = array(
                'pk_idioma' => addslashes(strip_tags($_POST['codigo_idioma'])),
                'nombre_idioma' => addslashes(strip_tags($_POST['nombre_idioma'])),
                'status_idioma' => $status

            );
            if($accion == 'actualizar'){
                $data = array_merge($data, array('pk_pagina' =>intval($_POST["pk"]) ));
                if($this->Model()->setUpdate('tb_idiomas', $data)){
                    Spry::setMessageApplication("Datos del idioma actualizados con exito");
                }
            }else{
                $this->Model()->setInsert('tb_idiomas',$data);
                Spry::setMessageApplication("Idioma registrado con exito");
            }
        }
        public function setDeleteIdiomas($pk){
            $where = "pk_idioma = ?";
            $data = array(addslashes(strip_tags($pk)));

            if($this->Model()->setDelete('tb_idiomas', $where, $data)){

                Spry::setMessageApplication("Idioma eliminado");
            }
        }
    }