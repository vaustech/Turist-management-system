<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/_dbconnect.php';
// বর্তমান পেজের নাম বের করা হচ্ছে
$currentPage = basename($_SERVER['PHP_SELF']);
// হোমপেজ হলে 'homepage' ক্লাস, অন্য পেজ হলে 'inner-page' ক্লাস সেট করা হচ্ছে
$bodyClass = ($currentPage == 'index.php') ? 'homepage' : 'inner-page';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Management System</title>
    <!-- ===== Favicon যোগ করা হলো ===== -->
    <link rel="icon" type="image/jpeg" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
   
</head>
<body class="<?php echo $bodyClass; ?>">
<header class="header-area">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php">PORJOTOK</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="popular-package.php">Packages</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="about-us.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="trip-planner.php">Trip Planner</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] == true): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.php">My Profile</a>
                                <a class="dropdown-item" href="booking-history.php">Booking History</a>
                                <a class="dropdown-item" href="change-password.php">Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-success btn-sm" href="login.php">Login</a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="btn btn-primary btn-sm" href="signup.php">Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="main-content-wrapper">