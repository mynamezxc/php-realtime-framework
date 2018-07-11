<?php

    class category {

        public $id;
        public $name;
        public $productList;

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
            return $this->name;
        }

        public function addProduct(product $product) {
            $this->productList[] = $product;
        }

        public function removeProduct($key) {
            unset($this->productList[$key]);
        }

        public function getProductList() {
            $productModel = new product_model();
            $productList  = $productModel->database->fetchAll("category_id = $this->id");
            foreach($productList as $product) {
                $this->productList[] = $productModel->createObject($product);
            }
            return $this->productList;
        }
    }