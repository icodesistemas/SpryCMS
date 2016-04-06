<?php
/**
 * Created by PhpStorm.
 * User: abejarano
 * Date: 24-Mar-16
 * Time: 8:51 PM
 */

    Abstract Class SpryModel {
        /*
         * @Librerias registradas
         */
        protected $Librery;
        private $message;


        // ************************************
        function __construct($librery) {
            $this->librery = $librery;
        }
        public function setBeginTrans(){
            $this->DB()->setBeginTrans();
        }
        public function setCommit($commit){
            $this->DB()->setCommit($commit);

        }
        public function DB(){
            return $this->librery;
        }
        public function setInsert($table, $data){
            try{
                return $this->DB()->qqInsert($table, $data);

            }catch(PDOException $e){
                Spry::setMessageApplication($e->getMessage());
                return 0;
            }

        }
        public function setUpdate($table, $data){
            try{
                return $this->DB()->qqUpdate($table, $data);

            }catch(PDOException $e){
                Spry::setMessageApplication($e->getMessage());
                return 0;
            }

        }
        public function setSQLInsert($sql, $data){
            try{
                return $this->DB()->exec($sql, $data);

            }catch(PDOException $e){
                Spry::setMessageApplication($e->getMessage());
                return 0;
            }
        }

        public function setDelete($table, $where, $data = ""){
            try{
                $sql = "delete from {$table} where {$where}";
                if(empty($data)){
                    $this->DB()->exec($sql);
                }else{
                    $this->DB()->exec($sql, $data);
                }

                return true;
            }catch(PDOException $e){
                Spry::setMessageApplication($e->getMessage());
                return false;
            }
        }
        public function getData($table, $field, $where = null){
            if(!empty($where)){
                $sql = "select {$field} from {$table} where {$where}";
            }else{
                $sql = "select {$field} from {$table} ";
            }

            try{
                $rs = $this->DB()->getArray($sql);
                return $rs;
            }catch(PDOException $e){
                Spry::setMessageApplication($e->getMessage());
                return null;
            }
        }
    }