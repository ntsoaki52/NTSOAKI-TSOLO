<?php
$host = "localhost";
$user = "root";
$password = ""; // XAMPP default password is empty
$database = "iwb_re"; // Change this to match your actual database name

$conn = new mysqli($host, $user, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
