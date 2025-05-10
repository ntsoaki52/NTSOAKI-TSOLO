<?php
session_start();

// DB config
$host = 'localhost';
$db   = 'iwb_re';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Handle add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $stmt = $pdo->prepare("INSERT INTO products (category, name, description, price, stock_quantity, recycled_percentage, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['category'], $_POST['name'], $_POST['description'],
        $_POST['price'], $_POST['stock_quantity'], $_POST['recycled_percentage'],
        $_POST['image_url']
    ]);
    header("Location: products.php");
    exit;
}

// Handle update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $stmt = $pdo->prepare("UPDATE products SET category=?, name=?, description=?, price=?, stock_quantity=?, recycled_percentage=?, image_url=? WHERE product_id=?");
    $stmt->execute([
        $_POST['category'], $_POST['name'], $_POST['description'],
        $_POST['price'], $_POST['stock_quantity'], $_POST['recycled_percentage'],
        $_POST['image_url'], $_POST['product_id']
    ]);
    header("Location: products.php");
    exit;
}

// Handle delete product
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: products.php");
    exit;
}

// Load products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get product to edit
$editProduct = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$_GET['edit']]);
    $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="css/products.css"> <!-- CSS in next section -->
</head>
<body>
    <div class="navbar">
        <div class="logo">IWB Products</div>
        <ul>
            <li><a href="sales-dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="dashboard">
        <h1><?= $editProduct ? 'Edit Product' : 'Add Product' ?></h1>

        <div class="dashboard-section">
            <form method="post">
                <?php if ($editProduct): ?>
                    <input type="hidden" name="product_id" value="<?= $editProduct['product_id'] ?>">
                <?php endif; ?>
                <label>Category:
                    <select name="category" required>
                        <option value="RAM" <?= ($editProduct['category'] ?? '') === 'RAM' ? 'selected' : '' ?>>RAM</option>
                        <option value="HDD" <?= ($editProduct['category'] ?? '') === 'HDD' ? 'selected' : '' ?>>HDD</option>
                        <option value="Motherboard" <?= ($editProduct['category'] ?? '') === 'Motherboard' ? 'selected' : '' ?>>Motherboard</option>
                    </select>
                </label>
                <label>Name:
                    <input type="text" name="name" required value="<?= $editProduct['name'] ?? '' ?>">
                </label>
                <label>Description:
                    <input type="text" name="description" required value="<?= $editProduct['description'] ?? '' ?>">
                </label>
                <label>Price:
                    <input type="number" name="price" step="0.01" required value="<?= $editProduct['price'] ?? '' ?>">
                </label>
                <label>Stock Quantity:
                    <input type="number" name="stock_quantity" required value="<?= $editProduct['stock_quantity'] ?? '' ?>">
                </label>
                <label>Recycled Percentage:
                    <input type="number" name="recycled_percentage" step="0.01" required value="<?= $editProduct['recycled_percentage'] ?? '' ?>">
                </label>
                <label>Image URL:
                    <input type="text" name="image_url" value="<?= $editProduct['image_url'] ?? '' ?>">
                </label>
                <button type="submit" name="<?= $editProduct ? 'update_product' : 'add_product' ?>">
                    <?= $editProduct ? 'Update Product' : 'Add Product' ?>
                </button>
            </form>
        </div>

        <h2>Product List</h2>
        <div class="dashboard-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Recycled %</th>
                        <th>Image</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['product_id'] ?></td>
                        <td><?= $p['category'] ?></td>
                        <td><?= $p['name'] ?></td>
                        <td><?= $p['description'] ?></td>
                        <td>M<?= $p['price'] ?></td>
                        <td><?= $p['stock_quantity'] ?></td>
                        <td><?= $p['recycled_percentage'] ?>%</td>
                        <td><?= $p['image_url'] ? "<img src='{$p['image_url']}' style='max-height:40px'>" : '' ?></td>
                        <td><?= $p['created_at'] ?></td>
                        <td>
                            <a href="?edit=<?= $p['product_id'] ?>">Edit</a> |
                            <a href="?delete=<?= $p['product_id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>&copy; <?= date('Y') ?> IWB Recycle Tech</footer>
</body>
</html>
