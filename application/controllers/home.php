<?php
    
    class home extends ZXC_controller implements controller {

        public function __call($name, $arguments) {
            parent::__call($name, $arguments);
        }

        public function __construct() {
            parent::__construct();
        }

        public function index() {
            $this->call->controller("controller_demo")->sayHello();
            $this->call->model("model_demo")->
            $this->call->helper("helper_demo");
            getShow();
        }

        public function abc() {
            echo 'a';
        }

    }