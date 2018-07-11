<?php

    class category_model extends ZXC_model implements model {

        protected $columnIDName = "id";
        protected $tableName    = "category";
        protected $usingObjects = array("category", "product");
        protected $usingModels  = array("category_model", "product_model");
        protected $object;

        public function __construct() {
            parent::__construct();
        }

        public function getAll() {
            $arrays  = $this->database->fetchAll();
            foreach($arrays as $array) {
                $objects[] = $this->createObject($array);
            }
            return $objects;
        }

        public function createObject($array) {
            $this->object = new $this->tableName();
            $this->object->setID($array[$this->columnIDName]);
            $this->object->setName($array['name']);
            return $this->object;
        }

        public function convertObjectToArray($object) {

        }

    }