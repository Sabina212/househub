<?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "househub";   // Change this to your database name

$conn = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Uncomment the line below to test the connection
// echo "Database Connected Successfully!";
?>