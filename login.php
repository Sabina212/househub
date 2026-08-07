<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>House Hub - Login</title>

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
    width:380px;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
}

.container h2{
    text-align:center;
    color:#2e8b57;
    margin-bottom:20px;
}

label{
    display:block;
    margin-top:10px;
    font-weight:bold;
}

input[type="email"],
input[type="password"]{
    width:100%;
    padding:10px;
    margin-top:5px;
    border:1px solid #ccc;
    border-radius:5px;
}

.btn{
    width:100%;
    padding:12px;
    margin-top:20px;
    background:#2e8b57;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
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

    <h2>House Hub Login</h2>

    <form method="POST" action ="loginCOntroller.php">

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <input type="submit" name="login" value="Login" class="btn">

    </form>

    <p>Don't have an account?
        <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>