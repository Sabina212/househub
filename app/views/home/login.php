<?php
ob_start();
// Get provider name from session
$title = 'HouseHub - Login';

?>
<main> 
<!-- MAIN -->
    <!-- WELCOME -->
<div class="login-container">

    <div class="login-card">

        <div class="login-header">

            <div class="login-icon">H</div>

            <h2>Welcome Back</h2>

            <p>Login to your HouseHub account</p>

        </div>


        <form action="logincontroller.php" method="POST">

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required>
            </div>


            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required>
            </div>


            <button type="submit" class="login-btn">
                Login
            </button>

        </form>


        <div class="register">
            Don't have an account?
            <a href="register.php">Register</a>
        </div>

    </div>

</div>
</div>
</section>
</main>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/main.php';
    ?>