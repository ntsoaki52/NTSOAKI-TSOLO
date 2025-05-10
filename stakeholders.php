<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWB - Shareholders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">IWB</div>
        <nav>
            <ul>
                <li><a >Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="software-tools.php">Software Tools</a></li>
                <li><a href="stakeholders.php">Stakeholders</a></li>
                <li><a href="contacts.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Shareholders Introduction -->
    <section class="shareholders">
        <h1>Stakeholders Page</h1>
        <p>Welcome to the IWB Stakeholders Portal. Here you can find important information about our valued stakeholders, partners, and contributors.</p>
    </section>

    <!-- Partners Section -->
    <section class="partners">
        <h2>Our Partners</h2>
        <div class="partners-container">
    <div class="partner">
        <img src="images/ntsoak.webp" alt="Partner 1">
        <p><strong>NTSOAKI TSOLO</strong></p>
        <p>Ntsoaki is a skilled programmer, analyst, and designer, <br> currently pursuing a degree at Limkokwing University. <br> She specializes in system analysis, UI/UX design, and full-stack development.</p>
    </div>
    <div class="partner">
        <img src="images/ntha.jpg" alt="Partner 2">
        <p><strong>NTHATUOA TS'OLO</strong></p>
        <p>Nthatuoa is passionate about database systems and <br> cybersecurity. She brings strong analytical thinking and contributes <br> significantly to backend architecture and system security.</p>
    </div>
    <div class="partner">
        <img src="images/mona.jpg" alt="Partner 3">
        <p><strong>MONA MOILOA</strong></p>
        <p>Mona is a creative and resourceful developer with a <br> focus on frontend design and user engagement. She ensures that our <br> applications are visually appealing and user-friendly.</p>
    </div>
    <!-- Existing partners here -->
<div class="partner">
    <img src="images/masempe.jpg" alt="Partner 4">
    <p><strong>MASEMPE MAHLELEBE</strong></p>
    <p>Masempe is a systems integrator and cloud computing <br> enthusiast. She plays a key role in connecting platforms and optimizing <br> performance for scalable digital solutions.</p>
</div>

</div>

    </section>

    <footer>
        <p>© 2025 IWB | All rights reserved</p>
    </footer>

    <script>
        const contactButton = document.getElementById('contactButton');
        if (contactButton) {
            contactButton.addEventListener('click', function() {
                window.location.href = 'contacts.html';
            });
        }
    </script>
</body>
</html>
