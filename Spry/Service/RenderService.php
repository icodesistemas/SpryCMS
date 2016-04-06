<?php
/**
 *
 * User: abejarano
 * Date: 15/01/16
 * Time: 09:38 AM
 */
    require_once pathIsNow."/Permit/Permits.php";
    require_once pathIsNow."/isNow/Service/DataBaseService/Mongo/dbMongo.php";
    require_once pathIsNow."/isNow/Service/DataBaseService/Pdo/DataBase.php";

    class RenderService extends Permits{
        public function getConexionPostgreSQL(){

            return new DataBase(pathIsNow."/Permit/conf-conex-postgres.xml");
        }

        public function setValidatePermits(){

            if(!isset($_REQUEST["session"])){
                http_response_code(400);
                echo json_encode(array("message" => "Incorrect request"));
                return false;
            }
            if($_REQUEST["session"] == 0){

                if(!$this->validateApplication()){
                    http_response_code(403);
                    echo json_encode(array("message" => "unknown Origin"));
                }else{
                    http_response_code(200);
                    echo json_encode(array("message" => "Welcome"));
                }
                return false;
            }else{
                return true;
            }
        }


    }