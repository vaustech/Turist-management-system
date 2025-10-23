<?php 
include 'includes/header.php'; 

if(!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] != true){
    header("Location: login.php");
    exit;
}
?>

<div class="auth-page-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card auth-card">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-none d-md-block change-pass-image-section">
                            </div>

                        <div class="col-md-6">
                            <div class="auth-form-section">
                                <h3 class="text-center mb-4">Change Your Password</h3>
                                <hr>
                                <?php
                                if (isset($_GET['pass_success'])) { echo '<div class="alert alert-success">Password changed successfully!</div>'; }
                                if (isset($_GET['error']) && $_GET['error'] == 'mismatch') { echo '<div class="alert alert-danger">New passwords do not match.</div>'; }
                                if (isset($_GET['error']) && $_GET['error'] == 'incorrect') { echo '<div class="alert alert-danger">Your current password is incorrect.</div>'; }
                                ?>
                                <form action="handle_change_password.php" method="POST">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                            <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm New Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="change_password" class="btn btn-primary btn-block">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>