<?php
    class MArticulo extends SpryModel{
        public function setEliminarMultimedia($pk_publicacion, $tipo_archivo = 'imagen'){
            $sql = 'delete from tb_multimedia where fk_pk_publicacion = ? and tipo_archivo= ?';
            $data = array(
                intval($pk_publicacion),
                addslashes(strip_tags($tipo_archivo))
            );
            try{
                if($this->DB()->exec($sql,$data)>0){
                    return true;
                }
            }catch(PDOException $e){
                return false;
            }

        }
        public function getRutaArchivoPublicacion($pk_publicacion){
            $sql = 'select url_archivo from tb_multimedia where fk_pk_publicacion = ?';
            try{
                return $this->DB()->getArray($sql,array(intval($pk_publicacion)));
            }catch(PDOException $e){
                return array();
            }
        }
    }
