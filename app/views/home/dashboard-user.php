<?php
$title = 'Dashboard - HouseHub';
if (session_status() == PHP_SESSION_NONE) session_start();
ob_start();
?>

<main>
    <section class="section">
        <div class="container">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></h2>
            <p class="hero-text">This is your dashboard. Use the links below to manage your account and view your services.</p>

            <div style="margin-top:18px; display:flex; gap:12px; flex-wrap:wrap;">
                <a href="dashboard.php" class="btn btn-primary">Open Full Dashboard</a>
                <a href="profile.php" class="btn btn-light border">Edit Profile</a>
            </div>
        </div>
    </section>
</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include("connection.php");

/*
|--------------------------------------------------------------------------
| Logged-in Provider
|--------------------------------------------------------------------------
*/

$user_id = $_SESSION['id'];
$username = $_SESSION['username'] ?? '';
$provider_id = $_SESSION['provider_id'] ?? 0;
/*
|--------------------------------------------------------------------------
| Get Provider Information
|--------------------------------------------------------------------------
*/

$provider = null;
if ($provider_id > 0) {

    $sql = "
        SELECT *
        FROM provider_profile
        WHERE id = '$provider_id'
        LIMIT 1
    ";

} else {

    /*
    |--------------------------------------------------------------------------
    | Fallback for existing profiles
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT *
        FROM provider_profile
        WHERE user_id = '$user_id'
        OR username = '$username'
        LIMIT 1
    ";
}


$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $provider = mysqli_fetch_assoc($result);

    $provider_id = $provider['id'];

    $_SESSION['provider_id'] = $provider_id;

} else {

    /*
    |--------------------------------------------------------------------------
    | Provider profile doesn't exist
    |--------------------------------------------------------------------------
    */

    $provider = null;
}


/*
|--------------------------------------------------------------------------
| Update Provider Information
|--------------------------------------------------------------------------
*/

$update_message = '';

$update_error = '';


