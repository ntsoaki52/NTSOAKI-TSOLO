<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Sales Report</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            margin-bottom: 30px;
        }
        input[type="date"], button {
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin: 5px;
        }
        button {
            background-color:rgb(252, 255, 64);
            color: black;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: rgb(252, 255, 64);
        }
        tr:nth-child(even) {
            background-color: #1e1e1e;
        }
    </style>
</head>
<body>

<h1>Generate Custom Reports</h1>

<form method="GET">
    <label for="from">From:</label>
    <input type="date" id="from" name="from" required>
    <label for="to">To:</label>
    <input type="date" id="to" name="to" required>
    <button type="submit">Generate Report</button>
</form>

<?php
if (isset($_GET['from']) && isset($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "iwb_re");

    if ($conn->connect_error) {
        echo "<p style='color:red;'>Database connection failed.</p>";
        exit();
    }

    // Query for sales within the date range
    $stmt = $conn->prepare("SELECT sale_id, amount, sale_date FROM sales WHERE sale_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Report from $from to $to</h2>";
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Sale ID</th><th>Amount</th><th>Date</th></tr>";
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['sale_id']}</td>
                    <td>\${$row['amount']}</td>
                    <td>{$row['sale_date']}</td>
                  </tr>";
            $total += $row['amount'];
        }
        echo "<tr><th colspan='1'>Total</th><th colspan='2'>\$$total</th></tr>";
        echo "</table>";
    } else {
        echo "<p>No sales found in this date range.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
<a href="finance-dashboard.php"><button type="submit">Back</button></a>
</body>
</html>
