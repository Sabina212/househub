<?php

session_start();

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    // Check empty fields

    if (empty($email) || empty($password)) {

        echo "<script>
                alert('Please enter email and password');
                window.location.href='login.php';
              </script>";

        exit();
    }


    // Find user by email

    $sql = "SELECT id, name, email, password, role, city, gender
            FROM user
            WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);


    // Check user

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);


        // Check password

        if (password_verify($password, $user['password'])) {


            // Store user information in session

            $_SESSION['user_id'] = $user['id'];

            $_SESSION['name'] = $user['name'];

            $_SESSION['email'] = $user['email'];

            $_SESSION['role'] = $user['role'];

            $_SESSION['city'] = $user['city'];

            $_SESSION['gender'] = $user['gender'];


            // Redirect according to role

            if ($user['role'] == 'customer') {

                header("Location: dashboard-user.php");
                exit();

            }


            elseif ($user['role'] == 'provider') {

                header("Location:dashboard-provider.php");
                exit();

            }


            else {

                echo "<script>
                        alert('Invalid account role');
                        window.location.href='login.php';
                      </script>";

                exit();
            }

        }

        else {

            echo "<script>
                    alert('Incorrect password');
                    window.location.href='login.php';
                  </script>";

            exit();
        }

    }

    else {

        echo "<script>
                alert('Email not found');
                window.location.href='login.php';
              </script>";

        exit();
    }


    mysqli_stmt_close($stmt);

}

mysqli_close($conn);

?>