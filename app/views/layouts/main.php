<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_name = $_SESSION['name'] ?? '';
$role = $_SESSION['role'] ?? '';
// Main HouseHub layout.
// $title and $content are supplied by the view.
$title = $title ?? 'HouseHub';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HouseHub - Find trusted local service providers for your home.">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="public/assets/css/home.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>

<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php">
            <span class="brand-mark">H</span>
            <span>House<span>Hub</span></span>
        </a>

        <nav class="main-nav" aria-label="Main navigation">
            <a href="index.php" class="active">Home</a>
            <a href="#services">Services</a>
            <a href="#providers">Providers</a>
            <a href="#how-it-works">How It Works</a>
        </nav>

        <div class="nav-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
                <!-- USER DASHBOARD BUTTON -->
                 <?php if ($role == 'customer'): ?>
                <a href="dashboard-user.php" class="btn btn-user btn-small">
                    Welcome,<?= htmlspecialchars($user_name) ?></a>

                <?php elseif ($role == 'provider'): ?>
                <a href="dashboard-provider.php" class="btn btn-user btn-small">
                    Welcome,<?= htmlspecialchars($user_name) ?></a> 
                    <?php endif; ?>
                <!-- LOGOUT BUTTON -->

                <a href="logoutcontroller.php" class="btn btn-primary btn-small">Logout</a>

            <?php else: ?>
                <a href="login.php" class="login-link">
                    Login
                </a>
                <a href="register.php" class="btn btn-primary btn-small">Join HouseHub</a>
            <?php endif; ?>

</div>
    </div>
</header>

<?= $content ?>

<footer class="footer">
    <div class="container footer-grid">
        <div>
            <a class="brand footer-brand" href="index.php">
                <span class="brand-mark">H</span>
                <span>House<span>Hub</span></span>
            </a>
            <p>Making everyday home services simple, reliable and accessible.</p>
        </div>
        <div>
            <h4>HouseHub</h4>
            <a href="#services">Services</a>
            <a href="#providers">Providers</a>
            <a href="#how-it-works">How It Works</a>
        </div>
        <div>
            <h4>Account</h4>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            © <?= date('Y') ?> HouseHub. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
