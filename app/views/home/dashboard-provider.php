<?php
session_start();

// Get provider name from session
$provider_name = $_SESSION['username'] ?? 'Provider';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HouseHub - Provider Dashboard</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8f7;
            color: #17231d;
        }

        /* HEADER */

        .header {
            height: 70px;
            background: white;
            border-bottom: 1px solid #e5e5e5;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 55px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 22px;
            font-weight: bold;
        }

        .logo-box {
            width: 36px;
            height: 36px;

            background: #159447;
            color: white;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
        }

        .logo span {
            color: #159447;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav a {
            text-decoration: none;
            color: #53605a;
            font-size: 14px;
        }

        .nav a:hover {
            color: #159447;
        }

        .logout {
            color: #d32f2f !important;
            font-weight: bold;
        }


        /* MAIN */

        .container {
            width: 90%;
            max-width: 1200px;

            margin: 50px auto;
        }

        .welcome {
            margin-bottom: 35px;
        }

        .welcome h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #65716b;
            font-size: 16px;
        }


        /* PROFILE BOX */

        .profile-box {
            background: #159447;
            color: white;

            border-radius: 15px;

            padding: 25px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 35px;
        }

        .profile-info h2 {
            margin-bottom: 7px;
        }

        .profile-info p {
            opacity: 0.9;
        }

        .profile-button {
            background: white;
            color: #159447;

            text-decoration: none;

            padding: 12px 20px;

            border-radius: 8px;

            font-weight: bold;
        }


        /* CARDS */

        .section-title {
            font-size: 21px;
            margin-bottom: 20px;
        }

        .cards {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 40px;
        }

        .card {
            background: white;

            border-radius: 12px;

            padding: 25px;

            border: 1px solid #e5e9e6;

            text-decoration: none;

            color: #17231d;

            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 8px 20px rgba(0,0,0,0.08);
        }

        .icon {
            width: 50px;
            height: 50px;

            background: #e8f7ed;
            color: #159447;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;

            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 17px;
            margin-bottom: 7px;
        }

        .card p {
            color: #727b76;
            font-size: 13px;
            line-height: 1.5;
        }


        /* BOOKING */

        .booking-section {
            background: white;

            border: 1px solid #e5e9e6;

            border-radius: 12px;

            padding: 25px;

            margin-bottom: 40px;
        }

        .booking {
            display: flex;

            justify-content: space-between;
            align-items: center;

            padding: 18px 0;

            border-bottom: 1px solid #eeeeee;
        }

        .booking:last-child {
            border-bottom: none;
        }

        .booking-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .booking-info {
            color: #777;
            font-size: 13px;
        }

        .status {
            padding: 7px 12px;

            border-radius: 20px;

            font-size: 12px;

            background: #e8f7ed;
            color: #159447;

            font-weight: bold;
        }


        /* FOOTER */

        .footer {
            background: #0c2117;

            color: white;

            padding: 35px 8%;

            margin-top: 60px;
        }

        .footer-content {
            display: flex;

            justify-content: space-between;
        }

        .footer-logo {
            font-size: 22px;
            font-weight: bold;
        }

        .footer-logo span {
            color: #159447;
        }

        .footer p {
            color: #9daaa3;

            font-size: 13px;

            margin-top: 10px;
        }


        /* RESPONSIVE */

        @media(max-width: 900px) {

            .header {
                padding: 0 20px;
            }

            .nav {
                gap: 12px;
            }

            .cards {
                grid-template-columns:
                    repeat(2, 1fr);
            }
        }


        @media(max-width: 600px) {

            .nav a {
                display: none;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .profile-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .footer-content {
                flex-direction: column;
                gap: 20px;
            }
        }

    </style>

</head>


<body>


<!-- HEADER -->

<header class="header">

    <div class="logo">

        <div class="logo-box">
            H
        </div>

        House<span>Hub</span>

    </div>


    <nav class="nav">

        <a href="index.php">
            Home
        </a>

        <a href="service.php">
            Services
        </a>

        <a href="provider_profile.php">
            My Profile
        </a>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </nav>

</header>



<!-- MAIN -->

<main class="container">


    <!-- WELCOME -->

    <div class="welcome">

        <h1>
            Welcome, <?php echo htmlspecialchars($provider_name); ?> 👋
        </h1>

        <p>
            Manage your services, portfolio, bookings and
            provider profile from your dashboard.
        </p>

    </div>



    <!-- PROFILE -->

    <div class="profile-box">

        <div class="profile-info">

            <h2>
                Provider Dashboard
            </h2>

            <p>
                Make your services visible to HouseHub customers.
            </p>

        </div>

        <a href="provider_profile.php"
           class="profile-button">

            Edit Profile

        </a>

    </div>



    <!-- MANAGEMENT -->

    <h2 class="section-title">
        Manage Your Services
    </h2>


    <div class="cards">


        <!-- SERVICES -->

        <a href="provider_service.php"
           class="card">

            <div class="icon">
                🔧
            </div>

            <h3>
                My Services
            </h3>

            <p>
                Add and manage the services
                you provide.
            </p>

        </a>



        <!-- PORTFOLIO -->

        <a href="portfolio.php"
           class="card">

            <div class="icon">
                📁
            </div>

            <h3>
                My Portfolio
            </h3>

            <p>
                Show your previous work and
                experience to customers.
            </p>

        </a>



        <!-- CERTIFICATES -->

        <a href="certificate.php"
           class="card">

            <div class="icon">
                📜
            </div>

            <h3>
                Certificates
            </h3>

            <p>
                Upload and manage your
                professional certificates.
            </p>

        </a>



        <!-- AVAILABILITY -->

        <a href="availability.php"
           class="card">

            <div class="icon">
                🕒
            </div>

            <h3>
                Availability
            </h3>

            <p>
                Set your working days and
                available time.
            </p>

        </a>

    </div>



    <!-- OTHER MANAGEMENT -->

    <h2 class="section-title">
        Provider Management
    </h2>


    <div class="cards">


        <!-- BOOKINGS -->

        <a href="provider_bookings.php"
           class="card">

            <div class="icon">
                📅
            </div>

            <h3>
                Bookings
            </h3>

            <p>
                View and manage customer
                service bookings.
            </p>

        </a>



        <!-- REVIEWS -->

        <a href="reviews.php"
           class="card">

            <div class="icon">
                ⭐
            </div>

            <h3>
                Reviews
            </h3>

            <p>
                View reviews and ratings
                from customers.
            </p>

        </a>



        <!-- PROFILE -->

        <a href="provider_profile.php"
           class="card">

            <div class="icon">
                👤
            </div>

            <h3>
                My Profile
            </h3>

            <p>
                Update your name, profession,
                location and contact details.
            </p>

        </a>



        <!-- CONTACT -->

        <a href="contact.php"
           class="card">

            <div class="icon">
                📞
            </div>

            <h3>
                Contact
            </h3>

            <p>
                Contact HouseHub support
                whenever you need help.
            </p>

        </a>

    </div>



    <!-- RECENT BOOKINGS -->

    <h2 class="section-title">
        Recent Bookings
    </h2>


    <div class="booking-section">


        <div class="booking">

            <div>

                <div class="booking-name">
                    Electrical Repair
                </div>

                <div class="booking-info">
                    Customer: Ram Sharma
                    &nbsp; | &nbsp;
                    Date: 10 Aug 2026
                </div>

            </div>

            <div class="status">
                Pending
            </div>

        </div>


        <div class="booking">

            <div>

                <div class="booking-name">
                    House Wiring
                </div>

                <div class="booking-info">
                    Customer: Sita Rai
                    &nbsp; | &nbsp;
                    Date: 12 Aug 2026
                </div>

            </div>

            <div class="status">
                Confirmed
            </div>

        </div>


    </div>


</main>



<!-- FOOTER -->

<footer class="footer">

    <div class="footer-content">

        <div>

            <div class="footer-logo">
                House<span>Hub</span>
            </div>

            <p>
                Making everyday home services
                simple, reliable and accessible.
            </p>

        </div>


        <div>

            <strong>
                Provider
            </strong>

            <p>
                My Services
            </p>

            <p>
                Portfolio
            </p>

            <p>
                Bookings
            </p>

        </div>


        <div>

            <strong>
                Account
            </strong>

            <p>
                My Profile
            </p>

            <p>
                Logout
            </p>

        </div>

    </div>

</footer>


</body>
</html>