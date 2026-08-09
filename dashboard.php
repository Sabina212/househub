<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

include("connection.php");

$sql = "SELECT * FROM service";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>House Hub Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f4f4;
}

/* Sidebar */

.sidebar{
    position:fixed;
    width:220px;
    height:100%;
    background:#2c3e50;
    color:white;
}

.sidebar h2{
    text-align:center;
    padding:20px;
    background:#1a252f;
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    border-bottom:1px solid #3b4b5a;
}

.sidebar ul li a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px;
}

.sidebar ul li a:hover{
    background:#3498db;
}

/* Main */

.main{
    margin-left:220px;
    padding:30px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h2{
    color:#333;
}

.add-btn{
    text-decoration:none;
    background:green;
    color:white;
    padding:10px 18px;
    border-radius:5px;
}

.add-btn:hover{
    background:darkgreen;
}

/* Table */

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

table th{
    background:#3498db;
    color:white;
    padding:12px;
}

table td{
    padding:10px;
    text-align:center;
    border:1px solid #ddd;
}

.edit{
    color:blue;
    text-decoration:none;
}

.delete{
    color:red;
    text-decoration:none;
}

.edit:hover,
.delete:hover{
    text-decoration:underline;
}

.welcome{
    margin-bottom:20px;
    color:#555;
}

</style>

</head>

<body>

<div class="sidebar">

<h2>House Hub</h2>

<ul>
<li><a href="dashboard.php">🏠 Home</a></li>
<li><a href="users.php">👤 Users</a></li>
<li><a href="services.php">🛠 Services</a></li>
<li><a href="bookings.php">📅 Bookings</a></li>
<li><a href="providers.php">👷 Providers</a></li>
<li><a href="contact.php">📞 Contact</a></li>
<li><a href="portfolio.php">📁 Portfolio</a></li>
<li><a href="logout.php">🚪 Logout</a></li>
</ul>

</div>

<div class="main">

<div class="welcome">
<h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
</div>

<div class="header">
<h2>List of Services</h2>

<a href="addservice.php" class="add-btn">
+ Add Service
</a>

</div>

<table>

<tr>
<th>Service Name</th>
<th>Provider</th>
<th>Category</th>
<th>Price</th>
<th>Location</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php

if(mysqli_num_rows($result)>0)
{
    while($row=mysqli_fetch_assoc($result))
    {
?>

<tr>

<td><?php echo $row['service_name']; ?></td>

<td><?php echo $row['provider_name']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>Rs. <?php echo $row['price']; ?></td>

<td><?php echo $row['location']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<a class="edit" href="editservice.php?id=<?php echo $row['id']; ?>">
Edit
</a>

|

<a class="delete" href="deleteservice.php?id=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php
    }
}
else
{
?>

<tr>

<td colspan="7">
No Services Found
</td>

</tr>

<?php
}
?>

</table>

</div>

</body>
</html>