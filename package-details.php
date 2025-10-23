<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <?php
    $pkgid = isset($_GET['pkgid']) ? intval($_GET['pkgid']) : 0;
    $sql = "SELECT * FROM tbl_tourpackage WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pkgid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="row mb-5">
        <div class="col-md-8">
            <img src="uploads/<?php echo htmlspecialchars($row['package_image']); ?>" class="img-fluid rounded shadow-sm" alt="<?php echo htmlspecialchars($row['package_name']); ?>">
        </div>
        <div class="col-md-4">
            <h2><?php echo htmlspecialchars($row['package_name']); ?></h2>
            <hr>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['package_location']); ?></p>
            <p><strong>Package Type:</strong> 
                <?php 
                $type_id = $row['package_type'];
                $type_sql = "SELECT package_type FROM tbl_packagetype WHERE id = ?";
                $type_stmt = mysqli_prepare($conn, $type_sql);
                mysqli_stmt_bind_param($type_stmt, "i", $type_id);
                mysqli_stmt_execute($type_stmt);
                $type_result = mysqli_stmt_get_result($type_stmt);
                if($type_row = mysqli_fetch_assoc($type_result)){
                    echo htmlspecialchars($type_row['package_type']);
                }
                ?>
            </p>
            <h4 class="price text-success">Price: BDT <?php echo number_format($row['package_price']); ?>/-</h4>
            <hr>
            <h4>Package Details</h4>
            <p><?php echo nl2br(htmlspecialchars($row['package_details'])); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-calendar-check"></i> Available Dates & Seats</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Trip Date</th>
                                    <th>Total Seats</th>
                                    <th>Available Seats</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ডাটাবেস থেকে আজকের তারিখের পরের অ্যাভেইলেবল তারিখগুলো আনা হচ্ছে
                                $today = date('Y-m-d');
                                $avail_stmt = $conn->prepare("SELECT * FROM tbl_package_availability WHERE package_id = ? AND trip_date >= ? ORDER BY trip_date ASC");
                                $avail_stmt->bind_param("is", $pkgid, $today);
                                $avail_stmt->execute();
                                $result_avail = $avail_stmt->get_result();

                                if ($result_avail->num_rows > 0) {
                                    while ($row_avail = $result_avail->fetch_assoc()) {
                                        $available_seats = $row_avail['total_seats'] - $row_avail['booked_seats'];
                                ?>
                                <tr>
                                    <td><strong><?php echo date('d F, Y', strtotime($row_avail['trip_date'])); ?></strong></td>
                                    <td><?php echo $row_avail['total_seats']; ?></td>
                                    <td>
                                        <?php if($available_seats > 0): ?>
                                            <span class="badge badge-success"><?php echo $available_seats; ?> Seats Available</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Booking Closed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($available_seats > 0): ?>
                                            <a href="booking.php?pkgid=<?php echo $pkgid; ?>&availid=<?php echo $row_avail['id']; ?>" class="btn btn-primary btn-sm">Book This Date</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Not Available</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No upcoming dates have been scheduled for this package yet. Please check back later.</td></tr>";
                                }
                                $avail_stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    } else {
        echo "<div class='alert alert-danger'>Package not found.</div>";
    }
    mysqli_stmt_close($stmt);
    ?>


<!-- ================== নতুন রিভিউ সেকশন শুরু ================== -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4><i class="fas fa-star"></i> Reviews & Ratings for this Package</h4>
                </div>
                <div class="card-body">
                    <?php
                    $stmt_reviews = $conn->prepare("SELECT * FROM tbl_testimonials WHERE package_id = ? AND status = 1 ORDER BY created_at DESC");
                    $stmt_reviews->bind_param("i", $pkgid);
                    $stmt_reviews->execute();
                    $result_reviews = $stmt_reviews->get_result();

                    if ($result_reviews->num_rows > 0) {
                        while ($review = $result_reviews->fetch_assoc()) {
                    ?>
                            <div class="media mb-4">
                                <img src="uploads/testimonials/<?php echo htmlspecialchars($review['user_image']); ?>" class="mr-3 rounded-circle" alt="<?php echo htmlspecialchars($review['user_name']); ?>" style="width: 64px; height: 64px; object-fit: cover;">
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo htmlspecialchars($review['user_name']); ?></h5>
                                    <div class="display-stars mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review['rating']): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <p><?php echo nl2br(htmlspecialchars($review['message'])); ?></p>
                                </div>
                            </div>
                            <hr>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>No reviews for this package yet. Be the first one to write a review!</p>";
                    }
                    $stmt_reviews->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== নতুন রিভিউ সেকশন শেষ ================== -->

</div>

<?php include 'includes/footer.php'; ?>