<?php
// Step 1: Include the database connection file
require_once('../../includes/_dbconnect.php');

// Step 2: Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    // Hash the submitted password with MD5 to match the database
    $password = md5($_POST['password']);

    // Step 3: Prepare the SQL query to prevent SQL injection
    $sql = "SELECT id, username, admin_image FROM tbl_admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result from the executed statement
    $result = mysqli_stmt_get_result($stmt);

    // --- Step 4: Create a dynamic and reliable redirect URL ---
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    // Get the path up to the 'admin' directory (e.g., /tms_project/admin)
    $admin_path = substr($uri, 0, strpos($uri, "/partials"));

    // Step 5: Check if a user was found
    if (mysqli_num_rows($result) == 1) {
        // If login is successful
        $row = mysqli_fetch_assoc($result);

        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Store user data in session variables
        $_SESSION['admin_loggedin'] = true;
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        $_SESSION['admin_image'] = $row['admin_image'];

        // Redirect the user to the admin dashboard using the absolute URL
        $redirect_url = $protocol . "://" . $host . $admin_path . "/index.php";
        header("Location: " . $redirect_url);
        exit();

    } else {
        // If login fails
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Set an error message
        $_SESSION['login_error'] = "Invalid credentials. Please try again.";

        // Redirect back to the login page using the absolute URL
        $redirect_url = $protocol . "://" . $host . $admin_path . "/login.php";
        header("Location: " . $redirect_url);
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);

} else {
    // If the page was accessed directly (not via POST), redirect to the login page
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $admin_path = substr($uri, 0, strpos($uri, "/partials"));
    
    $redirect_url = $protocol . "://" . $host . $admin_path . "/login.php";
    header("Location: " . $redirect_url);
    exit();
}
?>