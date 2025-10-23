<?php
// প্রয়োজনীয় ফাইল যুক্ত করা হচ্ছে
require_once('../includes/_dbconnect.php');
include('partials/_nav.php'); 
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Custom Trip Requests</h2>
    <hr>
    
    <?php
    // সেশনে কোনো মেসেজ থাকলে তা দেখানোর জন্য
    if (isset($_SESSION['message'])) {
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success';
        echo '<div class="alert alert-' . $msg_type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-route"></i> All Custom Trip Requests
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Contact Info</th>
                            <th>Destination</th>
                            <th>Trip Dates</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_customtrips ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                // স্ট্যাটাস অনুযায়ী ব্যাজের রঙ পরিবর্তন
                                $status_badge = 'info';
                                if ($row['status'] == 'Confirmed') $status_badge = 'success';
                                if ($row['status'] == 'Rejected') $status_badge = 'danger';
                                if ($row['status'] == 'Contacted') $status_badge = 'warning';
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <strong>Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?><br>
                                        <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?><br>
                                        <strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                                    <td>
                                        <strong>From:</strong> <?php echo date('d M, Y', strtotime($row['from_date'])); ?><br>
                                        <strong>To:</strong> <?php echo date('d M, Y', strtotime($row['to_date'])); ?>
                                    </td>
                                    <td>
                                        <strong>Travelers:</strong> <?php echo htmlspecialchars($row['num_travelers']); ?><br>
                                        <strong>Budget:</strong> <?php echo htmlspecialchars($row['budget_per_person']); ?> BDT<br>
                                        <strong>Type:</strong> <?php echo htmlspecialchars($row['trip_type']); ?>
                                    </td>
                                    <td><span class="badge badge-<?php echo $status_badge; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info update-status-btn" 
                                                data-toggle="modal" 
                                                data-target="#statusModal"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-status="<?php echo htmlspecialchars($row['status']); ?>">
                                            <i class="fas fa-edit"></i> Update
                                        </button>

                                        <form action="partials/_customTripManage.php" method="POST" class="d-inline mt-1" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_request" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-center">No trip requests found yet.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="partials/_customTripManage.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Update Request Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="request_id" id="modal_request_id">
                    <div class="form-group">
                        <label>New Status</label>
                        <select name="new_status" id="modal_new_status" class="form-control" required>
                            <option value="New">New</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_status" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php 
include('partials/_footer.php'); 
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.update-status-btn').on('click', function() {
        var requestId = $(this).data('id');
        var currentStatus = $(this).data('status');
        
        $('#modal_request_id').val(requestId);
        $('#modal_new_status').val(currentStatus);
    });
});
</script>