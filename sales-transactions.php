<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Transactions</title>
    <style>
        body {
            background-color: #1e1e1e;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
        }
        h1 {
            color:rgb(234, 244, 34);
        }
        ul {
            list-style-type: square;
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .button-group {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            margin-right: 10px;
            background-color:rgb(234, 244, 34);
            border: none;
            color: black;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-weight: bold;
        }
        .btn:hover {
            background-color:rgb(234, 244, 34);
        }
    </style>
</head>
<body>
    <h1>Sales Transactions</h1>
    <p>Below are recent transactions:</p>
    <ul>
        <?php
        $conn = new mysqli("localhost", "root", "", "iwb_re");
        if ($conn->connect_error) {
            echo "<li>Connection failed: " . $conn->connect_error . "</li>";
        } else {
            $result = $conn->query("SELECT sale_id, amount, sale_date FROM sales");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>Order #{$row['sale_id']} - \${$row['amount']} - {$row['sale_date']}</li>";
                }
            } else {
                echo "<li>No sales records found.</li>";
            }
        }
        ?>
    </ul>

    <div class="button-group">
        <button class="btn" onclick="history.back()">← Back</button>
        <a class="btn" href="download-sales-pdf.php" target="_blank">📄 Download PDF</a>
    </div>
</body>
</html>
