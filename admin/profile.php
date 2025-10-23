<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';

$admin_id = $_SESSION['admin_id'];

// Function to safely delete a file for admin profile
function deleteAdminImage($filename) {
    if ($filename != 'default.png') { // Do not delete the default image
        $filepath = "../uploads/" . $filename;
        if (file_exists($filepath) && is_file($filepath)) {
            unlink($filepath);
        }
    }
}

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $old_image = $_POST['old_image'];
    $new_image = $_FILES['admin_image']['name'];

    $final_image = $old_image;

    if (!empty($new_image)) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($new_image);
        if (move_uploaded_file($_FILES['admin_image']['tmp_name'], $target_file)) {
            deleteAdminImage($old_image);
            $final_image = $new_image;
        }
    }
    
    $sql = "UPDATE tbl_admin SET username=?, email=?, admin_image=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $final_image, $admin_id);
    if(mysqli_stmt_execute($stmt)){
        // Update session variables to reflect changes immediately
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_image'] = $final_image;
        $_SESSION['message'] = "Profile updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating profile.";
    }
    header("Location: profile.php");
    exit();
}

// Handle Password Change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        $_SESSION['message'] = "New passwords do not match.";
        $_SESSION['msg_type'] = 'danger';
    } else {
        $sql_pass = "SELECT password FROM tbl_admin WHERE id = ?";
        $stmt_pass = mysqli_prepare($conn, $sql_pass);
        mysqli_stmt_bind_param($stmt_pass, "i", $admin_id);
        mysqli_stmt_execute($stmt_pass);
        $result_pass = mysqli_stmt_get_result($stmt_pass);
        $admin_data = $result_pass->fetch_assoc();

        // Verifying MD5 password as per original DB
        if (md5($current_password) == $admin_data['password']) {
            $new_hashed_password = md5($new_password);
            $sql_update_pass = "UPDATE tbl_admin SET password=? WHERE id=?";
            $stmt_update_pass = mysqli_prepare($conn, $sql_update_pass);
            mysqli_stmt_bind_param($stmt_update_pass, "si", $new_hashed_password, $admin_id);
            if(mysqli_stmt_execute($stmt_update_pass)){
                $_SESSION['message'] = "Password changed successfully!";
            } else {
                 $_SESSION['message'] = "Error changing password.";
                 $_SESSION['msg_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = "Incorrect current password.";
            $_SESSION['msg_type'] = 'danger';
        }
    }
    header("Location: profile.php");
    exit();
}


$sql = "SELECT * FROM tbl_admin WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin = mysqli_stmt_get_result($stmt)->fetch_assoc();

?>
<div class="container-fluid">
    <h2 class="mt-4">My Profile</h2>
    <hr>
    <?php 
    if(isset($_SESSION['message'])) { 
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success';
        echo '<div class="alert alert-'.$msg_type.'">'.$_SESSION['message'].'</div>'; 
        unset($_SESSION['message']); 
        unset($_SESSION['msg_type']);
    } 
    ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Update Profile Information</div>
                <div class="card-body">
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($admin['admin_image']); ?>">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label><br>
                            <img src="../uploads/<?php echo $admin['admin_image']; ?>" width="100" class="mb-2 img-thumbnail">
                            <input type="file" name="admin_image" class="form-control-file">
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="profile.php" method="POST">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-danger">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>