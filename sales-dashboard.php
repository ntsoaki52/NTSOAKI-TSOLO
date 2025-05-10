<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle date filter input
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = "";
if ($start_date && $end_date) {
    $where = "WHERE s.sale_date BETWEEN '$start_date' AND '$end_date'";
}

// Sales history (last 5 filtered)
$sales_sql = "SELECT s.sale_date, p.name, p.price 
              FROM sales s
              JOIN products p ON s.product_id = p.product_id
              $where
              ORDER BY s.sale_date DESC
              LIMIT 5";
$sales_result = $conn->query($sales_sql);

// Total income summary
$income_sql = "SELECT SUM(p.price) as total_income
               FROM sales s
               JOIN products p ON s.product_id = p.product_id
               $where";
$income_result = $conn->query($income_sql);
$total_income = $income_result->fetch_assoc()['total_income'] ?? 0;

// Category-wise sales breakdown
$category_sql = "SELECT p.category, COUNT(s.sale_id) AS count
                 FROM sales s
                 JOIN products p ON s.product_id = p.product_id
                 $where
                 GROUP BY p.category";
$cat_result = $conn->query($category_sql);

$cat_labels = [];
$cat_data = [];
while ($row = $cat_result->fetch_assoc()) {
    $cat_labels[] = $row['category'];
    $cat_data[] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>IWB - Sales Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/sales.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header class="navbar">
  <div class="logo">IWB</div>
  <nav>
    <ul>
      <li><a href="software-tools.php">Tools</a></li>
      <li><a href="stakeholders.php">Stakeholders</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="dashboard">
  <h1>Sales Dashboard</h1>

  <!-- Filter -->
  <section class="dashboard-section">
    <h2>Filter Sales by Date</h2>
    <form method="get">
      <label>Start Date: <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>"></label>
      <label>End Date: <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>"></label>
      <button type="submit">Filter</button>
    </form>
  </section>

  <!-- Total Income Summary -->
  <section class="dashboard-section">
    <h2>Total Income</h2>
    <p><strong>M<?= number_format($total_income, 2) ?></strong> from selected period.</p>
  </section>

  <!-- Sales History -->
  <section class="dashboard-section">
    <h2>Recent Sales (Filtered)</h2>
    <table>
      <thead>
        <tr><th>Date</th><th>Product</th><th>Amount (M)</th></tr>
      </thead>
      <tbody>
        <?php
        if ($sales_result->num_rows > 0) {
          while ($row = $sales_result->fetch_assoc()) {
            echo "<tr><td>{$row['sale_date']}</td><td>{$row['name']}</td><td>{$row['price']}</td></tr>";
          }
        } else {
          echo "<tr><td colspan='3'>No sales found for selected dates.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </section>

  <!-- Category Breakdown Chart -->
  <section class="chart-container">
    <h2>Category Breakdown</h2>
    <p>See how different categories perform over the selected period.</p>
    <canvas id="categoryChart"></canvas>
  </section>
</main>

<footer>
  <p>© 2023 IWB. All rights reserved.</p>
</footer>

<script>
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode($cat_labels) ?>,
        datasets: [{
            label: 'Category Sales',
            data: <?= json_encode($cat_data) ?>,
            backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
</body>
</html>
