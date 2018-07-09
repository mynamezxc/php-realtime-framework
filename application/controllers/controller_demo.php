<?php

    class controller_demo extends ZXC_controller  implements controller {

        public function __call($name, $arguments) {
            parent::__call($name, $arguments);
        }

        public function __construct() {
            parent::__construct();
        }

        public function sayHello() {
            echo "loaded controller controller_demo function sayHello() <br>";
        }

    }