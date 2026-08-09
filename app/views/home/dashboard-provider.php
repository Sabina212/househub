<?php
ob_start();
// Get provider name from session
$provider_name = $_SESSION['username'] ?? 'Provider';
$title = 'HouseHub - Provider Dashboard';

?>
<main>
<!-- MAIN -->
    <!-- WELCOME -->
<section class="provider-dashboard">
    <div class="container">
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
</section>
</main>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/main.php';
    ?>