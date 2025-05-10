<?php
// Database connection parameters
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

// Ensure ID is passed
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin-dashboard.php");  // Redirect to dashboard if no ID is provided
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';

    // Prepare and execute update statement
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    $stmt->execute();
    $stmt->close();

    // Redirect after successful update
    header("Location: admin-dashboard.php");
    exit;
} else {
    // Prepare statement to fetch user details
    $stmt = $conn->prepare("SELECT username, email, role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $role);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <label for="name">Username:</label><br>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="employee" <?= $role == 'employee' ? 'selected' : '' ?>>Employee</option>
            <option value="user" <?= $role == 'user' ? 'selected' : '' ?>>User</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
