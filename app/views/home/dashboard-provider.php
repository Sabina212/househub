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

        <a href="provider-edit-profile.php"
           class="profile-button">

            Edit Profile

        </a>

    </div>

    <!-- RECENT BOOKINGS -->
    <h2 class="section-title">Recent Bookings</h2>
    <div class="booking-section">
        <div class="booking">
            <div>
                <div class="booking-name">Electrical Repair</div>
                <div class="booking-info">
                    Customer: Ram Sharma
                    &nbsp; | &nbsp;
                    Date: 10 Aug 2026
                </div>
            </div>
            <div class="status">Pending</div>
        </div>
    </div>
</section>
</main>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/main.php';
    ?>