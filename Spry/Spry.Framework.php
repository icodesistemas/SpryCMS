<?php
/**
 *
 * User: abejarano
 * Date: 24-Mar-16
 * Time: 7:51 PM
 */


require_once "Spry.Base.Controller.php";
require_once "Spry.Base.Model.php";
require_once "Spry.Path.php";

include('Components/Session/Session.php');

class Spry extends SpryPath{
    private $librery;
    private $view;
    private $conf;
    private static $msj;

    public function __construct($librery, $conf){
        $this->librery = $librery;
        $this->conf = $conf;
        parent::__construct($conf);
        $this->setUrlManager();

        $this->setInitComponent();
        //$this->get();
    }

    private function setInitComponent(){
        if(!isset($this->conf['components'])){
            return false;
        }

        foreach($this->conf["components"] as $key => $val){
            switch($val){
                case 'login':
                    $session = new Session($this->librery);
                    $session->action();
                    break;
            }
        }
    }
    public function setLoadApplication(){
        /*cargare la vista*/
        $infoView = $this->getInfoFile($this->conf['view'],"view");
        $this->view = $infoView['path'];

        //vista general es la vista por defecto que buscara el framework cuando no se indique vistas por la url
        if($infoView['name'] != 'vista-default'){
            /*cargar el model*/
            $instanceModal = $this->setLoadModel($this->librery->DB);

            if( is_object($instanceModal)){

                $this->librery->Model = $instanceModal;

                /*cargare el controlador*/
                $instanceController = $this->setLoadController($this->librery);
                if(is_object($instanceController)){
                    $this->librery->Controller = $instanceController;
                }
            }
        }

    }
    public function Services(){
        unset($this->librery->Model);
        return $this->librery;
    }
    public function getView(){
        return $this->view;
    }
    public static function setMessageApplication($msj){
        self::$msj = $msj;
    }
    public static function getMessage(){
        return self::$msj;
    }
}