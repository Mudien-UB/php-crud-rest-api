<?php
    namespace App\Services;
    require_once __DIR__ ."/../models/Product.php";
    require_once __DIR__ ."/../repositories/ProductRepository.php";

    use App\Models\Product;
    use App\Repositories\ProductRepository;

    class ProductService{

        private $productRepository;

        public function __construct(){
            $this->productRepository = new ProductRepository();
        }
        
        public function addProduct ($name, $category, $stock){
            $product = new Product(null, $name, $category, $stock, null);
            $this->productRepository->save($product);
        }
        public function updateProduct ($id, $newName, $newCategory, $newStock){
            $product = $this->productRepository->findById($id);
            if(empty($product)){
                throw new \Exception("Product not found");
            }
            $product->setName(($newName === null ) ? $product->getName() : $newName);
            $product->setCategory(($newCategory === null ) ? $product->getCategory() : $newCategory);
            $product->setStock(($newStock === null ) ? $product->getStock() : $newStock);
            $this->productRepository->update($product);
        }
        public function deleteProduct($id){
            $product = $this->productRepository->findById($id);
            if( $product ){
                $this->productRepository->delete($id);
            }else{
                throw new \Exception("Product not found");
            }
        }
        public function getAllProducts(){
            return $this->productRepository->findAll();
        }
        public function getProductById($id){
            return $this->productRepository->findById($id);
        }


    }