<?php
include("connection.php");

if(isset($_POST['username']))
{
    // Get form data
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $profession   = mysqli_real_escape_string($conn, $_POST['profession']);
    $address      = mysqli_real_escape_string($conn, $_POST['address']);
    $phone        = mysqli_real_escape_string($conn, $_POST['phone']);
    $about        = mysqli_real_escape_string($conn, $_POST['about']);

    // Upload Profile Image
    $image = $_FILES['profile_image']['name'];
    $temp  = $_FILES['profile_image']['tmp_name'];

    $folder = "uploads/" . $image;

    if(!empty($image))
    {
        move_uploaded_file($temp, $folder);
    }

    // Insert into database
    $sql = "INSERT INTO provider_profile
    (username, profession, address, phone, about, profile_img)

    VALUES

    ('$username',
     '$profession',
     '$address',
     '$phone',
     '$about',
     '$image')";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Profile Saved Successfully');
                window.location='portfolio.php';
              </script>";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>