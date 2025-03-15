<?php
namespace App\Controllers;

require_once __DIR__ . '/../services/ProductService.php';

use App\Services\ProductService;
use Exception;

class ProductController {
    private $productService;

    public function __construct(){
        $this->productService = new ProductService();
    }

    private function getJsonRequestBody() {
        $json = file_get_contents("php://input");
        return json_decode($json, true) ?? [];
    }

    private function sendJsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function addProduct(){
        try {
            $data = $this->getJsonRequestBody();
            $name = $data['name'] ?? null;
            $category = $data['category'] ?? null;
            $stock = $data['stock'] ?? null;

            if (empty($name) || empty($category) || empty($stock)) {
                throw new Exception('Invalid input data');
            }

            $this->productService->addProduct($name, $category, $stock);

            $this->sendJsonResponse(['message' => 'Product added successfully']);
        } catch (\Throwable $th) {
            $this->sendJsonResponse(['error' => $th->getMessage()], 400);
        }
    }

    public function deleteProduct(){
        try {
            $data = $this->getJsonRequestBody();
            $idProduct = $data['id'] ?? null;

            if (empty($idProduct)) {
                throw new Exception('Product ID is required');
            }

            $this->productService->deleteProduct($idProduct);

            $this->sendJsonResponse(['message' => 'Product deleted successfully']);
        } catch (\Throwable $th) {
            $this->sendJsonResponse(['error' => $th->getMessage()], 400);
        }
    }

    public function updateProduct(){
        try {
            $data = $this->getJsonRequestBody();
            $idProduct = $data['id'] ?? null;
            $name = $data['name'] ?? null;
            $category = $data['category'] ?? null;
            $stock = $data['stock'] ?? null;

            if (empty($idProduct)) {
                throw new Exception('Product ID is required');
            }

            $this->productService->updateProduct($idProduct, $name, $category, $stock);

            $this->sendJsonResponse(['message' => 'Product updated successfully']);
        } catch (\Throwable $th) {
            $this->sendJsonResponse(['error' => $th->getMessage()], 400);
        }
    }

    public function getAllProducts(){
        try {
            $products = $this->productService->getAllProducts();
            $this->sendJsonResponse($products);
        } catch (\Throwable $th) {
            $this->sendJsonResponse(['error' => $th->getMessage()], 400);
        }
    }
}
?>
