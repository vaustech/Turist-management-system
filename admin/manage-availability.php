<?php
require_once('../includes/_dbconnect.php');
include('partials/_nav.php');

// ===================================
//  ফর্ম সাবমিশন হ্যান্ডেল করা
// ===================================

// নতুন অ্যাভেইলেবিলিটি যোগ করা
if (isset($_POST['add_availability'])) {
    $package_id = intval($_POST['package_id']);
    $trip_date = $_POST['trip_date'];
    $total_seats = intval($_POST['total_seats']);

    if ($package_id > 0 && !empty($trip_date) && $total_seats > 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_package_availability (package_id, trip_date, total_seats) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $package_id, $trip_date, $total_seats);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Availability added successfully!";
        } else {
            $_SESSION['message'] = "Error: Could not add availability.";
            $_SESSION['msg_type'] = 'danger';
        }
        $stmt->close();
    }
    header("Location: manage-availability.php?pkgid=" . $package_id);
    exit();
}

// অ্যাভেইলেবিলিটি ডিলিট করা
if (isset($_POST['delete_availability'])) {
    $availability_id = intval($_POST['availability_id']);
    $package_id = intval($_POST['package_id']);
    
    $stmt = $conn->prepare("DELETE FROM tbl_package_availability WHERE id = ?");
    $stmt->bind_param("i", $availability_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Availability deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete availability.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: manage-availability.php?pkgid=" . $package_id);
    exit();
}

// URL থেকে প্যাকেজ আইডি নেওয়া হচ্ছে
$selected_pkg_id = isset($_GET['pkgid']) ? intval($_GET['pkgid']) : 0;
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Package Availability</h2>
    <hr>
    
    <?php
    if(isset($_SESSION['message'])){
        $msg_type = $_SESSION['msg_type'] ?? 'success';
        echo '<div class="alert alert-'.$msg_type.'">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="card mb-4">
        <div class="card-header">Select a Package to Manage</div>
        <div class="card-body">
            <form action="manage-availability.php" method="GET">
                <div class="form-group">
                    <label for="pkgid">Tour Package</label>
                    <select name="pkgid" id="pkgid" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Select a Package --</option>
                        <?php
                        $sql_packages = "SELECT id, package_name FROM tbl_tourpackage ORDER BY package_name ASC";
                        $result_packages = mysqli_query($conn, $sql_packages);
                        while($row = mysqli_fetch_assoc($result_packages)) {
                            $selected = ($row['id'] == $selected_pkg_id) ? 'selected' : '';
                            echo "<option value='{$row['id']}' {$selected}>" . htmlspecialchars($row['package_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <?php if ($selected_pkg_id > 0): ?>
        <?php 
            $pkg_name_stmt = $conn->prepare("SELECT package_name FROM tbl_tourpackage WHERE id = ?");
            $pkg_name_stmt->bind_param("i", $selected_pkg_id);
            $pkg_name_stmt->execute();
            $pkg_name_result = $pkg_name_stmt->get_result();
            $pkg_name_row = $pkg_name_result->fetch_assoc();
            $selected_pkg_name = $pkg_name_row['package_name'];
        ?>

        <div class="card mb-4">
            <div class="card-header">Add New Availability for: <strong><?php echo htmlspecialchars($selected_pkg_name); ?></strong></div>
            <div class="card-body">
                <form action="manage-availability.php" method="POST">
                    <input type="hidden" name="package_id" value="<?php echo $selected_pkg_id; ?>">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label>Trip Date</label>
                            <input type="date" name="trip_date" class="form-control" required>
                        </div>
                        <div class="col-md-5 form-group">
                            <label>Total Seats</label>
                            <input type="number" name="total_seats" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-2 form-group d-flex align-items-end">
                            <button type="submit" name="add_availability" class="btn btn-primary btn-block">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fas fa-calendar-alt"></i> Scheduled Dates</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>Trip Date</th><th>Total Seats</th><th>Booked Seats</th><th>Available Seats</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt_avail = $conn->prepare("SELECT * FROM tbl_package_availability WHERE package_id = ? ORDER BY trip_date ASC");
                        $stmt_avail->bind_param("i", $selected_pkg_id);
                        $stmt_avail->execute();
                        $result_avail = $stmt_avail->get_result();
                        if ($result_avail->num_rows > 0) {
                            while($row_avail = $result_avail->fetch_assoc()){
                                $available_seats = $row_avail['total_seats'] - $row_avail['booked_seats'];
                        ?>
                        <tr>
                            <td><?php echo date('d M, Y', strtotime($row_avail['trip_date'])); ?></td>
                            <td><?php echo $row_avail['total_seats']; ?></td>
                            <td><?php echo $row_avail['booked_seats']; ?></td>
                            <td><?php echo $available_seats; ?></td>
                            <td>
                                <form action="manage-availability.php" method="POST" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="availability_id" value="<?php echo $row_avail['id']; ?>">
                                    <input type="hidden" name="package_id" value="<?php echo $selected_pkg_id; ?>">
                                    <button type="submit" name="delete_availability" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php } } else { echo "<tr><td colspan='5' class='text-center'>No dates scheduled for this package yet.</td></tr>"; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'partials/_footer.php'; ?>