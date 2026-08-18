<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once "connection.php";

// Check whether user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HouseHub - User Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fa;
            color: #333;
        }

        /* Header */
        .header {
            background: #ffffff;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .logo {
            font-size: 27px;
            font-weight: bold;
            color: #198754;
        }

        .logo span {
            color: #333;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome {
            font-size: 15px;
        }

        .logout {
            text-decoration: none;
            background: #dc3545;
            color: white;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .logout:hover {
            background: #bb2d3b;
        }

        /* Main */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .welcome-box {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 35px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .welcome-box h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .welcome-box p {
            font-size: 16px;
        }

        /* Search */
        .search-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .search-section h2 {
            margin-bottom: 8px;
        }

        .search-section p {
            color: #777;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 16px;
        }

        .search-box button {
            padding: 14px 25px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        .search-box button:hover {
            background: #157347;
        }

        /* Dashboard Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .card-icon {
            font-size: 35px;
            margin-bottom: 15px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .card a {
            display: inline-block;
            text-decoration: none;
            background: #198754;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .card a:hover {
            background: #157347;
        }

        /* Services */
        .services {
            margin-top: 35px;
        }

        .services h2 {
            margin-bottom: 20px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .service {
            background: white;
            padding: 22px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }

        .service .icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .service h3 {
            margin-bottom: 12px;
        }

        .service a {
            text-decoration: none;
            color: #198754;
            font-weight: bold;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            background: #ffffff;
            color: #777;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .service-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .header {
                padding: 0 15px;
            }

            .container {
                width: 94%;
            }

            .cards,
            .service-grid {
                grid-template-columns: 1fr;
            }

            .search-box {
                flex-direction: column;
            }

            .welcome-box h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<!-- ================= HEADER ================= -->

<header class="header">

    <div class="logo">
        House<span>Hub</span>
    </div>

    <div class="user-area">

        <div class="welcome">
            Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong>
        </div>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </div>

</header>


<!-- ================= MAIN CONTENT ================= -->

<main class="container">

    <!-- Welcome -->
    <section class="welcome-box">

        <h1>
            Welcome to HouseHub, 
            <?php echo htmlspecialchars($user_name); ?>!
        </h1>

        <p>
            Find trusted service providers for your home quickly and easily.
        </p>

    </section>


    <!-- ================= SEARCH ================= -->

    <section class="search-section">

        <h2>Find a Service Provider</h2>

        <p>
            Search for the service you need, such as electrician, plumber,
            carpenter or house cleaning.
        </p>

        <form action="find_provider.php" method="GET" class="search-box">

            <input
                type="text"
                name="service"
                placeholder="Search service e.g. electrician"
                required
            >

            <button type="submit">
                Find Provider
            </button>

        </form>

    </section>


    <!-- ================= DASHBOARD CARDS ================= -->

    <section class="cards">

        <!-- Find Providers -->
        <div class="card">

            <div class="card-icon">🔍</div>

            <h3>Find Providers</h3>

            <p>
                Search and find service providers according to the service
                you need.
            </p>

            <a href="find_provider.php">
                Find Provider
            </a>

        </div>


        <!-- My Bookings -->
        <div class="card">

            <div class="card-icon">📅</div>

            <h3>My Bookings</h3>

            <p>
                View the services you have booked and check your booking
                status.
            </p>

            <a href="my_bookings.php">
                My Bookings
            </a>

        </div>


        <!-- Profile -->
        <div class="card">

            <div class="card-icon">👤</div>

            <h3>My Profile</h3>

            <p>
                View and update your personal information and contact
                details.
            </p>

            <a href="user_profile.php">
                View Profile
            </a>

        </div>

    </section>


    <!-- ================= SERVICES ================= -->

    <section class="services">

        <h2>Popular Services</h2>

        <div class="service-grid">

            <!-- Electrician -->
            <div class="service">

                <div class="icon">⚡</div>

                <h3>Electrician</h3>

                <a href="find_provider.php?service=electrician">
                    Find Provider
                </a>

            </div>


            <!-- Plumber -->
            <div class="service">

                <div class="icon">🔧</div>

                <h3>Plumber</h3>

                <a href="find_provider.php?service=plumber">
                    Find Provider
                </a>

            </div>


            <!-- Carpenter -->
            <div class="service">

                <div class="icon">🪚</div>

                <h3>Carpenter</h3>

                <a href="find_provider.php?service=carpenter">
                    Find Provider
                </a>

            </div>


            <!-- Cleaning -->
            <div class="service">

                <div class="icon">🧹</div>

                <h3>Home Cleaning</h3>

                <a href="find_provider.php?service=cleaning">
                    Find Provider
                </a>

            </div>

        </div>

    </section>

</main>


<!-- ================= FOOTER ================= -->

<footer>

    <p>
        &copy; <?php echo date("Y"); ?> HouseHub. All Rights Reserved.
    </p>

</footer>

</body>
</html>