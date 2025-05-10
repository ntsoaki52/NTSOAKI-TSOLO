<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "iwb_re"; // Make sure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion of users
if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $delete_user_sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_user_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle deletion of queries
if (isset($_GET['delete_query'])) {
    $query_id = intval($_GET['delete_query']);
    $delete_query_sql = "DELETE FROM queries WHERE id = ?";
    $stmt = $conn->prepare($delete_query_sql);
    $stmt->bind_param("i", $query_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch users from the database
$user_sql = "SELECT user_id, username, email, role FROM users";
$user_result = $conn->query($user_sql);

// Fetch queries from the database
$query_sql = "SELECT id, query_text, status FROM queries";
$query_result = $conn->query($query_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>IWB - Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0F0F0F;
      color: white;
      margin: 0;
      padding: 0;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background: #111;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }
    .navbar .logo {
      font-size: 24px;
      font-weight: bold;
      color: yellow;
      position: absolute;
      left: 20px;
    }
    .navbar ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }
    .navbar ul li a {
      text-decoration: none;
      color: white;
      font-size: 16px;
      transition: 0.3s;
    }
    .navbar ul li a:hover {
      color: yellow;
    }
    .dashboard {
      padding: 100px 50px;
    }
    .dashboard h1 {
      font-size: 36px;
      color: yellow;
      text-align: center;
    }
    .dashboard p {
      color: #bbb;
      text-align: center;
      font-size: 18px;
    }
    .dashboard-section {
      background: #222;
      padding: 30px;
      border-radius: 8px;
      margin: 30px 0;
    }
    .dashboard-section h2 {
      font-size: 28px;
      color: yellow;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #111;
      color: white;
    }
    table th, table td {
      padding: 10px;
      border: 1px solid #444;
      text-align: left;
    }
    table th {
      background: #333;
      color: yellow;
    }
    table tr:hover {
      background: #1e1e1e;
    }
    .action-links a {
      color: yellow;
      text-decoration: none;
      margin: 0 5px;
      transition: color 0.3s;
    }
    .action-links a:hover {
      color: white;
    }
    footer {
      background: #111;
      padding: 30px;
      text-align: center;
      color: white;
      margin-top: 60px;
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="logo">IWB</div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="software-tools.php">Tools</a></li>
      <li><a href="stakeholders.php">Stakeholders</a></li>
      <li><a href="contacts.php">Contact</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="dashboard">
  <h1>Admin Dashboard</h1>
  <p>Welcome, Admin User. This is your central hub for managing the IWB platform.</p>

  <!-- User Management Section -->
  <section class="dashboard-section">
    <h2>User Management</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $user_result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['user_id']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td class="action-links">
            <a href="edit-user.php?id=<?= $row['user_id'] ?>">Edit</a> |
            <a href="?delete_user=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </section>

  <!-- Query Management Section -->
  <section class="dashboard-section">
    <h2>Query Management</h2>
    <table>
      <tr>
        <th>Query ID</th>
        <th>Query Content</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $query_result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['query_text']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td class="action-links">
            <a href="respond-query.php?id=<?= $row['id'] ?>">Respond</a> |
            <a href="?delete_query=<?= $row['id'] ?>" onclick="return confirm('Delete this query?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </section>
</main>

<footer>
  <p>© <?= date('Y') ?> IWB. All rights reserved.</p>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
