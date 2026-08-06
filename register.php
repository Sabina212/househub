<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Hub - Registration</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#dff5e1;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .container{
            width:400px;
            background:#fff;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,0.2);
        }

        .container h2{
            text-align:center;
            margin-bottom:20px;
            color:#2e8b57;
        }

        label{
            font-weight:bold;
            display:block;
            margin-top:10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select{
            width:100%;
            padding:10px;
            margin-top:5px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        .gender{
            margin-top:8px;
        }

        .gender input{
            margin-right:5px;
        }

        .btn{
            width:100%;
            padding:12px;
            background:#2e8b57;
            color:white;
            border:none;
            border-radius:5px;
            font-size:16px;
            cursor:pointer;
            margin-top:20px;
        }

        .btn:hover{
            background:#256f47;
        }

        p{
            text-align:center;
            margin-top:15px;
        }

        a{
            text-decoration:none;
            color:#2e8b57;
            font-weight:bold;
        }
    </style>

</head>
<body>

<div class="container">

    <h2>House Hub Registration</h2>

    <form action="savedata.php" method="POST">

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter Username" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <label>Country</label>
        <select name="country" required>
            <option value="">--Select Country--</option>
            <option value="Nepal">Nepal</option>
            <option value="India">India</option>
            <option value="China">China</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bangladesh">Bangladesh</option>
        </select>

        <label>Gender</label>

        <div class="gender">
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female"> Female
            <input type="radio" name="gender" value="Other"> Other
        </div>

        <input type="submit" name="register" value="Register" class="btn">

    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

</div>

</body>
</html>