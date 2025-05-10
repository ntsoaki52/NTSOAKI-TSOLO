<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Analytics</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        canvas {
            background-color: #1e1e1e;
            border: 1px solid #333;
            margin: 20px auto;
            display: block;
            max-width: 600px;
            width: 90%;
        }
        .button-container {
            margin-top: 30px;
        }
        button {
            background-color:rgb(249, 252, 54);
            color: black;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(249, 252, 54);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <h1>Sales Analytics</h1>
    <p>Graphical sales analysis will appear here.</p>

    <canvas id="barChart"></canvas>
    <canvas id="pieChart"></canvas>
    <canvas id="lineChart"></canvas>

    <div class="button-container">
        <button onclick="history.back()">Back</button>
        <button onclick="window.location.href='download-sales-pdf.php'">Download PDF</button>
    </div>

    <?php
    // Database connection and query
    $conn = new mysqli("localhost", "root", "", "iwb_re");
    $result = $conn->query("SELECT sale_date, amount FROM sales ORDER BY sale_date ASC");

    $dates = [];
    $amounts = [];

    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['sale_date'];
        $amounts[] = $row['amount'];
    }

    // Encode PHP arrays to JSON
    $jsonDates = json_encode($dates);
    $jsonAmounts = json_encode($amounts);
    ?>

    <script>
        const saleDates = <?php echo $jsonDates; ?>;
        const saleAmounts = <?php echo $jsonAmounts; ?>;

        const configBar = {
            type: 'bar',
            data: {
                labels: saleDates,
                datasets: [{
                    label: 'Sales Amount ($)',
                    data: saleAmounts,
                    backgroundColor: '#ff4081'
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Sales Bar Chart',
                        color: 'white'
                    }
                },
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                }
            }
        };

        const configPie = {
            type: 'pie',
            data: {
                labels: saleDates,
                datasets: [{
                    label: 'Sales Distribution',
                    data: saleAmounts,
                    backgroundColor: ['#ff6384','#36a2eb','#cc65fe','#ffce56','#4bc0c0','#f44336']
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Sales Pie Chart',
                        color: 'white'
                    }
                }
            }
        };

        const configLine = {
            type: 'line',
            data: {
                labels: saleDates,
                datasets: [{
                    label: 'Sales Over Time',
                    data: saleAmounts,
                    fill: false,
                    borderColor: '#36a2eb',
                    tension: 0.1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Sales Line Graph',
                        color: 'white'
                    }
                },
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                }
            }
        };

        new Chart(document.getElementById('barChart'), configBar);
        new Chart(document.getElementById('pieChart'), configPie);
        new Chart(document.getElementById('lineChart'), configLine);
    </script>

</body>
</html>
