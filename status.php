<?php
$host = "localhost";
$user = "root";       // default XAMPP username
$password = "";       // default XAMPP password is empty
$database = "ibw_re"; // your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Example query to fetch system status
$sql = "SELECT * FROM system_status";
$result = $conn->query($sql);

// Display the results
if ($result->num_rows > 0) {
  echo "<h2>System Components Status:</h2><ul>";
  while($row = $result->fetch_assoc()) {
    echo "<li><strong>" . $row["component_name"] . "</strong>: " . $row["status"] . " (Updated: " . $row["last_updated"] . ")</li>";
  }
  echo "</ul>";
} else {
  echo "No system status data found.";
}

$conn->close();
?>
