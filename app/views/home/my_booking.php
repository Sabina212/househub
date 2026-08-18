```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connection.php";

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'] ?? 'User';

$bookings = [];

/*
    Expected bookings table:

    bookings
    --------------------
    id
    user_id
    provider_id
    service
    booking_date
    booking_time
    status
*/

$sql = "SELECT *
        FROM bookings
        WHERE user_id = ?
        ORDER BY booking_date DESC, booking_time DESC";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Bookings - HouseHub</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f5f7fa;
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
            max-width: 1100px;
            margin: 35px auto;
        }

        .booking-card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .booking-card h2 {
            margin-top: 0;
        }

        .booking-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .booking-info p {
            margin: 5px 0;
            color: #555;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 5px;
            background: #fff3cd;
            color: #856404;
            font-size: 14px;
        }

        .no-booking {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .find-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 11px 18px;
            background: #198754;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        @media(max-width: 600px) {
            .booking-info {
                grid-template-columns: 1fr;
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

    <h1>My Bookings</h1>

    <p>
        Welcome, <?php echo htmlspecialchars($user_name); ?>.
        Here you can see your service bookings.
    </p>

    <br>


    <?php if (count($bookings) > 0): ?>

        <?php foreach ($bookings as $booking): ?>

            <div class="booking-card">

                <h2>
                    <?php
                    echo htmlspecialchars(
                        $booking['service'] ?? 'Service'
                    );
                    ?>
                </h2>

                <div class="booking-info">

                    <p>
                        <strong>Booking ID:</strong>
                        <?php echo $booking['id']; ?>
                    </p>

                    <p>
                        <strong>Provider ID:</strong>
                        <?php echo $booking['provider_id']; ?>
                    </p>

                    <p>
                        <strong>Date:</strong>
                        <?php
                        echo htmlspecialchars(
                            $booking['booking_date'] ?? ''
                        );
                        ?>
                    </p>

                    <p>
                        <strong>Time:</strong>
                        <?php
                        echo htmlspecialchars(
                            $booking['booking_time'] ?? ''
                        );
                        ?>
                    </p>

                </div>

                <br>

                <strong>Status:</strong>

                <span class="status">
                    <?php
                    echo htmlspecialchars(
                        $booking['status'] ?? 'Pending'
                    );
                    ?>
                </span>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="no-booking">

            <h2>No Bookings Yet</h2>

            <p>
                You have not booked any service provider yet.
            </p>

            <a href="find_provider.php" class="find-btn">
                Find a Provider
            </a>

        </div>

    <?php endif; ?>

</div>

</body>
</html>
```
