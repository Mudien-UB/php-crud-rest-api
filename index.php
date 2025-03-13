<?php
require_once __DIR__ . '/app/controllers/ProductController.php';

use App\Controllers\ProductController;

$controller = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->addProduct();
}

// Ambil data produk dari controller
$productsJson = $controller->getAllProducts();
$products = json_decode($productsJson, true); // Ubah JSON menjadi array

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
</head>
<body>
    <h1>Product Management</h1>

    <!-- Form Tambah Produk -->
    <h2>Add Product</h2>
    <form action="" method="post">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>
        
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <button type="submit">Add Product</button>
    </form>

    <!-- Menampilkan Daftar Produk -->
    <h2>Product List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Stock</th>
        </tr>
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['stock']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">No products available</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
