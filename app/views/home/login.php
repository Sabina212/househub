
<?php
$title = "Login - HouseHub";
ob_start();

?>

<section class="login-section">

    <div class="container">

        <div style="max-width:800px;margin:0 auto;background:#fff;border:1px solid var(--line);border-radius:14px;padding:28px;">
            <!-- Login Form -->
            <div class="col-lg-5 offset-lg-1">
                <div class="login-card">
                    <form action="logincontroller.php" method="POST" >
                        <!-- Email -->

                        <div class="mb-3">
                            <label for="email"  class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <!-- Login Button -->

                        <button type="submit" name="login" class="btn btn-primary w-100 py-2 mt-2">Login</button>
                    </form>

                    <!-- Register -->
                    <div class="text-center border-top mt-4 pt-3">
                        <small class="text-muted">Don't have an account?</small>
                        <a href="register.php" class="fw-semibold text-decoration-none">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>