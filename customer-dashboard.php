<?php  
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (isset($_SESSION['customer_id']) && isset($_SESSION['email'])) {
    $customer_id = $_SESSION['customer_id'];
    $email = $_SESSION['email'];
    $is_logged_in = true; // Set this flag if the user is logged in
} else {
    $is_logged_in = false;
    $message = "You are not logged in.";
}

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize cart in session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] === $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = ['product_id' => $product_id, 'quantity' => $quantity];
    }

    $message = "Product added to cart!";
}

// Handle Checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    // Proceed with checkout if the user is logged in
    if (!empty($_SESSION['cart'])) {
        if (!$is_logged_in) {
            die("Error: User is not logged in. Session customer_id is not set.");
        }

        // Collect additional details for the checkout
        $payment_method = sanitize($_POST['payment_method']);
        $shipping_address = sanitize($_POST['shipping_address']);
        $order_status = "Pending"; // You can update this later based on the payment status
        
        foreach ($_SESSION['cart'] as $item) {
            if (is_array($item) && isset($item['product_id'], $item['quantity'])) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];

                // Fetch product details
                $stmt = $conn->prepare("SELECT price, stock_quantity, description FROM products WHERE product_id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();

                if ($product && $product['stock_quantity'] >= $quantity) {
                    $price = $product['price'];
                    $amount = $price * $quantity;

                    // Update stock quantity
                    $update = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
                    $update->bind_param("ii", $quantity, $product_id);
                    $update->execute();

                    // Record sale in the sales table with additional information
                    $sale = $conn->prepare("INSERT INTO sales (user_id, product_id, quantity, amount, customer_email, payment_method, shipping_address, order_status, sale_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $sale->bind_param("iiids", $_SESSION['customer_id'], $product_id, $quantity, $amount, $_SESSION['email'], $payment_method, $shipping_address, $order_status);
                    $sale->execute();
                } else {
                    $message = "Insufficient stock for product ID: $product_id";
                }
            }
        }

        // Clear cart after successful checkout and update message
        $_SESSION['cart'] = [];
        $message = "Checkout successful! Thank you for your purchase.";
    } else {
        $message = "Your cart is empty.";
    }
}

$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

// Hardcoded purchase history (static data)
$purchase_history = [
    [
        'product_name' => 'RAM Recycled',
        'quantity' => 1,
        'amount' => 2500.00,
        'payment_method' => 'Credit Card',
        'shipping_address' => '123 TeyaTeyaneng, Berea, Lesotho',
        'order_status' => 'Completed',
        'sale_date' => '2025-04-25'
    ],
    [
        'product_name' => 'Hard Drive - Samsung',
        'quantity' => 2,
        'amount' => 1800.00,
        'payment_method' => 'Cash',
        'shipping_address' => '456 Oak Rd, Pretoria, South Africa',
        'order_status' => 'Shipped',
        'sale_date' => '2025-03-15'
    ],
    [
        'product_name' => 'Motherboard',
        'quantity' => 1,
        'amount' => 1500.00,
        'payment_method' => 'Credit Card',
        'shipping_address' => '789 Hatsolo, Maseru, Lesotho',
        'order_status' => 'Pending',
        'sale_date' => '2025-05-05'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="css/customer.css">
    <style>
        img.product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        #purchase-history {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<div class="navbar">
    <div class="logo">IWB Store</div>
    <ul>
        <li><a href="customer-dashboard.php">Dashboard</a></li>
        <li><a href="#purchase-history">Purchase History</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="dashboard">
    <h1>Welcome to the Customer Dashboard</h1>
    <p>Browse and purchase our recycled tech products!</p>

    <?php if (isset($message)): ?>
        <p style="color: yellow;"><?php echo sanitize($message); ?></p>
    <?php endif; ?>

    <div class="dashboard-section">
        <h2>Available Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price (M)</th>
                    <th>Recycled (%)</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Cart</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($products->num_rows > 0): ?>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?php echo sanitize($row['image_url']); ?>" class="product-img"></td>
                            <td><?php echo sanitize($row['category']); ?></td>
                            <td><?php echo sanitize($row['name']); ?></td>
                            <td><?php echo sanitize($row['description']); ?></td>
                            <td>M <?php echo sanitize($row['price']); ?></td>
                            <td><?php echo sanitize($row['recycled_percentage']); ?>%</td>
                            <td><?php echo sanitize($row['stock_quantity']); ?></td>
                            <td colspan="2">
                                <form method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['stock_quantity']; ?>" style="width: 50px;">
                                    <button type="submit" name="add_to_cart">Add to Cart</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9">No products available.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="dashboard-section">
        <h2>Your Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <form method="POST">
                <ul>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item):
                        $product_id = $item['product_id'];
                        $quantity = $item['quantity'];

                        $result = $conn->query("SELECT name, price FROM products WHERE product_id = $product_id");
                        if ($result && $result->num_rows > 0):
                            $prod = $result->fetch_assoc();
                            $subtotal = $prod['price'] * $quantity;
                            $total += $subtotal;
                    ?>
                        <li><?php echo sanitize($prod['name']); ?> × <?php echo $quantity; ?> = M<?php echo number_format($subtotal, 2); ?></li>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
                <p><strong>Total: M<?php echo number_format($total, 2); ?></strong></p>
                
                <h3>Checkout Information</h3>
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Cash">Cash</option>
                </select>
                <br>

                <label for="shipping_address">Shipping Address:</label>
                <textarea name="shipping_address" required></textarea>
                <br>

                <button type="submit" name="checkout">Checkout</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <?php if ($is_logged_in): ?>
        <div class="dashboard-section" id="purchase-history">
            <h2>Purchase History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount (M)</th>
                        <th>Payment Method</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchase_history as $history_item): ?>
                        <tr>
                            <td><?php echo sanitize($history_item['product_name']); ?></td>
                            <td><?php echo $history_item['quantity']; ?></td>
                            <td>M <?php echo number_format($history_item['amount'], 2); ?></td>
                            <td><?php echo sanitize($history_item['payment_method']); ?></td>
                            <td><?php echo sanitize($history_item['shipping_address']); ?></td>
                            <td><?php echo sanitize($history_item['order_status']); ?></td>
                            <td><?php echo sanitize($history_item['sale_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
