<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iwb_re";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the query ID from the URL
if (isset($_GET['id'])) {
    $query_id = intval($_GET['id']);

    // Fetch the query details
    $stmt = $conn->prepare("SELECT id, query_text, response, status FROM queries WHERE id = ?");
    $stmt->bind_param("i", $query_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $query = $result->fetch_assoc();
    $stmt->close();

    if (!$query) {
        echo "Query not found.";
        exit();
    }
} else {
    echo "Invalid query ID.";
    exit();
}

// Handle form submission to update query
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $_POST['response'];
    $status = $_POST['status'];

    $update_stmt = $conn->prepare("UPDATE queries SET response = ?, status = ? WHERE id = ?");
    $update_stmt->bind_param("ssi", $response, $status, $query_id);
    $update_stmt->execute();
    $update_stmt->close();

    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Respond to Query</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0F0F0F;
      color: white;
      padding: 40px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #222;
      padding: 30px;
      border-radius: 10px;
    }
    h2 {
      color: yellow;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    textarea, select {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      margin-top: 5px;
      background: #333;
      color: white;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      border: none;
      background: yellow;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: white;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      color: yellow;
      text-decoration: none;
    }
    a:hover {
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Respond to Query #<?= htmlspecialchars($query['id']) ?></h2>

    <form method="POST">
      <label for="query_text">Query Text:</label>
      <textarea id="query_text" rows="4" disabled><?= htmlspecialchars($query['query_text']) ?></textarea>

      <label for="response">Your Response:</label>
      <textarea name="response" id="response" rows="4" required><?= htmlspecialchars($query['response']) ?></textarea>

      <label for="status">Status:</label>
      <select name="status" id="status" required>
        <option value="pending" <?= $query['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="resolved" <?= $query['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
      </select>

      <button type="submit">Submit Response</button>
    </form>

    <a href="admin-dashboard.php">← Back to Dashboard</a>
  </div>
</body>
</html>

<?php
$conn->close();
?>
