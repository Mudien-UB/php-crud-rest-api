<?php
    namespace App\Models;

    class Product{
        private $id;
        private $name;
        private $category;
        private $stock;
        private $createdAt;

        public function __construct($id, $name, $category, $stock, $createdAt){
            $this->id = $id;
            $this->name = $name;
            $this->category = $category;
            $this->stock = $stock;
            $this->createdAt = $createdAt;
        }

        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function getCategory(){
            return $this->category;
        }
        public function getStock(){
            return $this->stock;
        }
        public function getCreatedAt(){
            return $this->createdAt;
        }

        public function setName( $name){
            $this->name = $name;
        }
        public function setCategory( $category ){
            $this->category = $category;
        }
        public function setStock( $stock ){
            $this->stock = $stock;
        }

    }