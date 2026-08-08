<?php

include("connection.php");

$provider_id = $_POST['provider_id'];
$certificate_name = $_POST['certificate_name'];
$issuing_organization = $_POST['issuing_organization'];
$issue_date = $_POST['issue_date'];

// Certificate upload
$file_name = $_FILES['certificate_file']['name'];
$file_tmp = $_FILES['certificate_file']['tmp_name'];

$upload_folder = "uploads/certificates/";

// Create folder if it does not exist
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0777, true);
}

$new_file_name = time() . "_" . $file_name;

$upload_path = $upload_folder . $new_file_name;

if (move_uploaded_file($file_tmp, $upload_path)) {

    $sql = "INSERT INTO provider_certificates
        (provider_id, certificate_name, issuing_organization,
         issue_date, certificate_file)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "issss",
    $provider_id,
    $certificate_name,
    $issuing_organization,
    $issue_date,
    $certificate_file
);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Certificate added successfully!');
                window.location='certificate.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Certificate upload failed.";
}

?>