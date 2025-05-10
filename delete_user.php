<?php
// delete_user.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iwb_re";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Invalid user ID.";
    exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin-dashboard.php");
exit;
?>
