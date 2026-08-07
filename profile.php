<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Portfolio</title>
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
    min-height:100vh;
}

.container{
    width:420px;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
}

.container h2{
    text-align:center;
    color:#2e8b57;
    margin-bottom:20px;
}

label{
    font-weight:bold;
    display:block;
    margin-bottom:5px;
}

input[type="text"],
input[type="email"],
input[type="file"],
select,
textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

textarea{
    resize:none;
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
}

.btn:hover{
    background:#256f47;
}
</style>
<body>
    <div class="Container">
        <h2>Service Provider Profile</h2> 
        <form action="saveProfile.php" method="POST" enctype="multipart/form-data">

    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Profession</label><br>
        <select name="profession" required>
            <option value="">--Select Profession--</option>
            <option value="Plumber">Plumber</option>
            <option value="Electrician">Electrician</option>
            <option value="Carpenter">Carpenter</option>
            <option value="Internet and Wifi setup">Internet and Wifi setup</option>
            <option value="Home Renovation">Home Renovation</option>
        </select>

    <label>Address</label><br>
    <input type="text" name="address" required><br><br>

    <label>Phone Number</label><br>
    <input type="text" name="phone" required><br><br>

    </select><br><br>
     <label>Profile Picture</label><br>
    <input type="file" name="profile_image"><br><br>


    <label>About Me</label><br>
    <textarea name="about" rows="5"></textarea><br><br>

    <input type="submit" value="Save Profile">

</form>
</div>
</body>
</head>
</html>



