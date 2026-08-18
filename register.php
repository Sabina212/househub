<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HouseHub - Register</title>


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


        /* Registration Box */

        .register-box {

            width: 400px;

            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow:
                0 5px 20px rgba(0,0,0,0.15);
        }


        /* Heading */

        h2 {

            text-align: center;

            color: #159447;

            margin-top: 0;

            margin-bottom: 25px;
        }


        /* Form */

        .form-group {

            margin-bottom: 17px;
        }


        label {

            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #333;
        }


        /* Input */

        input,
        select {

            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 14px;

            outline: none;
        }


        input:focus,
        select:focus {

            border-color: #159447;
        }


        /* Register As */

        .role-options {

            display: flex;

            gap: 25px;

            margin-top: 8px;
        }


        .role-options label {

            display: flex;

            align-items: center;

            gap: 6px;

            font-weight: normal;

            margin: 0;
        }


        .role-options input {

            width: auto;
        }


        /* Gender */

        .gender-options {

            display: flex;

            gap: 20px;

            margin-top: 8px;
        }


        .gender-options label {

            display: flex;

            align-items: center;

            gap: 5px;

            font-weight: normal;

            margin: 0;
        }


        .gender-options input {

            width: auto;
        }


        /* Button */

        .register-btn {

            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 7px;

            background: #159447;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;
        }


        .register-btn:hover {

            background: #117c3b;
        }


        /* Login */

        .login {

            text-align: center;

            margin-top: 18px;

            font-size: 14px;

            color: #555;
        }


        .login a {

            color: #159447;

            font-weight: bold;

            text-decoration: none;
        }


        .login a:hover {

            text-decoration: underline;
        }


    </style>

</head>


<body>


<div class="register-box">


    <h2>
        HouseHub Registration
    </h2>


    <form action="savedata.php" method="POST">


        <!-- NAME -->

        <div class="form-group">

            <label for="name">
                Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your name"
                required
            >

        </div>


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
                minlength="6"
                required
            >

        </div>


        <!-- REGISTER AS -->

        <div class="form-group">

            <label>
                Register As
            </label>


            <div class="role-options">


                <label>

                    <input
                        type="radio"
                        name="role"
                        value="customer"
                        required
                    >

                    Customer

                </label>


                <label>

                    <input
                        type="radio"
                        name="role"
                        value="provider"
                    >

                    Service Provider

                </label>


            </div>

        </div>


        <!-- CITY -->

        <div class="form-group">

            <label for="city">
                City
            </label>


            <select
                id="city"
                name="city"
                required
            >

                <option value="">
                    Select City
                </option>

                <option value="Kathmandu">
                    Kathmandu
                </option>

                <option value="Lalitpur">
                    Lalitpur
                </option>

                <option value="Bhaktapur">
                    Bhaktapur
                </option>

                <option value="Pokhara">
                    Pokhara
                </option>

                <option value="Chitwan">
                    Chitwan
                </option>

                <option value="Biratnagar">
                    Biratnagar
                </option>

                <option value="Butwal">
                    Butwal
                </option>

                <option value="Other">
                    Other
                </option>

            </select>

        </div>


        <!-- GENDER -->

        <div class="form-group">

            <label>
                Gender
            </label>


            <div class="gender-options">


                <label>

                    <input
                        type="radio"
                        name="gender"
                        value="Male"
                        required
                    >

                    Male

                </label>


                <label>

                    <input
                        type="radio"
                        name="gender"
                        value="Female"
                    >

                    Female

                </label>


                <label>

                    <input
                        type="radio"
                        name="gender"
                        value="Other"
                    >

                    Other

                </label>


            </div>

        </div>


        <!-- REGISTER BUTTON -->

        <button
            type="submit"
            class="register-btn"
        >

            Register

        </button>


    </form>


    <!-- LOGIN -->

    <div class="login">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>


</div>


</body>

</html>
