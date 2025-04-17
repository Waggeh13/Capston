<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/patient_dashboard.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Welcome to BafrowCare</title>
</head>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        color: #333;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: #0054A6; /* Dark blue from BafrowCare site */
        color: #fff;
    }
    .header .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .header .logo i {
        font-size: 24px;
    }
    .header .logo span {
        font-size: 20px;
        font-weight: bold;
    }
    .header .login-btn {
        padding: 10px 20px;
        background-color: #0054A6;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .header .login-btn:hover {
        background-color: red;
    }
    .hero {
        background-color: #f5f5f5;
        padding: 50px 20px;
        text-align: center;
    }
    .hero h1 {
        font-size: 36px;
        color: #0054A6;
        margin-bottom: 20px;
    }
    .hero p {
        font-size: 18px;
        max-width: 800px;
        margin: 0 auto 30px;
    }
    .hero .cta-btn {
        padding: 12px 30px;
        background-color: #0054A6;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-size: 16px;
    }
    .hero .cta-btn:hover {
        background-color: red;
    }
    .mission-section {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 50px 20px;
        background-color: #fff;
        gap: 20px;
    }
    .mission-section .text {
        max-width: 600px;
    }
    .mission-section .text h2 {
        font-size: 28px;
        color: #0054A6;
        margin-bottom: 15px;
    }
    .mission-section .text p {
        font-size: 16px;
        line-height: 1.6;
    }
    .mission-section .image {
        max-width: 400px;
    }
    .mission-section .image img {
        width: 100%;
        border-radius: 8px;
    }
    .footer {
        background-color: #0054A6;
        color: #fff;
        padding: 20px;
        text-align: center;
    }
    .footer .contact-details {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 15px;
    }
    .footer .contact-details div {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .footer .contact-details i {
        color: red; 
    }
    .footer .copyright {
        font-size: 14px;
    }
    .care-red {
    color: red;
    }
</style>
<body>
    <div class="header">
        <div class="logo">
            <i class="fas fa-clinic-medical"></i>
            <span>BafrowCare</span>
        </div>
        <a href="view/login.php" class="login-btn">Login</a>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to Bafrow<span class="care-red">Care</span></h1>
        <p>We operate clinics under our Health Project through Bafrow Medical Centre and our Well Woman’s Family Clinics, providing integrated healthcare services in The Gambia.</p>
        <a href="view/login.php" class="cta-btn">Get Started</a>
    </div>

    <!-- Mission Section -->
    <div class="mission-section">
        <div class="text">
            <h2>Our Mission</h2>
            <p>Bafrow Medical Centre is a national, self-sustained clinical institution, accredited by the West African College of Physicians to train junior and senior residents in Family Medicine. Our medical service contributes to the reduction of illnesses and deaths in The Gambia through the provision of integrated health preventive and clinical care, maternal and child healthcare, and nutritional orientation to all. Our work responds to both the national health policy goals and the United Nation’s health-related Sustainable Development Goals.</p>
        </div>
        <div class="image">
            <img src="images/bafrow.jpg" alt="Bafrow Medical Centre">
        </div>
    </div>

    <!-- Footer with Contact Details -->
    <div class="footer">
        <div class="contact-details">
            <div>
                <i class="fas fa-phone-alt"></i>
                <span>Administrative: +220 39 55 102</span>
            </div>
            <div>
                <i class="fas fa-phone-alt"></i>
                <span>Medical: +220 37 37 485</span>
            </div>
            <div>
                <i class="fas fa-phone-alt"></i>
                <span>Mlandaba Branch: +220 37 00 783</span>
            </div>
            <div>
                <i class="fas fa-envelope"></i>
                <span>info@bafrow.org</span>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 BafrowCare
        </div>
    </div>
</body>
</html>