<?php

require_once "connection.php";

// Check whether form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = $_POST["name"];
    $profession = $_POST["profession"];
    $experience = $_POST["experience"];
    $location = $_POST["location"];
    $phone = $_POST["phone"];
    $services = $_POST["services"];
    $availability = $_POST["availability"];

    // Insert data into portfolio table
    $sql = "INSERT INTO portfolio
            (name, profession, experience, location, phone, services, availability)
            VALUES
            (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $name,
        $profession,
        $experience,
        $location,
        $phone,
        $services,
        $availability,
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "<script>
                alert('Portfolio saved successfully!');
                window.location.href='dashboard.php';
              </script>";

    } else {

        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>