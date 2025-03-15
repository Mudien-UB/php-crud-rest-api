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
                '/api/products/delete' => [$productController, 'deleteProduct'],
                '/api/products/update' => [$productController, 'updateProduct']
            ],
            'GET' => [
                '/api/products' => [$productController, 'getAllProducts']
            ]
        ];
    }

    public function run() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$requestMethod][$path])) {
            call_user_func($this->routes[$requestMethod][$path]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
    }
}
