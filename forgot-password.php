<?php 
include 'includes/header.php'; 
?>

<div class="auth-page-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card auth-card">
                    <div class="card-body auth-form-section">
                        <h3 class="text-center mb-4">Reset Your Password</h3>
                        <p class="text-muted text-center">Enter your email address and we will send you a link to reset your password.</p>
                        
                        <?php 
                        if (isset($_GET['success'])) {
                            echo '<div class="alert alert-success">If an account with that email exists, we have sent a password reset link. Please check your inbox.</div>';
                        }
                        ?>

                        <form action="handle_forgot_password.php" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your registered email" required>
                                </div>
                            </div>
                            <button type="submit" name="send_reset_link" class="btn btn-primary btn-block">Send Reset Link</button>
                        </form>
                        <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>