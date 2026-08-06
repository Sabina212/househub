<?php
include("connection.php");

if(isset($_POST['register']))
{
    // Get form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $country  = mysqli_real_escape_string($conn, $_POST['country']);
    $gender   = mysqli_real_escape_string($conn, $_POST['gender']);

    // Check if email already exists
    $check = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0)
    {
        echo "<script>
                alert('Email already exists!');
                window.location='register.php';
              </script>";
    }
    else
    {
        // Insert data into database
        $sql = "INSERT INTO user(username, email, password, country, gender)
                VALUES('$username', '$email', '$password', '$country', '$gender')";

        if(mysqli_query($conn, $sql))
        {
            echo "<script>
                    alert('Registration Successful!');
                    window.location='login.php';
                  </script>";
        }
        else
        {
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
else
{
    header("Location: register.php");
    exit();
}
echo " his is the change file" ;
?>