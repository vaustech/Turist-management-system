<?php
// উপরের এই PHP কোডটি একই থাকবে
// এটি ড্যাশবোর্ডের কার্ডগুলোর জন্য মোট সংখ্যা গণনা করে
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_userregistration");
$total_users = mysqli_fetch_assoc($total_users_query)['count'];

$total_packages_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_tourpackage");
$total_packages = mysqli_fetch_assoc($total_packages_query)['count'];

$total_bookings_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_booking");
$total_bookings = mysqli_fetch_assoc($total_bookings_query)['count'];

$pending_queries_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_userquery WHERE status=0");
$pending_queries = mysqli_fetch_assoc($pending_queries_query)['count'];
?>
<div class="container-fluid">
    <h2 class="mt-4">Dashboard</h2>
    <hr>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card bg-primary">
                <div class="card-body">
                    <div class="card-content">
                        <div class="card-text">Total Users</div>
                        <div class="card-title"><?php echo $total_users; ?></div>
                    </div>
                    
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card bg-success">
                <div class="card-body">
                    <div class="card-content">
                        <div class="card-text">Total Packages</div>
                        <div class="card-title"><?php echo $total_packages; ?></div>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card bg-info">
                <div class="card-body">
                    <div class="card-content">
                        <div class="card-text">Total Bookings</div>
                        <div class="card-title"><?php echo $total_bookings; ?></div>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card bg-warning">
                <div class="card-body">
                    <div class="card-content">
                        <div class="card-text">Pending Queries</div>
                        <div class="card-title"><?php echo $pending_queries; ?></div>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card bg-secondary">
                <div class="card-body">
                    <div class="card-content">
                        <div class="card-text">Total Testimonials</div>
                        <div class="card-title">
                            <?php 
                            $total_testimonials_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_testimonials");
                            echo mysqli_fetch_assoc($total_testimonials_query)['count'];
                            ?>
                        </div>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>