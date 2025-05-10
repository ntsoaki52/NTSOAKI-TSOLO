<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWB - Shareholder Dashboard</title>
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
            justify-content: center; /* Centered content */
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
            position: absolute; /* Absolute positioning for logo */
            left: 20px; /* Position the logo to the left */
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

        /* Dashboard Specific Styles */
        .dashboard {
            padding: 100px 50px;
            margin-top: 60px; /* Account for fixed navbar */
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
            text-align: left; /* Adjust text alignment within sections */
        }

        .dashboard-section ul {
            list-style: none;
            padding: 0;
            display: flex; /* Use flexbox to align links horizontally */
            gap: 20px; /* Space between links */
        }

        .dashboard-section ul li {
            margin-bottom: 0; /* Remove default list item margin */
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

        .dashboard-section article {
             background: #333;
             padding: 20px;
             border-radius: 5px;
             margin-top: 20px;
        }

        .dashboard-section article h3 {
            color: yellow;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .dashboard-section article p {
            color: #bbb;
            margin-bottom: 0;
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
                <li><a href="services.php">Services</a></li>
                <li><a href="stakeholders.php">Stakeholders</a></li>
                <li><a href="logout.php">Logout</a></li> <!-- Logout link -->
            </ul>
        </nav>
    </header>

    <main class="dashboard">
        <h1>Shareholder Dashboard</h1>
        <p>Welcome, Shareholder. Access information related to your investment and company performance.</p>

        <section class="dashboard-section">
            <h2>Investment Overview</h2>
           
           <p>View detailed information about your current shareholdings, historical trends, and total investment value.</p>
  <p>Number of Shares: <strong>2,500</strong></p>
  <p>Current Share Price: <strong>M12.50</strong></p>
  <p>Total Investment Value: <strong>M31,250.00</strong></p>
  <p>Investment Growth (Year-to-Date): <strong>+18.2%</strong></p>
  <p>Last Dividend Paid: <strong>M2.00/share (March 2025)</strong></p>
  <p>Next Dividend Payout Date: <strong>June 30, 2025</strong></p>
        </section>

         <section class="dashboard-section">
            <h2>Company Performance</h2>
            
             <p>Access financial reports, profitability metrics, and key performance indicators that reflect IWB’s health and growth trajectory.</p>
  <ul>
    <li><strong>Q2 2025 Revenue:</strong> M4.2 million (↑25%)</li>
    <li><strong>Net Profit:</strong> M1.1 million (↑30% from Q1)</li>
    <li><strong>Profit Margin:</strong> 26.2%</li>
    <li><strong>Return on Investment (ROI):</strong> 14.7%</li>
    <li><strong>Customer Retention Rate:</strong> 92%</li>
    <li><strong>Operational Efficiency:</strong> Improved by 12% since Q1</li>
  </ul>
        </section>

         <section class="dashboard-section">
  <h2>Shareholder Communications</h2>
  <p>Access important communications, updates from the executive team, and strategic announcements that impact your investment.</p>

  <!-- Article 1 -->
  <article>
    <h3>Shareholder Letter – Q3 2023</h3>
    <p>In this quarter’s letter, the CEO discusses our entry into new markets, financial milestones, and our continued commitment to environmental sustainability. The letter also includes insight into upcoming product development plans and strategic partnerships.</p>
    </article>

  <!-- Article 2 -->
  <article>
    <h3>Annual General Meeting (AGM) Notice – 2025</h3>
    <p>The 2025 AGM will be held on August 12th at the Maseru Convention Centre. Shareholders are encouraged to attend in person or vote electronically. Key agenda items include board member elections and dividend policy updates.</p>
 
  </article>


</section>


         <section class="dashboard-section">
            <h2>IWC Partner Information</h2>
            <p>Information relevant to IWC partners.</p>
             <ul>
                 <li><a href="view-partner-resources.php">View IWC Partner Resources</a></li>
                 <li><a href="view-compliance-documents.php">Compliance Documents</a></li>
             </ul>
        </section>
    </main>

    <footer>
        <p>© 2023 IWB. All rights reserved.</p>
    </footer>

</body>
</html>