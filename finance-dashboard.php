<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IWB - Finance Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0F0F0F;
      color: white;
      margin: 0;
      padding: 0;
      line-height: 1.6;
    }

    /* Navigation Bar */
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

    /* Dashboard */
    .dashboard {
      padding: 100px 50px;
      margin-top: 60px;
    }

    .dashboard h1 {
      font-size: 36px;
      color: yellow;
      margin-bottom: 30px;
      text-align: center;
    }

    .dashboard p {
      color: #bbb;
      font-size: 18px;
      text-align: center;
      margin-bottom: 40px;
    }

    .dashboard-section {
      background: #222;
      padding: 30px;
      border-radius: 8px;
      margin-bottom: 30px;
    }

    .dashboard-section h2 {
      font-size: 28px;
      color: yellow;
      margin-bottom: 20px;
    }

    .dashboard-section p {
      color: #bbb;
      margin-bottom: 15px;
      text-align: left;
    }

    .dashboard-section ul {
      list-style: none;
      padding: 0;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .dashboard-section ul li a {
      color: yellow;
      text-decoration: none;
      font-size: 16px;
      transition: 0.3s;
    }

    .dashboard-section ul li a:hover {
      text-decoration: underline;
      color: orange;
    }

    /* Footer */
    footer {
      background: #111;
      padding: 30px;
      text-align: center;
      margin-top: 60px;
      color: white;
    }
  </style>
</head>
<body>

  <header class="navbar">
    <div class="logo">IWB</div>
    <nav>
      <ul>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="dashboard">
    <h1>Finance Dashboard</h1>
    <p>Welcome, Finance User. Access financial reports and manage financial data.</p>

    <!-- Income Statement Section -->
    <section class="dashboard-section">
      <h2>Income Statements</h2>
      <p>View and generate monthly income statements.</p>
      <ul>
        <li><a href="custom-reports.php">Generate Custom Reports</a></li>
      </ul>
    </section>

    <!-- Sales Data Section -->
    <section class="dashboard-section">
      <h2>Sales Data</h2>
      <p>Access detailed sales records and analytics.</p>
      <ul>
        <li><a href="sales-transactions.php">View Sales Transactions</a></li>
        <li><a href="sales-analytics.php">Sales Analytics</a></li>
      </ul>
    </section>
  </main>

  <footer>
    <p>© 2023 IWB. All rights reserved.</p>
  </footer>

</body>
</html>
