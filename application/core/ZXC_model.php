<?php

    class ZXC_model {

        public $database;

        public function __construct() {
            $this->database = new database();
        }

    }

    class database {

        public $query = array();

        public function get($data = null) {
            if(is_array($data)) {
                foreach($data as $count => $colum) {
                    if($count == 0) {
                        $this->query['get'] = "SELECT " . $colum;
                    } else {
                        $this->query['get'] .= ", " . $colum;
                    }
                }
            } else {
                $this->query['get'] = $data;
            }
        }

        public function where($data = null) {
            
        }

        public function build_query() {
            return implode(' ', $this->query);
        }

    }