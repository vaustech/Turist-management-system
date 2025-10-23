<?php include 'includes/header.php'; ?>

<div class="auth-page-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card auth-card">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-none d-md-block auth-image-section">
                        </div>

                        <div class="col-md-6">
                            <div class="auth-form-section">
                                <h3 class="text-center mb-4">Create an Account</h3>
                                <form action="handle_signup.php" method="POST" id="signupForm">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-mobile-alt"></i></span></div>
                                            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                        <small id="password-message" class="form-text"></small>
                                    </div>
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-block">Sign Up</button>
                                </form>
                                <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

  



<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const message = document.getElementById('password-message');
    const submitBtn = document.getElementById('submitBtn');

    function validatePassword() {
        if (password.value === '' || confirmPassword.value === '') {
            message.textContent = '';
            return;
        }

        if (password.value === confirmPassword.value) {
            message.textContent = 'Passwords match!';
            message.style.color = 'green';
            submitBtn.disabled = false; // বাটনটি চালু করুন
        } else {
            message.textContent = 'Passwords do not match!';
            message.style.color = 'red';
            submitBtn.disabled = true; // বাটনটি বন্ধ করুন
        }
    }

    password.addEventListener('keyup', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
});
</script>

<?php include 'includes/footer.php'; ?>