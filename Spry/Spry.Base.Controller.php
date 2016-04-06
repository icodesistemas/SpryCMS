<?php
    Abstract Class SpryController {

        private $librery;
        private $model;
        abstract public function action();

        function __construct($librery){
            $this->librery = $librery;
            $this->model = $librery->Model;

            unset($this->librery->Model);
        }

        protected  function Component(){
            return $this->librery;
        }
        protected function Model(){
          return $this->model;
        }
    }