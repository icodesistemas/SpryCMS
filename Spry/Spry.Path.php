<?php
/**
 * Administracion de archivos
 * User: abejarano
 * Date: 24-Mar-16
 * Time: 6:54 PM
 */

class SpryPath{
    private $route = array();
    private $view = "vista-default";
    private $action;
    private $parameter;
    private $conf; // array dond esta la configuracion de la aplicacion
    private $pathView;
    /**
     * Detecta cual es la vista que se esta llamando
     */
    public function __construct($conf){
        $this->conf = $conf;
    }

    protected function setUrlManager(){
        if(!isset($_REQUEST["ROUTE"])){
            return false;
        }
        // siempre la primer posicion sera el nombre la vista
        $this->route = explode("/",$_REQUEST["ROUTE"]);

        $this->view = $this->route[1];


    }
    public function getParameterUrl($nro){
        if(!isset($this->route[$nro])){
            return null;
        }else{
            return $this->route[$nro];
        }

    }
    protected function setLoadModel($librery){
        $infoModal = $this->getInfoFile($this->conf['model'], 'model');
        if(is_null($infoModal)){
            return null;
        }
        include ($infoModal["path"]);
        $nameClass = $infoModal["name"];
        $obj = new $nameClass($librery);
        return $obj;
    }

    /**
     * Se encarga de buscar el controlador que necesita la vista y poner a disposicion dicha vista para que sea cargada
     * desde el template
     */
    protected  function setLoadController($librery){
        if(!isset($this->conf['controller'])){
            return null;
        }
        $infoControll = $this->getInfoFile($this->conf['controller'],"controller");
        if(is_null($infoControll)){
            return null;
        }
        include ($infoControll["path"]);

        $nameClass = $infoControll["name"];
        $obj = new $nameClass($librery);
        $obj->action();
        return $obj;
        //print_r($nameControll);
    }

    /**
     * @param $array es la variable de configuracion que el programador definio en el index de la aplicacion y que el
     *          framework se la paso en el constructor a la clase SpryFramework
     * @return $path retorna la ruta donde se encuentra el archivo
     */
    protected function getInfoFile($array, $type){
        if($this->view == "vista-default"){
            $info = array(
                'path' => __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_VIEW.'/'.'vista-default.php',
                'name' => 'vista-default'
            );
            return $info;
        }

        $path = "";
        foreach($array as $key => $val){
            if($key == $this->view){
                if($type == "controller"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_CONTROLLER.'/'.$val.'.class.php';
                }else if($type == "view"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_VIEW.'/'.$val.'.php';
                }else if($type == "model"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_MODEL.'/'.$val.'.class.php';
                }

                $info = array(
                    'path' => $path,
                    'name' => $val
                );

                if(!is_readable($path)){
                    die($type." NO encontrado");
                    //header("Location: /404");
                }else{
                    return $info;
                }
            }

            /*if($val == $this->view){
                if($type == "controller"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_CONTROLLER.'/'.$key.'.class.php';
                }else if($type == "view"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_VIEW.'/'.$key.'.php';
                }else if($type == "model"){
                    $path = __APPLICATION_PATH.'/'.__APPLICATION_FOLDER_MODEL.'/'.$key.'.class.php';
                }

                $info = array(
                    'path' => $path,
                    'name' => $key
                );

                if(!is_readable($path)){
                    //header("Location: /404");
                    return null;
                }else{
                    return $info;
                }
            }*/

        }
    }
}