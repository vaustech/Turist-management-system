<?php 
include 'includes/header.php'; 

// Check for a valid token
$token = isset($_GET['token']) ? $_GET['token'] : '';
if (empty($token)) {
    die("Invalid reset link.");
}
?>

<div class="auth-page-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card auth-card">
                    <div class="card-body auth-form-section">
                        <h3 class="text-center mb-4">Set a New Password</h3>
                        <form action="handle_reset_password.php" method="POST">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-primary btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>