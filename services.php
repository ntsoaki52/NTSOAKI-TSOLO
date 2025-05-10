<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "iwb_re"; // Replace with your DB name
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWB - Our Services</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">IWB</div>
        <nav>
            <ul>
                <li><a onclick="history.back()">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="software-tools.php">Software Tools</a></li>
                <li><a href="stakeholders.php">Stakeholders</a></li>
                <li><a href="contacts.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="services">
        <h2>Our Comprehensive Services</h2>
        <p class="services-intro">
            At IWB, we provide cutting-edge electronic recycling solutions with a focus on security and environmental responsibility. We recycle hard drives, motherboards, and rams.
        </p>

        <div class="services-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name']);
                $description = htmlspecialchars($row['description']);
                $image = htmlspecialchars($row['image_url']);
            //    $features = explode(',', $row['features']); // Example: "Secure wiping,Recycling,Reporting"
        ?>
            <div class="service-card">
                <div class="service-image">
                    <img src="<?= $image ?>" alt="<?= $name ?>">
                </div>
                <div class="service-content">
                    <h3><?= $name ?></h3>
                    <p><?= $description ?></p>
                    <ul class="service-features">
                    
                    </ul>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p style='text-align:center;'>No products available.</p>";
        }
        ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 IWB | All rights reserved</p>
    </footer>
</body>
</html>
