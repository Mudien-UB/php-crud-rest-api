<?php
namespace App\Controllers;
require_once __DIR__ . '/../services/ProductService.php';

use App\Services\ProductService;
use Exception;

class ProductController {
    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
    }

    public function addProduct() {
        try {
            $name = $_POST['name'] ?? null;
            $category = $_POST['category'] ?? null;
            $stock = $_POST['stock'] ?? null;

            if (!$name || !$category || $stock === null) {
                throw new Exception("Invalid input data");
            }

            $this->productService->addProduct($name, $category, $stock);
            echo json_encode(["message" => "Product added successfully"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function updateProduct() {
        try {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? null;
            $category = $_POST['category'] ?? null;
            $stock = $_POST['stock'] ?? null;

            if (!$id) {
                throw new Exception("Product ID is required");
            }

            $this->productService->updateProduct($id, $name, $category, $stock);
            echo json_encode(["message" => "Product updated successfully"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function deleteProduct() {
        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new Exception("Product ID is required");
            }

            $this->productService->deleteProduct($id);
            echo json_encode(["message" => "Product deleted successfully"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function getAllProducts() {
        try {
            $products = $this->productService->getAllProducts();
    
            // Ubah objek Product menjadi array
            $productsArray = array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'category' => $product->getCategory(),
                    'stock' => $product->getStock(),
                    'created_at' => $product->getCreatedAt(),
                ];
            }, $products);
    
            return json_encode($productsArray);
        } catch (Exception $e) {
            http_response_code(400);
            return json_encode(["error" => $e->getMessage()]);
        }
    }
    
    

    public function getProductById() {
        try {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                throw new Exception("Product ID is required");
            }

            $product = $this->productService->getProductById($id);
            echo json_encode($product);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
