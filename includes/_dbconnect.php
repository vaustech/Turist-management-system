<?php
// Database Configuration
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "tms_db";

// Create a database connection
$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>