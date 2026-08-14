<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connection.php";

$title = "HouseHub - Edit Provider Profile";


// ======================================================
// CHECK PROVIDER LOGIN
// ======================================================

if (
    !isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'provider'
) {
    header("Location: login.php");
    exit();
}

$provider_id = (int) $_SESSION['user_id'];

// ======================================================
// GET PROVIDER + PROFILE
// ======================================================

$sql = "
    SELECT
        u.id,
        u.name,
        u.email,
        u.city,
        pp.id AS profile_id,
        pp.certification_name,
        pp.issuing_organization,
        pp.certificate_file,
        pp.`profile-img`,
        pp.about
    FROM `user` u

    LEFT JOIN provider_profile pp
        ON u.id = pp.provider_id

    WHERE u.id = ?
    AND u.role = 'provider'

    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $provider_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$provider = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$provider) {
    die("Provider profile not found.");
}


// ======================================================
// GET PROVIDER SERVICES
// ======================================================

$selected_services = [];

$sql = "
    SELECT service_type_id
    FROM provider_services
    WHERE provider_id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $provider_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {

    $selected_services[] =
        (int) $row['service_type_id'];

}

mysqli_stmt_close($stmt);


// ======================================================
// GET ALL SERVICE TYPES
// ======================================================

$sql = "
    SELECT
        id,
        service_name
    FROM service_type
    ORDER BY service_name ASC
";

$service_result = mysqli_query(
    $conn,
    $sql
);

// ======================================================
// START PAGE BUFFER
// ======================================================

ob_start();

?>
<main>
<div class="profile-container">
    <?php if (isset($_GET['success'])): ?>
        <div class="success-message">Profile updated successfully.</div>
    <?php endif; ?>

    <div class="profile-header">
        <h1>Edit Provider Profile</h1>
        <p>
            Update your personal information,
            services, profile picture and certification.
        </p>
    </div>

    <form action="UpdateController.php" method="POST" enctype="multipart/form-data" class="profile-form">
        <div class="form-section">
            <h2>Basic Information</h2>
            <div class="form-group">
                <label for="name"> Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($provider['name']) ?>"required>
            </div>


            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="<?= htmlspecialchars($provider['email']) ?>" class="readonly" readonly>
            </div>

            <div class="form-group">
                <label for="city"> City</label>
                <input type="text" id="city" name="city" value="<?= htmlspecialchars($provider['city']) ?>">
            </div>


            <div class="form-group">
                <label for="about">About You</label>
                <textarea id="about" name="about" placeholder="Write about your experience, skills and services..."><?= htmlspecialchars($provider['about'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- =========================================
             SERVICES
        ========================================== -->

        <div class="form-section">
            <h2>Services You Provide</h2>
            <p class="help-text"> Select all services that you provide.</p>
            <br>

            <div class="service-grid">
                <?php while ($service = mysqli_fetch_assoc($service_result)): ?>
                    <?php
                    $service_id = (int) $service['id'];
                    $checked = in_array($service_id, $selected_services,true);
                    ?>

                    <label class="service-option">
                        <input type="checkbox" name="service_types[]" value="<?= $service_id ?>" 
                        <?= $checked ? 'checked' : '' ?>>

                        <span> <?= htmlspecialchars($service['service_name']) ?>
                        </span>
                    </label>
                <?php endwhile; ?>
            </div>
        </div>


        <!-- =========================================
             PROFILE PICTURE
        ========================================== -->

        <div class="form-section">
            <h2>Profile Picture</h2>
            <?php if (!empty($provider['profile-img'])): ?>
                <div class="profile-preview">
                    <img src="uploads/providers/profile/<?= htmlspecialchars($provider['profile-img']) ?>" alt="Profile Picture">
                </div>
                <br>
            <?php endif; ?>

            <div class="form-group">
                <label for="profile_image">Upload New Profile Picture</label>

                <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/webp">
                <p class="help-text">JPG, PNG or WebP. Maximum size: 3 MB. Leave empty to keep the current picture.</p>
            </div>
        </div>


        <!-- =========================================
             CERTIFICATION
        ========================================== -->

        <div class="form-section">
            <h2>Certification</h2>
            <div class="form-group">
                <label for="certificate_name">Certification / Skill Name</label>
                <input type="text" id="certificate_name" name="certificate_name" value="<?= htmlspecialchars($provider['certification_name'] ?? '') ?>" placeholder="e.g. Electrical Training Certificate">
            </div>

            <div class="form-group">
                <label for="issuing_organization">Issuing Organization</label>
                <input type="text" id="issuing_organization" name="issuing_organization" value="<?= htmlspecialchars($provider['issuing_organization'] ?? '') ?>" placeholder="e.g. CTEVT">
            </div>

            <?php if (!empty($provider['certificate_file'])): ?>
                <div class="current-file">
                    Current certificate:
                    <a href="uploads/providers/certificates/<?= htmlspecialchars($provider['certificate_file']) ?>" target="_blank">View Certificate</a>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="certificate_file">Upload Certificate</label>
                <input type="file" id="certificate_file" name="certificate_file" accept=".pdf,image/jpeg,image/png,image/webp">

                <p class="help-text">PDF, JPG, PNG or WebP. Maximum size: 1 MB. Leave empty to keep the current certificate.</p>
            </div>
        </div>


        <!-- =========================================
             BUTTONS
        ========================================== -->

        <div class="submit-area">
            <a href="dashboard-provider.php" class="cancel-btn">Cancel</a>
            <button type="submit" name="update_profile" class="save-btn">Save Changes</button>
        </div>
    </form>
</div>
</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>