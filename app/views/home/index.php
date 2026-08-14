<?php
$title = 'HouseHub - Trusted Home Services';

ob_start();
// ======================================================
// GET MAXIMUM 2 AVAILABLE SERVICE PROVIDERS
// ======================================================
?>

<main>

<section class="hero">
    <div class="hero-pattern"></div>
    <div class="container hero-grid">
        <div class="hero-copy">
            <div class="eyebrow">
                <span class="pulse-dot"></span>
                Trusted local professionals
            </div>

            <h1>Reliable help for<br><span>every corner</span> of your home.</h1>

            <p class="hero-text">
                Find skilled electricians, plumbers, mechanics, appliance repairers
                and other trusted professionals — all in one place.
            </p>

            <form class="search-box" action="service.php" method="GET">
                <span class="search-icon">⌕</span>
                <input type="text" name="q" placeholder="What service do you need?">
                <select name="location" aria-label="Location">
                    <option value="">Your location</option>
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Lalitpur">Lalitpur</option>
                    <option value="Bhaktapur">Bhaktapur</option>
                </select>
                <button type="submit" class="btn btn-primary">Find a Provider</button>
            </form>

            <div class="trust-row">
                <span>✓ Verified professionals</span>
                <span>✓ Local services</span>
                <span>✓ Easy to contact</span>
            </div>
        </div>

        <div class="hero-card">
            <div class="hero-card-top">
                <span class="status-dot"></span>
                Available near you
            </div>

            <?php if (!empty($featuredProviders)): ?>

    <?php foreach ($featuredProviders as $provider): ?>

        <div class="provider-mini">

            <?php if (!empty($provider['profile_img'])): ?>
                <img src="uploads/providers/profile/<?= htmlspecialchars($provider['profile_img']) ?>" alt="<?= htmlspecialchars($provider['username']) ?>" class="avatar" style="object-fit: cover;">
            <?php else: ?>
                <div class="avatar avatar-green">
                    <?= strtoupper(substr($provider['username'],0,2)) ?>
                </div>
            <?php endif; ?>
            
            <div>
                <strong>
                    <?= htmlspecialchars($provider['username']) ?>
                </strong>
                <small>
                    <?= htmlspecialchars($provider['profession']) ?>·<?= htmlspecialchars($provider['address']) ?>
                </small>
                <span class="rating">★★★★★</span>
            </div>

            <span class="verified">✓</span>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <div class="provider-mini">
        <div class="avatar avatar-green">HH</div>
        <div>
            <strong> No providers yet</strong>
            <small>New providers will appear here.</small>
        </div>
    </div>
<?php endif; ?>

            <div class="hero-card-footer">
                <span>Trusted by local households</span>
                <strong>HouseHub</strong>
            </div>
        </div>
    </div>
</section>

<section class="section" id="services">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-label">OUR SERVICES</span>
                <h2>What can we help you with?</h2>
            </div>
        </div>

        <div class="service-grid">

    <?php foreach ($services as $service): ?>

        <a href="service.php?category=<?= urlencode($service['name']) ?>"
           class="service-card">

            <div class="service-icon">
                <?= $service['icon'] ?>
            </div>

            <div>
                <h3>
                    <?= htmlspecialchars($service['name']) ?>
                </h3>
            </div>

            <b class="arrow">↗</b>

        </a>

    <?php endforeach; ?>

</div>
    </div>
</section>

<section class="section providers-section" id="providers">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-label">MEET THE PROFESSIONALS</span>
                <h2>Featured service providers</h2>
            </div>
            <a href="profile.php" class="text-link">Become a provider →</a>
        </div>

        <div class="provider-grid">
            <?php if (!empty($featuredProviders)): ?>
                <?php foreach ($featuredProviders as $provider): ?>
                    <article class="provider-card">
                        <div class="provider-image">
                            <?php if (!empty($provider['profile_img'])): ?>
                                <img src="uploads/providers/profile/<?= htmlspecialchars($provider['profile_img']) ?>"
     alt="<?= htmlspecialchars($provider['username']) ?>">
                            <?php else: ?>
                                <div class="avatar-large">
                                    <?= strtoupper(substr($provider['username'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="provider-info">
                            <div class="provider-title">
                                <div>
                                    <h3><?= htmlspecialchars($provider['username']) ?></h3>
                                    <p><?= htmlspecialchars($provider['profession']) ?></p>
                                </div>
                                <span class="verified-badge">✓</span>
                            </div>
                            <p class="provider-location">⌖ <?= htmlspecialchars($provider['address']) ?></p>
                            <p class="provider-about">
                                <?= htmlspecialchars(mb_strimwidth($provider['about'], 0, 90, '...')) ?>
                            </p>
                            <a href="profile.php" class="provider-link">View profile →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="how-section" id="how-it-works">
    <div class="container">
        <div class="how-header">
            <span class="section-label">SIMPLE PROCESS</span>
            <h2>Get your home service in 3 easy steps.</h2>
        </div>

        <div class="steps">
            <div class="step">
                <span>01</span>
                <div class="step-icon">⌕</div>
                <h3>Find a service</h3>
                <p>Choose the service you need and search for providers near you.</p>
            </div>
            <div class="step">
                <span>02</span>
                <div class="step-icon">♙</div>
                <h3>Choose a provider</h3>
                <p>Compare professionals by service, location and profile details.</p>
            </div>
            <div class="step">
                <span>03</span>
                <div class="step-icon">✓</div>
                <h3>Get it done</h3>
                <p>Contact your selected provider and get your work completed.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container cta-box">
        <div>
            <span class="section-label">FOR SERVICE PROVIDERS</span>
            <h2>Turn your skills into opportunities.</h2>
            <p>Create your HouseHub profile and let customers discover your services.</p>
        </div>
        <a href="register.php" class="btn btn-light">Become a Provider →</a>
    </div>
</section>

</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
