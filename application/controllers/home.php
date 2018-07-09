<?php
    
    class home extends ZXC_controller implements controller {

        public function __call($name, $arguments) {
            parent::__call($name, $arguments);
        }

        public function __construct() {
            parent::__construct();
        }

        public function index() {
            ////////////// Controller ////////////
            $this->call->controller("controller_demo")->sayHello();
            // Or
            // $controller_demo = $this->call->controller("controller_demo");
            // $controller_demo->sayHello();

            ////////////// Model ///////////////
            $query = $this->call->model("model_demo")->demo_get_database();
            // Or
            // $model_demo = $this->call->model("model_demo");
            // $query = $model_demo->demo_get_database();
            echo $query;

            //Helper
            $this->call->helper("helper_demo");
            getShow();
        }

        public function abc() {
            echo 'a';
        }

    }