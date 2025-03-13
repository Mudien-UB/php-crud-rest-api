<?php
namespace App\Repositories;
require_once __DIR__ ."/../models/Product.php";
require_once __DIR__ ."/../../config/database.php";

use Config\Database;
use App\Models\Product;
use mysqli;

class ProductRepository {
    private ?mysqli $dbConn;

    public function __construct(){
        $this->dbConn = Database::connect();
    }

    public function save(Product $product): bool {
        $stmt = $this->dbConn->prepare("INSERT INTO products (name, category, stock) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new \Exception("Prepare statement gagal: " . $this->dbConn->error);
        }

        $name = $product->getName();
        $category = $product->getCategory();
        $stock = $product->getStock();

        $stmt->bind_param("ssi", $name, $category, $stock);
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    public function findById(int $id): ?Product {
        $stmt = $this->dbConn->prepare("SELECT id, name, category, stock, created_at FROM products WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Prepare statement gagal: " . $this->dbConn->error);
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $product = null;
        if ($row = $result->fetch_assoc()) {
            $product = new Product($row['id'], $row['name'], $row['category'], $row['stock'], $row['created_at']);
        }
    
        $stmt->close();
        return $product;
    }
    

    public function findAll(): array {
        $query = "SELECT id, name, category, stock, created_at FROM products";
        $result = $this->dbConn->query($query);
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row['id'], $row['name'], $row['category'], $row['stock'], $row['created_at']);
        }
    
        return $products;
    }
    

    public function update(Product $product): bool {
        $stmt = $this->dbConn->prepare("UPDATE products SET name = ?, category = ?, stock = ? WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Prepare statement gagal: " . $this->dbConn->error);
        }

        $id = $product->getId();
        $name = $product->getName();
        $category = $product->getCategory();
        $stock = $product->getStock();

        $stmt->bind_param("ssii", $name, $category, $stock, $id);
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    public function delete(int $id): bool {
        $stmt = $this->dbConn->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Prepare statement gagal: " . $this->dbConn->error);
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }
}
