<?php
namespace Routes;

require_once __DIR__ . '/../app/controllers/ProductController.php';

use App\Controllers\ProductController;

class Router {
    private $routes = [];

    public function __construct() {
        $productController = new ProductController();

        $this->routes = [
            'POST' => [
                '/api/products/add' => [$productController, 'addProduct'],
            ],
            'GET' => [
                '/api/products' => [$productController, 'getAllProducts']
            ],
            'PUT' => [
                '/api/products/update' => [$productController, 'updateProduct']
            ],
            'DELETE' => [
                '/api/products/delete' => [$productController, 'deleteProduct']
            ]
        ];
    }

    public function run() {
        header('Content-Type: application/json');

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$requestMethod][$path])) {
            $handler = $this->routes[$requestMethod][$path];

            // Menangani input body untuk metode selain GET
            if (in_array($requestMethod, ['POST', 'PUT', 'DELETE'])) {
                $inputData = json_decode(file_get_contents("php://input"), true);
                call_user_func($handler, $inputData);
            } else {
                call_user_func($handler);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
    }
}
