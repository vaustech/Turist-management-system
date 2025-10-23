<?php 
include 'includes/header.php'; 

// ব্যবহারকারী লগইন করা না থাকলে তাকে লগইন পেজে পাঠানো হবে
if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// সেশন থেকে ব্যবহারকারীর আইডি নেওয়া হচ্ছে
$user_id = $_SESSION['user_id'];
?>

<div class="container my-5 py-5">
    <h2 class="text-center mb-4">My Booking History</h2>
    <?php
    if (isset($_GET['testimonial_success'])) {
        echo '<div class="alert alert-success">Thank you! Your review has been submitted for approval.</div>';
    }
    ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Package Name</th>
                            <th>Booking Date</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                            <th>Action</th> <!-- Review + Invoice -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                    b.id as booking_id,
                                    b.package_id,
                                    b.from_date, 
                                    b.paid_amount, 
                                    b.status, 
                                    p.package_name
                                FROM 
                                    tbl_booking as b 
                                JOIN 
                                    tbl_tourpackage as p 
                                ON 
                                    b.package_id = p.id 
                                WHERE 
                                    b.user_id = ? 
                                ORDER BY 
                                    b.created_at DESC";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // স্ট্যাটাস নির্ধারণ
                                if ($row['status'] == 0) {
                                    $status_text = 'Pending';
                                    $status_badge = 'warning';
                                } elseif ($row['status'] == 1) {
                                    $status_text = 'Confirmed';
                                    $status_badge = 'success';
                                } else {
                                    $status_text = 'Cancelled';
                                    $status_badge = 'danger';
                                }
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                    <td><?php echo date('d M, Y', strtotime($row['from_date'])); ?></td>
                                    <td>BDT <?php echo number_format($row['paid_amount']); ?>/-</td>
                                    <td>
                                        <span class="badge badge-<?php echo $status_badge; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 1): ?>
                                            <!-- Review Button -->
                                            <a href="add-testimonial.php?package_id=<?php echo $row['package_id']; ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                Write a Review
                                            </a>

                                            <!-- Invoice Button -->
                                            <a href="invoice_template.php?booking_id=<?php echo $row['booking_id']; ?>" 
                                               target="_blank" 
                                               class="btn btn-success btn-sm">
                                                View Invoice
                                            </a>
                                        <?php else: ?>
                                            <span>N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">You have not made any bookings yet.</td></tr>';
                        }
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
