<?php
session_start();
if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin: 100px auto; padding: 30px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .login-container h2 { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Admin Panel Login</h2>
        <hr>
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="./partials/_handleLogin.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</body>
</html>