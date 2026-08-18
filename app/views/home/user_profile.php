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

$message = "";
$error = "";


/* ================= UPDATE PROFILE ================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    if ($username === "" || $email === "") {

        $error = "Username and email are required.";

    } else {

        $sql = "UPDATE users
                SET username = ?,
                    email = ?,
                    phone = ?,
                    address = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "ssssi",
                $username,
                $email,
                $phone,
                $address,
                $user_id
            );

            if (mysqli_stmt_execute($stmt)) {

                $_SESSION['username'] = $username;

                $message = "Profile updated successfully.";

            } else {

                $error = "Unable to update profile.";

            }

            mysqli_stmt_close($stmt);

        } else {

            $error = "Database error.";

        }
    }
}


/* ================= GET USER PROFILE ================= */

$sql = "SELECT *
        FROM users
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

$user = [];

if ($stmt) {

    mysqli_stmt_bind_param($stmt, "i", $user_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Profile - HouseHub</title>

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
            max-width: 700px;
            margin: 40px auto;
        }

        .profile-card {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .profile-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: #d1e7dd;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .form-group textarea {
            height: 90px;
            resize: vertical;
        }

        .update-btn {
            width: 100%;
            padding: 13px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .update-btn:hover {
            background: #157347;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
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

    <div class="profile-card">

        <div class="profile-icon">
            👤
        </div>

        <h1>My Profile</h1>


        <?php if ($message !== ""): ?>

            <div class="success">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>


        <?php if ($error !== ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="form-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="<?php
                        echo htmlspecialchars(
                            $user['username'] ?? ''
                        );
                    ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="<?php
                        echo htmlspecialchars(
                            $user['email'] ?? ''
                        );
                    ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    value="<?php
                        echo htmlspecialchars(
                            $user['phone'] ?? ''
                        );
                    ?>"
                    placeholder="Enter phone number"
                >

            </div>


            <div class="form-group">

                <label>
                    Address
                </label>

                <textarea
                    name="address"
                    placeholder="Enter your address"
                ><?php
                    echo htmlspecialchars(
                        $user['address'] ?? ''
                    );
                ?></textarea>

            </div>


            <button
                type="submit"
                class="update-btn"
            >
                Update Profil 
            </button>

        </form>

    </div>

</div>

</body>
</html>
```
