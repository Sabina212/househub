<?php

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get data from registration form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];


    // Check if email already exists
    $check_sql = "SELECT id FROM user WHERE email = ?";

    $check_stmt = mysqli_prepare($conn, $check_sql);

    mysqli_stmt_bind_param(
        $check_stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($check_stmt);

    mysqli_stmt_store_result($check_stmt);


    if (mysqli_stmt_num_rows($check_stmt) > 0) {

        echo "<script>
                alert('Email already registered!');
                window.location.href='register.php';
              </script>";

        exit();
    }


    // Hash password
    $hashed_password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );


    // Insert data
    $sql = "INSERT INTO user
            (name, email, password, role, city, gender)
            VALUES (?, ?, ?, ?, ?, ?)";


    $stmt = mysqli_prepare($conn, $sql);


    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $name,
        $email,
        $hashed_password,
        $role,
        $city,
        $gender
    );


    // Execute
    if (mysqli_stmt_execute($stmt)) {

        echo "<script>
                alert('Registration successful!');
                window.location.href='login.php';
              </script>";

    } else {

        echo "Registration failed: "
             . mysqli_error($conn);

    }


    mysqli_stmt_close($stmt);
    mysqli_stmt_close($check_stmt);

}

mysqli_close($conn);

?>