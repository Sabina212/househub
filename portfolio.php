<?php
include("connection.php");

// Get the latest profile
$sql = "SELECT * FROM provider_profile ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Provider Portfolio</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f2f2f2;
}

.header{
    background:#2e8b57;
    color:white;
    text-align:center;
    padding:20px;
}

.container{
    width:80%;
    margin:30px auto;
}

.profile{
    background:white;
    padding:30px;
    border-radius:10px;
    display:flex;
    gap:30px;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}

.profile img{
    width:220px;
    height:220px;
    border-radius:50%;
    border:4px solid #2e8b57;
    object-fit:cover;
}

.details{
    flex:1;
}

.details h2{
    color:#2e8b57;
    margin-bottom:10px;
}

.details p{
    margin:10px 0;
    font-size:17px;
}

.section{
    background:white;
    margin-top:25px;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}

.section h2{
    color:#2e8b57;
    margin-bottom:15px;
}

.service{
    background:#dff5e1;
    padding:12px;
    margin:10px 0;
    border-radius:5px;
}

.rating{
    color:gold;
    font-size:25px;
}

footer{
    background:#2e8b57;
    color:white;
    text-align:center;
    padding:15px;
    margin-top:30px;
}

</style>

</head>

<body>

<div class="header">
    <h1>House Hub Portfolio</h1>
</div>

<div class="container">

<div class="profile">

<div>

<?php
if(!empty($row['profile_image']))
{
?>
<img src="uploads/<?php echo $row['profile_image']; ?>">
<?php
}
else
{
?>
<img src="images/default.png">
<?php
}
?>

</div>

<div class="details">

<h2><?php echo $row['username']; ?></h2>

<p><strong>Profession:</strong> <?php echo $row['profession']; ?></p>

<p><strong>Address:</strong> <?php echo $row['address']; ?></p>

<p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>

<p><strong>About Me:</strong><br>
<?php echo $row['about']; ?>
</p>

</div>

</div>

<div class="section">

<h2>Services</h2>

<div class="service">⚡ Electrical Wiring</div>

<div class="service">🚰 Plumbing Repair</div>

<div class="service">🪚 Carpentry Work</div>

<div class="service">📡 Internet & WiFi Setup</div>

</div>

<div class="section">

<h2>Certificates</h2>

<ul>
    <li>✔ Licensed Service Provider</li>
    <li>✔ Safety Training Certificate</li>
    <li>✔ Technical Skill Certificate</li>
</ul>

</div>

<div class="section">

<h2>Customer Rating</h2>

<div class="rating">
★★★★★
</div>

<p>4.9 / 5 (120 Reviews)</p>

<p>"Excellent service. Highly recommended!"</p>

</div>

</div>

<footer>

© 2026 House Hub | All Rights Reserved

</footer>

</body>
</html>