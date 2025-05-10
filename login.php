<?php
session_start();

// DB config
$host = 'localhost';
$db   = 'iwb_re'; // Replace with your DB name
$user = 'root';   // Replace with your DB user
$pass = '';       // Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mfa_code = $_POST['mfa-code'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['multi_factor_enabled']) {
            if ($mfa_code !== "123456") {
                $error = "Invalid MFA code.";
            } else {
                $_SESSION['user'] = $user;
                redirectToDashboard($user['role']);
            }
        } else {
            $_SESSION['user'] = $user;
            redirectToDashboard($user['role']);
        }
    } else {
        $error = "Invalid email or password.";
    }
}

// Role-based dashboard redirect function
function redirectToDashboard($role) {
    $dashboards = [
        'admin'     => 'admin-dashboard.php',
        'customer' => 'customer-dashboard.php',
        'finance'   => 'finance-dashboard.php',
        'investor'  => 'investor-dashboard.php',
        'sales'     => 'sales-dashboard.php',
        'shareholder' => 'shareholder-dashboard.php'
    ];

    $dashboardPage = $dashboards[strtolower($role)] ?? 'dashboard.php'; // fallback
    header("Location: $dashboardPage");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWB - Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<header class="navbar">
    <div class="logo">IWB</div>
    <nav>
        <ul>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="auth-form">
        <h1>Login to Your Account</h1>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="mfa-code">MFA Code (if enabled):</label>
            <input type="text" id="mfa-code" name="mfa-code">

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </section>
</main>

<footer>
    <p>© 2023 IWB. All rights reserved.</p>
</footer>

</body>
</html>
