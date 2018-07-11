<?php

    class product {

        public $id;
        public $name;
        public $price;
        public $categoryID;

        public function setID($id) {
            $this->id = $id;
        }

        public function getID() {
            return $this->id;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function getName() {
            return $name;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function getPrice() {
            return $price;
        }

        public function setCategoryID($categoryID) {
            $this->categoryID = $categoryID;
        }

        public function getCategoryID() {
            return $this->categoryID;
        }
    }