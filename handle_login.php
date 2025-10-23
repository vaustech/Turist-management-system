<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once('includes/_dbconnect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tbl_userregistration WHERE emailid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            
            // --- নতুন চেক: ব্যবহারকারী ভেরিফাইড কিনা ---
            if ($row['is_verified'] == 1) {
                $_SESSION['user_loggedin'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                header("Location: index.php");
            } else {
                // ভেরিফাইড না হলে এরর দেখানো
                header("Location: login.php?error=notverified");
            }

        } else {
            header("Location: login.php?loginerror=true");
        }
    } else {
        header("Location: login.php?loginerror=true");
    }
}
?>