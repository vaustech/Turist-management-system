<?php
// সেশন চালু না থাকলে তা চালু করা হচ্ছে
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* --- লগইন বাইপাস লজিক (শুধুমাত্র ডেভেলপমেন্টের জন্য) --- */
if (!isset($_SESSION['admin_loggedin'])) {
    $_SESSION['admin_loggedin'] = true;
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_username'] = 'admin';
    $_SESSION['admin_image'] = 'default.png';
}

// নেভিগেশন বারে ব্যবহারের জন্য সেশন থেকে তথ্য নেওয়া হচ্ছে
$admin_username = htmlspecialchars($_SESSION['admin_username']);
$admin_image = htmlspecialchars($_SESSION['admin_image']);
$current_page = basename($_SERVER['PHP_SELF']);

// --- না পড়া মেসেজের সংখ্যা গণনা করা ---
// Note: $conn variable comes from the main page like index.php or queryManage.php
$unread_query = mysqli_query($conn, "SELECT COUNT(*) as unread_count FROM tbl_userquery WHERE status=0");
$unread_queries_count = mysqli_fetch_assoc($unread_query)['unread_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
</head>
<body>
<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="../uploads/<?php echo $admin_image; ?>" alt="Admin Photo">
            <h3><?php echo $admin_username; ?></h3>
        </div>
        <ul class="list-unstyled components">
            <li class="<?php if($current_page == 'index.php') echo 'active'; ?>"><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="<?php if($current_page == 'profile.php') echo 'active'; ?>"><a href="profile.php"><i class="fas fa-user-circle"></i> My Profile</a></li>
            <li class="<?php if($current_page == 'packageManage.php') echo 'active'; ?>"><a href="packageManage.php"><i class="fas fa-box-open"></i> Manage Packages</a></li>
            <li class="<?php if($current_page == 'manage-availability.php') echo 'active'; ?>"><a href="manage-availability.php"><i class="fas fa-calendar-alt"></i> Manage Availability</a></li>

            <li class="<?php if($current_page == 'categoryManage.php') echo 'active'; ?>"><a href="categoryManage.php"><i class="fas fa-tags"></i> Manage Categories</a></li>

<li class="<?php if($current_page == 'promoManage.php') echo 'active'; ?>"><a href="promoManage.php"><i class="fas fa-percent"></i> Manage Promos</a></li>

            <li class="<?php if($current_page == 'bookingManage.php') echo 'active'; ?>"><a href="bookingManage.php"><i class="fas fa-calendar-check"></i> Manage Bookings</a></li>
            <li class="<?php if($current_page == 'userManage.php') echo 'active'; ?>"><a href="userManage.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li class="<?php if($current_page == 'queryManage.php') echo 'active'; ?>"><a href="queryManage.php"><i class="fas fa-question-circle"></i> Manage Queries</a></li>
            <li class="<?php if($current_page == 'testimonialManage.php') echo 'active'; ?>">
            <li> <a href="testimonialManage.php"><i class="fas fa-comment-alt"></i> Manage Testimonials</a></li>
            <li class="<?php if($current_page == 'reports.php') echo 'active'; ?>">
    <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
                </li>
        <li class="<?php if($current_page == 'customTripsManage.php') echo 'active'; ?>">
    <a href="customTripsManage.php"><i class="fas fa-route"></i> Custom Trip Requests</a>
</li>
<li class="<?php if($current_page == 'guideManage.php') echo 'active'; ?>"><a href="guideManage.php"><i class="fas fa-user-tie"></i> Manage Guides</a></li>
            <li class="<?php if($current_page == 'galleryManage.php') echo 'active'; ?>"><a href="galleryManage.php"><i class="fas fa-images"></i> Manage Gallery</a></li>

            <li class="<?php if($current_page == 'subscriberManage.php') echo 'active'; ?>">
    <a href="subscriberManage.php"><i class="fas fa-envelope"></i> Manage Subscribers</a>
</li>
<li class="<?php if($current_page == 'blogManage.php') echo 'active'; ?>"><a href="blogManage.php"><i class="fas fa-newspaper"></i> Manage Blog</a></li>
        </ul>
    </nav>


    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid topbar">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                </button>
                
                <div class="d-flex align-items-center">
                    <a href="queryManage.php" class="text-secondary mr-3" title="Unread Queries">
                        <i class="fas fa-bell" style="font-size: 1.5rem;"></i>
                        <?php if ($unread_queries_count > 0): ?>
                            <span class="badge badge-danger" style="position: relative; top: -10px; left: -10px;">
                                <?php echo $unread_queries_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="partials/_logout.php" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>
        <main>