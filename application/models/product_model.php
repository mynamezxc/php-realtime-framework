<?php

    class product_model extends ZXC_model implements model {

        protected $columnIDName = "id";
        protected $tableName    = "product";
        protected $usingObjects = array("category", "product");
        protected $usingModels  = array("category_model", "product_model");
        protected $object;

        public function __construct() {
            parent::__construct();
            require_once(APPPATH . "/objects/$this->tableName" . EXT);
        }

        public function get() {
            $arrays  = $this->database->find(1);
            foreach($arrays as $array) {
                $objects[] = $this->createObject($array);                
            }
            return $objects;
        }

        public function createObject($array) {
            $this->object = new $this->tableName();
            $this->object->setID($array[$this->columnIDName]);
            $this->object->setName($array['name']);
            $this->object->setPrice($array['price']);
            $this->object->setCategoryID($array['category_id']);
            return $this->object;
        }

        public function convertObjectToArray($object) {

        }

    }