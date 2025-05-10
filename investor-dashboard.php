<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>IWB - Investor Dashboard</title>
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

/* Main Content */
.main {
  padding: 100px 50px;
  margin-top: 60px; /* space for fixed navbar */
}
h1 {
  font-size: 36px;
  color: yellow;
  margin-bottom: 20px;
  text-align: center;
}
p {
  font-size: 18px;
  color: #bbb;
  text-align: center;
  margin-bottom: 30px;
}

/* Sections */
.dashboard-section {
  background: #222;
  padding: 30px;
  border-radius: 8px;
  margin-bottom: 30px;
}
.dashboard-section h2 {
  font-size: 28px;
  color: yellow;
  margin-bottom: 15px;
}
.dashboard-section p {
  margin-bottom: 15px;
}
.dashboard-section ul {
  list-style: none;
  padding: 0;
  display: flex;
  gap: 20px;
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
/* Placeholder for company news/articles */
.article {
  background: #333;
  padding: 15px;
  border-radius: 5px;
  margin-top: 10px;
}
.article h3 {
  margin-top: 0;
  color: yellow;
}
.article p {
  margin: 0;
  color: #bbb;
}

/* Footer styling */
footer {
  background: #111;
  padding: 30px;
  text-align: center;
  margin-top: 60px;
  color: white;
}

/* Responsive styles */
@media(max-width: 768px){
  .main {
    padding: 50px 20px;
  }
  .navbar ul {
    flex-wrap: wrap;
    justify-content: center;
  }
}
</style>
</head>
<body>

<!-- Navigation -->
<header class="navbar">
  <div class="logo">IWB</div>
  <nav>
    <ul>
      <li><a href="services.php">Services</a></li>
      <li><a href="stakeholders.php">Stakeholders</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Main Content -->
<div class="main">
  <h1>Investor Dashboard</h1>
  <p>Welcome, Investor. Access financial performance and company updates.</p>

  <!-- Financial Performance Section -->
  <section class="dashboard-section">
    <h2>Financial Performance</h2>
    <p>View key financial metrics and reports.</p>
    <ul>
    <li><a href="sales-transactions.php">View Sales Transactions</a></li>
    <li><a href="sales-analytics.php">Sales Analytics</a></li>
    </ul>
  </section>
<!-- Company News & Updates -->
<section class="dashboard-section">
  <h2>Company News & Updates</h2>
  <p>Stay informed about IWB's latest achievements, strategic moves, and industry highlights.</p>

  <!-- Article 1 -->
  <div class="article">
    <h3>Q2 2025 Revenue Surges</h3>
    <p>IWB has experienced a 25% increase in revenue compared to last quarter, driven by new recycling contracts with government and corporate partners. This marks the company’s fifth consecutive quarter of growth.</p>
  </div>

  <!-- Article 2 -->
  <div class="article">
    <h3>Expansion into Regional Markets</h3>
    <p>Plans are underway to expand recycling operations into neighboring countries such as South Africa and Botswana. Market research teams are already conducting feasibility studies to ensure a smooth entry.</p>
  </div>

  <!-- Article 3 -->
  <div class="article">
    <h3>Launch of New E-Waste Collection Program</h3>
    <p>Starting July 2025, IWB will roll out a new initiative to collect electronic waste directly from households in Maseru. This program aims to reduce landfill waste and improve community engagement.</p>
  </div>

  <!-- Article 4 -->
  <div class="article">
    <h3>IWB Wins Sustainability Award</h3>
    <p>IWB has been recognized with the 2025 GreenTech Sustainability Award for its innovative recycling processes and commitment to environmental responsibility across Southern Africa.</p>
  </div>

  <!-- Article 5 -->
  <div class="article">
    <h3>Employee Upskilling Program Announced</h3>
    <p>To enhance workforce capabilities, IWB is launching a training and development program focused on emerging recycling technologies and sustainable practices. The first cohort begins training in August.</p>
  </div>
</section>


<!-- Footer -->
<footer>
  <p>© 2023 IWB. All rights reserved.</p>
</footer>

<!-- Optional: Include Chart.js for chart visualization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Example: You can add dynamic chart code here later
</script>

</body>
</html>