if (isset($_POST['update_profile']) && $provider) {

    $new_username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $profession = mysqli_real_escape_string(
        $conn,
        $_POST['profession']
    );

    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );

    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );

    $about = mysqli_real_escape_string(
        $conn,
        $_POST['about']
    );


    /*
    |--------------------------------------------------------------------------
    | Update Profile Picture
    |--------------------------------------------------------------------------
    */

    $profile_image = $provider['profile_img'];


    if (
        isset($_FILES['profile_image']) &&
        $_FILES['profile_image']['error'] === UPLOAD_ERR_OK
    ) {

        $upload_dir = "uploads/";

        $file_name =
            time() . "_" .
            basename(
                $_FILES['profile_image']['name']
            );

        $target_file =
            $upload_dir . $file_name;


        if (
            move_uploaded_file(
                $_FILES['profile_image']['tmp_name'],
                $target_file
            )
        ) {

            $profile_image = $file_name;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update Database
    |--------------------------------------------------------------------------
    */

    $update_sql = "
        UPDATE provider_profile
        SET
            username = '$new_username',
            profession = '$profession',
            phone = '$phone',
            address = '$address',
            about = '$about',
            profile_img = '$profile_image'
        WHERE id = '$provider_id'
    ";


    if (mysqli_query($conn, $update_sql)) {

        $_SESSION['username'] = $new_username;

        $update_message =
            "Your profile has been updated successfully.";


        /*
        |--------------------------------------------------------------------------
        | Reload Provider Information
        |--------------------------------------------------------------------------
        */

        $result = mysqli_query($conn, "
            SELECT *
            FROM provider_profile
            WHERE id = '$provider_id'
            LIMIT 1
        ");

        $provider =
            mysqli_fetch_assoc($result);

    } else {

        $update_error =
            "Unable to update your profile.";

    }

}


/*
|--------------------------------------------------------------------------
| Get Service Requests
|--------------------------------------------------------------------------
*/

$requests = [];


if ($provider) {

    $request_sql = "

        SELECT

            sr.id,
            sr.service_name,
            sr.request_message,
            sr.status,
            sr.requested_at,

            u.username,
            u.email,
            u.phone,
            u.address

        FROM service_requests sr

        INNER JOIN user u
            ON sr.user_id = u.id

        WHERE sr.provider_id = '$provider_id'

        ORDER BY sr.requested_at DESC

    ";


    $request_result =
        mysqli_query(
            $conn,
            $request_sql
        );


    if ($request_result) {

        while (
            $row =
            mysqli_fetch_assoc(
                $request_result
            )
        ) {

            $requests[] = $row;

        }

    }

}


/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$total_requests = count($requests);

$pending_requests = 0;

$accepted_requests = 0;

$completed_requests = 0;


foreach ($requests as $request) {

    if ($request['status'] === 'Pending') {
        $pending_requests++;
    }

    if ($request['status'] === 'Accepted') {
        $accepted_requests++;
    }

    if ($request['status'] === 'Completed') {
        $completed_requests++;
    }

}
/*
|--------------------------------------------------------------------------
| HouseHub Layout
|--------------------------------------------------------------------------
*/

$title = "Provider Dashboard - HouseHub";

$extra_css =
    'public/assets/css/dashboard-provider.css';

ob_start();

?>


<section class="provider-dashboard">

    <div class="container">


        <!-- =========================================
             DASHBOARD HEADER
        ========================================= -->

        <div class="dashboard-top">

            <div>

                <span class="section-label">
                    SERVICE PROVIDER DASHBOARD
                </span>

                <h1>
                    Welcome,
                    <?= htmlspecialchars(
                        $provider['username'] ?? $username
                    ) ?>
                </h1>

                <p>
                    Manage your professional profile
                    and customer service requests.
                </p>

            </div>


            <div class="provider-status">

                <span class="online-dot"></span>

                <div>

                    <strong>
                        Service Provider
                    </strong>

                    <small>
                        HouseHub Professional
                    </small>

                </div>

            </div>

        </div>



        <!-- =========================================
             ALERTS
        ========================================= -->

        <?php if (!empty($update_message)): ?>

            <div class="alert alert-success">

                <?= htmlspecialchars(
                    $update_message
                ) ?>

            </div>

        <?php endif; ?>


        <?php if (!empty($update_error)): ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars(
                    $update_error
                ) ?>

            </div>

        <?php endif; ?>



        <?php if ($provider): ?>


        <!-- =========================================
             STATISTICS
        ========================================= -->

        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-lg-3">

                <div class="stat-card">

                    <div class="stat-icon">
                        ≡
                    </div>

                    <div>

                        <span>
                            Total Requests
                        </span>

                        <strong>
                            <?= $total_requests ?>
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-lg-3">

                <div class="stat-card">

                    <div class="stat-icon pending-icon">
                        ◷
                    </div>

                    <div>

                        <span>
                            Pending
                        </span>

                        <strong>
                            <?= $pending_requests ?>
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-lg-3">

                <div class="stat-card">

                    <div class="stat-icon accepted-icon">
                        ✓
                    </div>

                    <div>

                        <span>
                            Accepted
                        </span>

                        <strong>
                            <?= $accepted_requests ?>
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-lg-3">

                <div class="stat-card">

                    <div class="stat-icon completed-icon">
                        ★
                    </div>

                    <div>

                        <span>
                            Completed
                        </span>

                        <strong>
                            <?= $completed_requests ?>
                        </strong>

                    </div>

                </div>

            </div>

        </div>



        <!-- =========================================
             MAIN DASHBOARD
        ========================================= -->

        <div class="row g-4">


            <!-- =====================================
                 PROVIDER PROFILE
            ====================================== -->

            <div class="col-lg-4">

                <div class="dashboard-card provider-profile-card">


                    <div class="card-header-custom">

                        <div>

                            <span class="section-label">
                                MY PROFILE
                            </span>

                            <h2>
                                Provider Information
                            </h2>

                        </div>

                    </div>


                    <!-- Profile Picture -->

                    <div class="profile-picture">

                        <?php if (
                            !empty(
                                $provider['profile_img']
                            )
                        ): ?>

                            <img
                                src="uploads/<?= htmlspecialchars(
                                    $provider['profile_img']
                                ) ?>"
                                alt="Provider Profile"
                            >

                        <?php else: ?>

                            <span>

                                <?= strtoupper(
                                    substr(
                                        $provider['username'],
                                        0,
                                        1
                                    )
                                ) ?>

                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="provider-name">

                        <h3>

                            <?= htmlspecialchars(
                                $provider['username']
                            ) ?>

                        </h3>

                        <span>

                            <?= htmlspecialchars(
                                $provider['profession']
                            ) ?>

                        </span>

                    </div>


                    <!-- Information -->

                    <div class="provider-details">


                        <div class="detail-item">

                            <div class="detail-icon">
                                ☎
                            </div>

                            <div>

                                <small>
                                    Phone
                                </small>

                                <strong>
                                    <?= htmlspecialchars(
                                        $provider['phone']
                                    ) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="detail-item">

                            <div class="detail-icon">
                                ⌖
                            </div>

                            <div>

                                <small>
                                    Address
                                </small>

                                <strong>
                                    <?= htmlspecialchars(
                                        $provider['address']
                                    ) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="detail-item">

                            <div class="detail-icon">
                                ℹ
                            </div>

                            <div>

                                <small>
                                    About Me
                                </small>

                                <strong>
                                    <?= htmlspecialchars(
                                        $provider['about']
                                    ) ?>
                                </strong>

                            </div>

                        </div>


                    </div>


                    <!-- Edit Button -->

                    <button
                        class="btn btn-primary w-100 mt-4"
                        data-bs-toggle="collapse"
                        data-bs-target="#editProvider"
                    >

                        Edit Profile

                    </button>


                    <!-- =================================
                         EDIT PROFILE
                    ================================== -->

                    <div
                        class="collapse"
                        id="editProvider"
                    >

                        <div class="edit-profile">

                            <form
                                method="POST"
                                action="dashboard-provider.php"
                                enctype="multipart/form-data"
                            >


                                <div class="mb-3">

                                    <label class="form-label">
                                        Name
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        value="<?= htmlspecialchars(
                                            $provider['username']
                                        ) ?>"
                                        required
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Profession
                                    </label>

                                    <select
                                        class="form-select"
                                        name="profession"
                                        required
                                    >

                                        <option
                                            value="Plumber"
                                            <?= $provider['profession'] === 'Plumber'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Plumber
                                        </option>

                                        <option
                                            value="Electrician"
                                            <?= $provider['profession'] === 'Electrician'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Electrician
                                        </option>

                                        <option
                                            value="Carpenter"
                                            <?= $provider['profession'] === 'Carpenter'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Carpenter
                                        </option>

                                        <option
                                            value="Internet and Wifi setup"
                                            <?= $provider['profession'] === 'Internet and Wifi setup'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Internet and Wifi setup
                                        </option>

                                        <option
                                            value="Home Renovation"
                                            <?= $provider['profession'] === 'Home Renovation'
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            Home Renovation
                                        </option>

                                    </select>

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="phone"
                                        value="<?= htmlspecialchars(
                                            $provider['phone']
                                        ) ?>"
                                        required
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Address
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="address"
                                        value="<?= htmlspecialchars(
                                            $provider['address']
                                        ) ?>"
                                        required
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Profile Picture
                                    </label>

                                    <input
                                        type="file"
                                        class="form-control"
                                        name="profile_image"
                                        accept="image/*"
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        About Me
                                    </label>

                                    <textarea
                                        class="form-control"
                                        name="about"
                                        rows="5"
                                    ><?= htmlspecialchars(
                                        $provider['about']
                                    ) ?></textarea>

                                </div>


                                <button
                                    type="submit"
                                    name="update_profile"
                                    class="btn btn-primary w-100"
                                >

                                    Update Profile

                                </button>


                            </form>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =====================================
                 CUSTOMER REQUESTS
            ====================================== -->

            <div class="col-lg-8">

                <div class="dashboard-card request-card">


                    <div class="card-header-custom">

                        <div>

                            <span class="section-label">
                                CUSTOMER REQUESTS
                            </span>

                            <h2>
                                Service Requests
                            </h2>

                        </div>


                        <span class="request-number">

                            <?= $total_requests ?>

                        </span>

                    </div>


                    <?php if (
                        !empty($requests)
                    ): ?>


                        <div class="table-responsive">

                            <table
                                class="table provider-table align-middle"
                            >

                                <thead>

                                    <tr>

                                        <th>
                                            Customer
                                        </th>

                                        <th>
                                            Contact
                                        </th>

                                        <th>
                                            Address
                                        </th>

                                        <th>
                                            Service
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                <?php foreach (
                                    $requests
                                    as $request
                                ): ?>

                                    <tr>

                                        <!-- Customer -->

                                        <td>

                                            <div class="customer-name">

                                                <div class="customer-avatar">

                                                    <?= strtoupper(
                                                        substr(
                                                            $request['username'],
                                                            0,
                                                            1
                                                        )
                                                    ) ?>

                                                </div>

                                                <div>

                                                    <strong>

                                                        <?= htmlspecialchars(
                                                            $request['username']
                                                        ) ?>

                                                    </strong>

                                                    <small>

                                                        <?= htmlspecialchars(
                                                            $request['email']
                                                        ) ?>

                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        <!-- Contact -->

                                        <td>

                                            <?= htmlspecialchars(
                                                $request['phone']
                                            ) ?>

                                        </td>


                                        <!-- Address -->

                                        <td>

                                            <?= htmlspecialchars(
                                                $request['address']
                                            ) ?>

                                        </td>


                                        <!-- Service -->

                                        <td>

                                            <span class="service-name">

                                                <?= htmlspecialchars(
                                                    $request['service_name']
                                                ) ?>

                                            </span>

                                        </td>


                                        <!-- Status -->

                                        <td>

                                            <span class="status status-<?= strtolower(
                                                $request['status']
                                            ) ?>">

                                                <?= htmlspecialchars(
                                                    $request['status']
                                                ) ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>
                        <div class="empty-requests">

                            <div class="empty-request-icon">
                                ✓
                            </div>

                            <h3>
                                No service requests yet
                            </h3>

                            <p>
                                When customers request your
                                services, their information
                                will appear here.
                            </p>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- =========================================
             NO PROVIDER PROFILE
        ========================================= -->

        <div class="dashboard-card no-profile">

            <div class="empty-request-icon">
                !
            </div>

            <h2>
                Provider profile not found
            </h2>

            <p>
                You need to create your service provider
                profile before you can access the provider
                dashboard.
            </p>

            <a
                href="profile.php"
                class="btn btn-primary"
            >
                Create Provider Profile
            </a>

        </div>
        <?php endif; ?>
    </div>
</section>
<?php

$content = ob_get_clean();

require __DIR__ .
    '/app/views/layouts/main.php';

?>