<?php
// Start session and connect to database
session_start();

$host = 'localhost';
$db   = 'iwb_re'; // Replace with your actual database name
$user = 'root';          // Replace with your DB username
$pass = '';              // Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = $_POST['role'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $username = explode('@', $email)[0];

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, full_name, email, multi_factor_enabled, tenant_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $role, $full_name, $email, true, 'public']);
            $success = "Account registered successfully! <a href='login.php'>Login here</a>.";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $error = "Email or username already exists.";
            } else {
                $error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWB - Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<header class="navbar">
    <div class="logo">IWB</div>
    <nav>
        <ul>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="auth-form">
        <h1>Create an Account</h1>

        <!-- Display Success or Error -->
        <?php if ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <label for="role">Select Role:</label>
            <select id="role" name="role">
                <option value="sales">Sales</option>
                <option value="finance">Finance</option>
                <option value="customer">Customer</option>
                <option value="investor">Investor</option>
                <option value="shareholder">Shareholder</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </section>
</main>

<footer>
    <p>© 2023 IWB. All rights reserved.</p>
</footer>

</body>
</html>
