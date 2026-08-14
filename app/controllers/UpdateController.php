
<?php

// ============================================================
// START SESSION
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// DATABASE CONNECTION
// ============================================================

require_once "connection.php";

// ============================================================
// CHECK LOGIN
// ============================================================

if (
    !isset($_SESSION['user_id']) ||
    ($_SESSION['role'] ?? '') !== 'provider'
) {
    header("Location: login.php");
    exit();
}

$provider_id = (int) $_SESSION['user_id'];

// ============================================================
// ONLY ALLOW POST REQUEST
// ============================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: edit-profile.php");
    exit();
}

// ============================================================
// GET FORM DATA
// ============================================================

$name = trim($_POST['name'] ?? '');
$city = trim($_POST['city'] ?? '');
$about = trim($_POST['about'] ?? '');
$service_types = $_POST['service_types'] ?? [];
$certificate_name = trim($_POST['certificate_name'] ?? '');
$issuing_organization = trim($_POST['issuing_organization'] ?? '');

// ============================================================
// VALIDATE NAME
// ============================================================

if ($name === '') {
 die("Provider name is required.");
}

// ============================================================
// VALIDATE SERVICE ARRAY
// ============================================================

if (!is_array($service_types)) {
    $service_types = [];
}

// Convert submitted service IDs to integers

$service_types = array_map('intval',$service_types);

// Remove duplicate service IDs

$service_types = array_unique($service_types);

// Remove invalid IDs such as 0

$service_types = array_filter($service_types,
    function ($id) {
        return $id > 0;
    }
);

// Re-index array

$service_types = array_values($service_types);

// ============================================================
// VALIDATE SERVICE IDs AGAINST DATABASE
// ============================================================

$valid_services = [];

$sql = "
    SELECT id
    FROM service_type
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Unable to load service types.");
}

while ($row = mysqli_fetch_assoc($result)) {
    $valid_services[] =
        (int) $row['id'];

}

// Keep only IDs that actually exist

$service_types = array_values(
    array_intersect(
        $service_types,
        $valid_services
    )
);

// ============================================================
// GET EXISTING PROVIDER PROFILE
// ============================================================

$sql = "
    SELECT
        id,
        `profile-img`,
        certification_name,
        issuing_organization,
        certificate_file,
        about
    FROM provider_profile
    WHERE provider_id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn,$sql);

if (!$stmt) {
    die("Database error.");
}

