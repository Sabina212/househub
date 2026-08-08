<?php
session_start();
include("connection.php");

// If provider ID is stored in session
$provider_id = $_SESSION['provider_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Certificate - HouseHub</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dff5e1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1b5e20;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Add Certificate</h2>

    <form action="savecertificate.php" method="POST"
          enctype="multipart/form-data">

        <input type="hidden"
               name="provider_id"
               value="<?php echo $provider_id; ?>">

        <label>Certificate Name</label>
        <input type="text"
               name="certificate_name"
               placeholder="Example: Electrical Training Certificate"
               required>

        <label>Issuing Organization</label>
        <input type="text"
               name="issuing_organization"
               placeholder="Example: CTEVT">

        <label>Issue Date</label>
        <input type="date"
               name="issue_date">

        <label>Upload Certificate</label>
        <input type="file"
               name="certificate_file"
               accept=".jpg,.jpeg,.png,.pdf"
               required>

        <button type="submit">
            Save Certificate
        </button>

    </form>

</div>

</body>
</html>