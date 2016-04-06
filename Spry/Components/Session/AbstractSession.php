<?php
/**
 * Created by PhpStorm.
 * User: abejarano
 * Date: 26-Mar-16
 * Time: 2:13 AM
 */


require_once 'InterfaceSession.php';

Abstract class AbstractSession implements InterfaceSession{
    private $DB;
    private $Fun;
    abstract public function action();

    function __construct($Librery){
        $this->DB = $Librery->DB;
        $this->Fun = $Librery->Functions;
    }
    public function DB(){
        return $this->DB;
    }
    public function Functions(){
        return $this->Fun;
    }
    public function setRedirect($http){
        header('Location: '.$http);
    }
}