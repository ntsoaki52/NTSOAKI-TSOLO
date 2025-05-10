<?php
session_start();
$conn = new mysqli("localhost", "root", "", "iwb_re");

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch order history
$query = "SELECT o.order_id, o.order_date, p.name, p.image, p.price, od.quantity 
          FROM orders o
          JOIN order_details od ON o.order_id = od.order_id
          JOIN products p ON od.product_id = p.id
          WHERE o.customer_id = $customer_id
          ORDER BY o.order_date DESC";

$result = $conn->query($query);

echo "<h2>Purchase History</h2>";
$current_order = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['order_id'] != $current_order) {
        if ($current_order != 0) echo "</div>";
        $current_order = $row['order_id'];
        echo "<div style='border:1px solid black; padding:10px; margin:10px;'>";
        echo "<h3>Order #{$row['order_id']} - Date: {$row['order_date']}</h3>";
    }
    echo "<div style='margin-left: 20px;'>";
    echo "<img src='uploads/{$row['image']}' width='100' height='100' style='float:left; margin-right:10px;'>";
    echo "<strong>{$row['name']}</strong><br>";
    echo "Price: {$row['price']}<br>";
    echo "Quantity: {$row['quantity']}<br>";
    echo "<div style='clear:both;'></div></div><hr>";
}
if ($current_order != 0) echo "</div>";
?>
