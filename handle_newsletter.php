<?php
require_once('includes/_dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format. Please go back and try again.");
    }

    $sql = "INSERT INTO tbl_subscribers (email) VALUES (?) ON DUPLICATE KEY UPDATE email=email";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?subscribed=true");
    } else {
        die("Error: Could not subscribe.");
    }
}
?>