mysqli_stmt_bind_param($stmt,
    "i",
    $provider_id
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$existing_profile = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

// Existing profile image

$old_profile_image = '';

if ($existing_profile) {
    $old_profile_image = $existing_profile['profile-img'] ?? '';
}

// Existing certificate file

$old_certificate_file = '';

if ($existing_profile) {
    $old_certificate_file = $existing_profile['certificate_file'] ?? '';
}


// ============================================================
// UPLOAD DIRECTORIES
// ============================================================

$project_root = dirname(__DIR__, 2);
$upload_base = $project_root . "/uploads/providers";

$profile_directory = $upload_base . "/profile/";
$certificate_directory = $upload_base . "/certificates/";

// Ensure upload directories exist
if (!is_dir($profile_directory) && !mkdir($profile_directory, 0755, true)) {
    die("Unable to create profile upload directory: " . htmlspecialchars($profile_directory));
}

if (!is_dir($certificate_directory) && !mkdir($certificate_directory, 0755, true)) {
    die("Unable to create certificate upload directory: " . htmlspecialchars($certificate_directory));
}

// ============================================================
// VARIABLES FOR NEW UPLOADS
// ============================================================

$new_profile_image = $old_profile_image;
$new_certificate_file = $old_certificate_file;
$profile_image_uploaded = false;
$certificate_uploaded = false;

// ============================================================
// PROFILE IMAGE UPLOAD
// ============================================================

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error']!== UPLOAD_ERR_NO_FILE) 
    {
    // Check upload error
    if (
        $_FILES['profile_image']['error']
        !== UPLOAD_ERR_OK
    ) {
        die("Error uploading profile image.");
    }

    // Maximum size = 2 MB

    if ($_FILES['profile_image']['size']> 2 * 1024 * 1024) {
        die("Profile image must be less than 2 MB.");
    }

    $tmp_file = $_FILES['profile_image']['tmp_name'];

    // Verify that uploaded file is actually an image

    $image_info = getimagesize($tmp_file);
    if ($image_info === false) {
        die("Invalid profile image.");
    }

    // Allowed image types
    $allowed_image_types = [
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
        IMAGETYPE_WEBP
    ];


    if (!in_array($image_info[2],$allowed_image_types,true)
    ) {
        die(
            "Only JPG, PNG and WebP images are allowed."
        );
    }

    // Determine extension

    switch ($image_info[2]) {
        case IMAGETYPE_JPEG:
            $extension = "jpg";
            break;

        case IMAGETYPE_PNG:
            $extension = "png";
            break;

        case IMAGETYPE_WEBP:
            $extension = "webp";
            break;

        default:
            die("Unsupported image type.");
    }


    // Generate random filename

    $new_profile_image = "provider_".$provider_id ."_" .bin2hex(random_bytes(8)) ."." .$extension;
    $destination =$profile_directory.$new_profile_image;

    // Move uploaded file
    if (!move_uploaded_file($tmp_file, $destination)
    ) {
        die("Unable to save profile image.");
    }

    $profile_image_uploaded = true;

}


// ============================================================
// CERTIFICATE FILE UPLOAD
// ============================================================

if (isset($_FILES['certificate_file']) &&$_FILES['certificate_file']['error']
!== UPLOAD_ERR_NO_FILE
) {

    // Check upload error

    if ($_FILES['certificate_file']['error']!== UPLOAD_ERR_OK
    ) {
        die("Error uploading certificate.");
    }

    // Maximum size = 1 MB

    if ($_FILES['certificate_file']['size']> 1 * 1024 * 1024
    ) {
        die("Certificate file must be less than 1 MB.");
    }

    $tmp_file = $_FILES['certificate_file']['tmp_name'];

    // Detect MIME type

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type =$finfo->file($tmp_file);

    // Allowed certificate types

    $allowed_certificate_types = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];


    if (!isset($allowed_certificate_types[$mime_type])) {
        die(
            "Only PDF, JPG, PNG and WebP certificates are allowed."
        );
    }
    $extension = $allowed_certificate_types[$mime_type];

    // Generate random filename

    $new_certificate_file ="certificate_" .$provider_id ."_" .bin2hex(random_bytes(8)) ."." .$extension;
    $destination =$certificate_directory .$new_certificate_file;

    // Move uploaded certificate
    if (!move_uploaded_file($tmp_file,$destination)
    ) {
        die(
            "Unable to save certificate file."
        );
    }
    $certificate_uploaded = true;
}

// ============================================================
// START DATABASE TRANSACTION
// ============================================================

mysqli_begin_transaction($conn);

