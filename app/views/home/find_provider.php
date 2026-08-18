<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connection.php";

// Check user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['username'] ?? 'User';

// Get searched service
$service = trim($_GET['service'] ?? '');

$providers = [];

if ($service !== '') {

    $service_search = "%" . $service . "%";

    /*
        Expected provider table:

        service_providers
        -----------------
        id
        user_id
        name
        service
        email
        phone
        address
        availability
    */

    $sql = "SELECT *
            FROM provider_service
            WHERE service LIKE ?
            ORDER BY name ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "s", $service_search);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $providers[] = $row;
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Find Providers - HouseHub</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f5f7fa;
            color: #333;
        }

        .header {
            background: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: #198754;
        }

        .logo span {
            color: #333;
        }

        .header a {
            text-decoration: none;
            background: #198754;
            color: white;
            padding: 9px 16px;
            border-radius: 6px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        h1 {
            margin-bottom: 10px;
        }

        .search-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-form input {
            flex: 1;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .search-form button {
            background: #198754;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 6px;
            cursor: pointer;
        }

        .search-form button:hover {
            background: #157347;
        }

        .provider-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .provider-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .provider-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #e9f7ef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 15px;
        }

        .provider-card h2 {
            margin: 5px 0 10px;
            font-size: 21px;
        }

        .provider-card p {
            margin: 9px 0;
            color: #666;
        }

        .service {
            display: inline-block;
            background: #d1e7dd;
            color: #146c43;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .book-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            background: #198754;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .book-btn:hover {
            background: #157347;
        }

        .no-result {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            color: #777;
        }

        @media(max-width: 900px) {
            .provider-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {
            .provider-grid {
                grid-template-columns: 1fr;
            }

            .search-form {
                flex-direction: column;
            }
        }

    </style>
</head>

<body>

<header class="header">

    <div class="logo">
        House<span>Hub</span>
    </div>

    <a href="dashboard-user.php">
        Dashboard
    </a>

</header>

<div class="container">

    <h1>Find Service Providers</h1>

    <p>
        Search for a service provider according to your needs.
    </p>

    <div class="search-box">

        <form method="GET" action="" class="search-form">

            <input
                type="text"
                name="service"
                placeholder="Enter service e.g. electrician"
                value="<?php echo htmlspecialchars($service); ?>"
                required
            >

            <button type="submit">
                Search
            </button>

        </form>

    </div>


    <?php 
     if ($service !== '') {
    $service_search = "%" . $service . "%";

    // Updated table name to service_providers
    $sql = "SELECT *
            FROM service_providers
            WHERE service LIKE ?
            ORDER BY name ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $service_search);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $providers[] = $row;
        }

        mysqli_stmt_close($stmt);
    }
}?>

        <h2>
            Providers for:
            <?php echo htmlspecialchars($service); ?>
        </h2>

        <br>

        <?php if (count($providers) > 0): ?>

            <div class="provider-grid">

                <?php foreach ($providers as $provider): ?>

                    <div class="provider-card">

                        <div class="provider-icon">
                            👤
                        </div>

                        <h2>
                            <?php
                            echo htmlspecialchars(
                                $provider['name'] ?? 'Provider'
                            );
                            ?>
                        </h2>

                        <span class="service">
                            <?php
                            echo htmlspecialchars(
                                $provider['service'] ?? ''
                            );
                            ?>
                        </span>

                        <p>
                            📧
                            <?php
                            echo htmlspecialchars(
                                $provider['email'] ?? 'Not available'
                            );
                            ?>
                        </p>

                        <p>
                            📞
                            <?php
                            echo htmlspecialchars(
                                $provider['phone'] ?? 'Not available'
                            );
                            ?>
                        </p>

                        <p>
                            📍
                            <?php
                            echo htmlspecialchars(
                                $provider['address'] ?? 'Not available'
                            );
                            ?>
                        </p>

                        <p>
                            🟢
                            <?php
                            echo htmlspecialchars(
                                $provider['availability'] ?? 'Available'
                            );
                            ?>
                        </p>

                        <a
                            href="book_service.php?provider_id=<?php echo $provider['id']; ?>"
                            class="book-btn"
                        >
                            Book Now
                        </a>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="no-result">

                <h3>No provider found</h3>

                <p>
                    No provider is currently available for
                    "<?php echo htmlspecialchars($service); ?>".
                </p>

            </div>

        <?php endif; ?>

    <?php endif; ?>

</div>

</body>
</html>