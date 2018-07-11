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
            $categories = $this->call->model("category_model")->getAll();
            $categories[0]->getProductList();
            var_dump($categories[0]->productList);
            // Or
            // $model_demo = $this->call->model("model_demo");
            // $demos = $model_demo->getAll();
            // demos is an arrays object
            

            ///////////// Helper ///////////////
            $this->call->helper("helper_demo");
            getShow();
        }

        public function abc() {
            echo 'a';
        }

    }