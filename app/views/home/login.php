<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HouseHub - Login</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background: #dff5e1;

            font-family: Arial, sans-serif;
        }

        /* Login Box */

        .login-box {
            width: 400px;

            background: white;

            padding: 35px;

            border-radius: 12px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* Logo */

        .logo {
            text-align: center;

            font-size: 28px;

            font-weight: bold;

            color: #159447;

            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;

            color: #777;

            margin-bottom: 28px;

            font-size: 14px;
        }

        /* Heading */

        h2 {
            text-align: center;

            margin-bottom: 25px;

            color: #222;

            font-size: 24px;
        }

        /* Form */

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #333;
        }

        input {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 7px;

            font-size: 14px;

            outline: none;
        }

        input:focus {
            border-color: #159447;
        }

        /* Login Button */

        .login-btn {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 7px;

            background: #159447;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;
        }

        .login-btn:hover {
            background: #117c3b;
        }

        /* Register */

        .register {
            text-align: center;

            margin-top: 20px;

            color: #555;

            font-size: 14px;
        }

        .register a {
            color: #159447;

            text-decoration: none;

            font-weight: bold;
        }

        .register a:hover {
            text-decoration: underline;
        }

    </style>

</head>


<body>


<div class="login-box">


    <div class="logo">
        HouseHub
    </div>


    <div class="subtitle">
        Home services made simple
    </div>


    <h2>
        Login
    </h2>


    <form
        action="logincontroller.php"
        method="POST"
    >


        <!-- EMAIL -->

        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

        </div>


        <!-- PASSWORD -->

        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

        </div>


        <!-- LOGIN -->

        <button
            type="submit"
            class="login-btn"
        >
            Login
        </button>


    </form>


    <!-- REGISTER -->

    <div class="register">

        Don't have an account?

        <a href="register.php">
            Register
        </a>

    </div>


</div>


</body>

</html>