try {
    // ========================================================
    // 1. UPDATE USER INFORMATION
    // ========================================================

    $sql = "
        UPDATE `user`
        SET
            name = ?,
            city = ?
        WHERE
            id = ?
            AND role = 'provider'
    ";

    $stmt = mysqli_prepare($conn,$sql);

    if (!$stmt) {
        throw new Exception(
            "Unable to prepare user update."
        );
    }

    mysqli_stmt_bind_param(
        $stmt,"ssi",$name,$city,$provider_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(
            "Unable to update provider information."
        );
    }
    mysqli_stmt_close($stmt);

    // ========================================================
    // 2. INSERT OR UPDATE PROVIDER PROFILE
    // ========================================================

    if ($existing_profile) {
        // Update existing profile
        $sql = "
            UPDATE provider_profile
            SET
                `profile-img` = ?,
                certificate_file = ?,
                certification_name = ?,
                issuing_organization = ?,
                about = ?
            WHERE provider_id = ?
        ";

        $stmt = mysqli_prepare($conn,$sql);

        if (!$stmt) {
            throw new Exception(
                "Unable to prepare profile update."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $new_profile_image,
            $new_certificate_file,
            $certificate_name,
            $issuing_organization,
            $about,
            $provider_id
        );

    } else {
        // Create new provider profile
        $sql = "
            INSERT INTO provider_profile
            (
                provider_id,
                certification_name,
                certificate_file,
                issuing_organization,
                `profile-img`,
                about
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,  
                ?
            )
        ";

        $stmt = mysqli_prepare( $conn,$sql);

        if (!$stmt) {
            throw new Exception(
                "Unable to prepare profile insert."
            );
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isssss",
            $provider_id,
            $certificate_name,
            $new_certificate_file,
            $issuing_organization,
            $new_profile_image,
            $about
        );
    }

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(
            "Unable to save provider profile."
        );
    }
    mysqli_stmt_close($stmt);


    // ========================================================
    // 3. UPDATE PROVIDER SERVICES
    // ========================================================

    // Remove previous services
    $sql = "
        DELETE FROM provider_services
        WHERE provider_id = ?
    ";

    $stmt = mysqli_prepare($conn,$sql);

    if (!$stmt) {
        throw new Exception(
            "Unable to prepare service deletion."
        );
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $provider_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(
            "Unable to remove previous services."
        );
    }

    mysqli_stmt_close($stmt);

    // Insert newly selected services
    if (!empty($service_types)) {
        $sql = "
            INSERT INTO provider_services
            (
                provider_id,
                service_type_id
            )
            VALUES
            (
                ?,
                ?
            )
        ";

        $stmt = mysqli_prepare( $conn,$sql);

        if (!$stmt) {
            throw new Exception(
                "Unable to prepare service insertion."
            );
        }

        foreach ($service_types as $service_type_id) {
            mysqli_stmt_bind_param(
                $stmt,
                "ii",
                $provider_id,
                $service_type_id
            );

            if (
                !mysqli_stmt_execute($stmt)
            ) {
                throw new Exception(
                    "Unable to save selected service."
                );
            }
        }
        mysqli_stmt_close($stmt);
    }

    // ========================================================
    // 5. COMMIT EVERYTHING
    // ========================================================

    mysqli_commit($conn);

    // ========================================================
    // DELETE OLD FILES AFTER SUCCESSFUL DB UPDATE
    // ========================================================

    if ($profile_image_uploaded && !empty($old_profile_image) &&
        file_exists(
            $profile_directory .
            $old_profile_image
        )
    ) {
        unlink(
            $profile_directory .
            $old_profile_image
        );
    }

    if ($certificate_uploaded && !empty($old_certificate_file) &&
        file_exists(
            $certificate_directory .
            $old_certificate_file
        )
    ) {
        unlink(
            $certificate_directory .
            $old_certificate_file
        );

    }

    // ========================================================
    // UPDATE SESSION NAME
    // ========================================================

    $_SESSION['name'] = $name;

    // ========================================================
    // REDIRECT
    // ========================================================

    header(
        "Location: dashboard-provider.php?success=1"
    );
    exit();
} catch (Exception $e) {

    // ========================================================
    // ROLLBACK DATABASE
    // ========================================================
    mysqli_rollback($conn);
    // ========================================================
    // REMOVE NEW PROFILE IMAGE IF DB FAILED
    // ========================================================

    if ($profile_image_uploaded && !empty($new_profile_image) &&
        file_exists(
            $profile_directory .
            $new_profile_image
        )
    ) {
        unlink(
            $profile_directory .
            $new_profile_image
        );

    }

    // ========================================================
    // REMOVE NEW CERTIFICATE IF DB FAILED
    // ========================================================
    if ($certificate_uploaded && !empty($new_certificate_file) &&
        file_exists(
            $certificate_directory .
            $new_certificate_file
        )
    ) {
        unlink(
            $certificate_directory .
            $new_certificate_file
        );

    }
    // ========================================================
    // SHOW ERROR
    // ========================================================
    die(
        "Profile update failed: " .
        htmlspecialchars(
            $e->getMessage()
        )
    );

}
?>
