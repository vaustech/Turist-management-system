<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Bookings</h2>
    <hr>
    
    <?php
    if(isset($_SESSION['message'])){
        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
    }
    ?>

    <form action="partials/_bookManage.php" method="POST">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-check"></i> All Bookings</span>
                <button type="submit" name="delete_selected" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete the selected bookings?');">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">Select All<br><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>User & Package</th>
                                <th>Booking Dates</th>
                                <th>Payment Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT b.id as booking_id, u.name as user_name, p.package_name, b.from_date, b.to_date, b.comment, b.status, b.payment_method, b.transaction_id, b.paid_amount FROM tbl_booking as b LEFT JOIN tbl_userregistration as u ON b.user_id = u.id LEFT JOIN tbl_tourpackage as p ON b.package_id = p.id ORDER BY b.id DESC";
                            $result = mysqli_query($conn, $sql);
                            $i = 1;
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><input type="checkbox" name="booking_ids[]" class="booking-checkbox" value="<?php echo $row['booking_id']; ?>"></td>
                                <td><?php echo $i++; ?></td>
                                <td><strong>User:</strong> <?php echo htmlspecialchars($row['user_name'] ?? 'N/A'); ?><br><strong>Package:</strong> <?php echo htmlspecialchars($row['package_name'] ?? 'N/A'); ?></td>
                                <td><strong>From:</strong> <?php echo date('d M Y', strtotime($row['from_date'])); ?><br><strong>To:</strong> <?php echo date('d M Y', strtotime($row['to_date'])); ?></td>
                                <td><strong>Method:</strong> <?php echo htmlspecialchars($row['payment_method']); ?><br><strong>Amount:</strong> BDT <?php echo number_format($row['paid_amount']); ?>/-<br><strong>TrxID:</strong> <?php echo htmlspecialchars($row['transaction_id']); ?></td>
                                <td>
                                    <?php 
                                    if($row['status'] == 0) echo '<span class="badge badge-warning">Pending</span>';
                                    elseif($row['status'] == 1) echo '<span class="badge badge-success">Confirmed</span>';
                                    else echo '<span class="badge badge-danger">Cancelled</span>';
                                    ?>
                                </td>
                                <td>
                                    <form action="partials/_bookManage.php" method="POST" class="d-inline">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <?php if($row['status'] == 0): ?>
                                        <button type="submit" name="confirm_booking" class="btn btn-sm btn-success mb-1" title="Confirm Booking"><i class="fas fa-check"></i></button>
                                        <button type="submit" name="cancel_booking" class="btn btn-sm btn-danger" title="Cancel Booking"><i class="fas fa-times"></i></button>
                                        <?php elseif($row['status'] == 1): ?>
                                        <button type="submit" name="cancel_booking" class="btn btn-sm btn-danger" title="Cancel Booking"><i class="fas fa-times"></i></button>
                                        <?php else: echo "N/A"; endif; ?>
                                    </form>
                                </td>
                            </tr>
                            <?php } } else { echo "<tr><td colspan='7' class='text-center'>No bookings found.</td></tr>"; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include 'partials/_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.booking-checkbox');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });
});
</script>