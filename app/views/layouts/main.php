<?php
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
            <a href="login.php" class="login-link">Login</a>
            <a href="register.php" class="btn btn-primary btn-small">Join HouseHub</a>
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
