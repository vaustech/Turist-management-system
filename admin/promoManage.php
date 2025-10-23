<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Promo Codes</h2>
    <hr>
    
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
        <i class="fas fa-plus"></i> Create New Promo Code
    </button>
    
    <?php
    if(isset($_SESSION['message'])){
        $msg_type = $_SESSION['msg_type'] ?? 'success';
        echo '<div class="alert alert-'.$msg_type.'">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="partials/_promoManage.php" method="POST">
                    <div class="modal-header"><h4 class="modal-title">Create Promo Code</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    <div class="modal-body">
                        <div class="form-group"><label>Promo Code</label><input type="text" name="promo_code" class="form-control" required></div>
                        <div class="form-group"><label>Discount Type</label><select name="discount_type" class="form-control" required><option value="percentage">Percentage (%)</option><option value="fixed">Fixed Amount (BDT)</option></select></div>
                        <div class="form-group"><label>Discount Value</label><input type="number" step="0.01" name="discount_value" class="form-control" required></div>
                        <div class="form-group"><label>Expiry Date</label><input type="date" name="expiry_date" class="form-control" required></div>
                        <div class="form-group"><label>Usage Limit</label><input type="number" name="usage_limit" class="form-control" value="1" required></div>
                        <div class="form-group"><label>Status</label><select name="is_active" class="form-control" required><option value="1">Active</option><option value="0">Inactive</option></select></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="submit" name="create_promo" class="btn btn-success">Create</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-tags"></i> All Promo Codes</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>Code</th><th>Type</th><th>Value</th><th>Expiry</th><th>Usage</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_promo_codes ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['promo_code']); ?></strong></td>
                            <td><?php echo ucfirst($row['discount_type']); ?></td>
                            <td><?php echo ($row['discount_type'] == 'percentage') ? $row['discount_value'].'%' : 'BDT '.number_format($row['discount_value']); ?></td>
                            <td><?php echo date('d M, Y', strtotime($row['expiry_date'])); ?></td>
                            <td><?php echo $row['usage_count'] . ' / ' . $row['usage_limit']; ?></td>
                            <td><?php echo ($row['is_active']) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                            <td>
                                <form action="partials/_promoManage.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="promo_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_promo" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>