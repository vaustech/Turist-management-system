<?php 
include 'includes/header.php'; 
?>

<div class="auth-page-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card auth-card">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-none d-md-block login-image-section">
                            </div>

                        <div class="col-md-6">
                            <div class="auth-form-section">
                                <h3 class="text-center mb-4">User Login</h3>
                                <hr>
                                <?php
                                // Display success or error messages
                                if (isset($_GET['verified'])) { echo '<div class="alert alert-success">Your email has been verified! You can now login.</div>'; }
                                if (isset($_GET['error'])) { echo '<div class="alert alert-warning">Please verify your email before logging in.</div>'; }
                                if (isset($_GET['loginerror'])) { echo '<div class="alert alert-danger">Invalid email or password.</div>'; }
                                ?>
                                <form action="handle_login.php" method="POST">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </form>
                                 <div class="text-center mt-3">
                                <a href="forgot-password.php">Forgot Password?</a>
                                </div>
                                
                                <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>