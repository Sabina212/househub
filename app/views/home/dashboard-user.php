<?php
session_start();
ob_start();
include("connection.php");
$user_name = $_SESSION['username'] ?? 'User';
$title = 'HouseHub - User Dashboard';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get service providers
$sql = "SELECT * FROM provider_profile ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<main>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f8f6;
            color: #26332c;
        }

        .dashboard {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin-bottom: 5px;
        }

        .welcome p {
            color: #6b756f;
        }

        /* Provider Grid */

        .provider-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        /* Provider Card */

        .provider-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e3e9e5;
        }

        .provider-card h3 {
            margin-top: 0;
            color: #149447;
        }

        .provider-info {
            margin: 10px 0;
        }

        .provider-info strong {
            color: #26332c;
        }

        .provider-info span {
            color: #68736d;
        }

        /* Request Button */

        .request-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 12px;

            background: #149447;
            color: white;

            text-align: center;
            text-decoration: none;

            border-radius: 7px;
            font-weight: bold;

            border: none;
            cursor: pointer;
        }

        .request-btn:hover {
            background: #107c3b;
        }

        .no-provider {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }

    </style>

<div class="dashboard">
    <div class="welcome">
        <h1>Welcome to HouseHub</h1>
        <p>
            Find a service provider and request the service you need.
        </p>
    </div>

    <h2>Available Service Providers</h2>

    <div class="provider-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($provider = mysqli_fetch_assoc($result)): ?>
                <div class="provider-card">
                    <h3>
                        <?php echo htmlspecialchars($provider['email']); ?>
                    </h3>

                    <div class="provider-info">

                        <strong>Service:</strong>

                        <span>
                            <?php echo htmlspecialchars($provider['profession']); ?>
                        </span>

                    </div>


                    <div class="provider-info">

                        <strong>Email:</strong>

                        <span>
                            <?php echo htmlspecialchars($provider['email']); ?>
                        </span>

                    </div>


                    <div class="provider-info">

                        <strong>Contact:</strong>

                        <span>
                            <?php echo htmlspecialchars($provider['phone']); ?>
                        </span>

                    </div>


                    <div class="provider-info">

                        <strong>Address:</strong>

                        <span>
                            <?php echo htmlspecialchars($provider['address']); ?>
                        </span>

                    </div>


                    <?php if (!empty($provider['description'])): ?>

                        <div class="provider-info">

                            <strong>About:</strong>

                            <span>
                                <?php echo htmlspecialchars($provider['about']); ?>
                            </span>

                        </div>

                    <?php endif; ?>


                    <!-- Request Service -->

                    <form action="request-service.php" method="POST">

                        <input
                            type="hidden"
                            name="provider_id"
                            value="<?php echo $provider['id']; ?>"
                        >

                        <button type="submit" class="request-btn">
                            Request Service
                        </button>

                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="no-provider">

                <h3>No Service Providers Available</h3>

                <p>
                    There are currently no service providers registered.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>
</main>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/main.php';
    ?>