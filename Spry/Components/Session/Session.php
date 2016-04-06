<?php

require_once 'AbstractSession.php';

/**
 * Class Session
 */
class Session extends AbstractSession{


    public function setMakeSession(){
        $sql = "select name, pass,pk_user
					from tb_user
					where status = 'A' and login = ? ";
        try{

            $rs = $this->DB()->getRow($sql, array(addslashes(($_POST["user_login"]))));

            if(count($rs) < 2){
                Spry::setMessageApplication('Usuario no existe');
                return false;
            }

            if( $rs["pass"] != $this->Functions()->encrypt($_POST["user_password"]) ){
                Spry::setMessageApplication('Clave de acceso incorrecta');
                return false;
            }
            $_SESSION['id_session'] = $rs['pk_user'];
            $_SESSION['name_session'] = $rs['name'];
            $this->setRedirect('/dashboard');
        }catch(PDOException $e){
            Spry::setMessageApplication($e->getMessage());
        }

    }

    public function setMakeLogOut(){
        $_SESSION = array();
        session_destroy();
        $this->setRedirect('/');
    }

    public function action(){

        if(isset($_REQUEST['action'])){
            switch($_REQUEST['action']){
                case 'login':
                    $this->setMakeSession();
                    break;
                case 'logout':
                    $this->setMakeLogOut();
                    break;
            }
        }
    }
}