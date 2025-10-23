<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';

$package_id = intval($_GET['id']);
$sql = "SELECT * FROM tbl_tourpackage WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $package_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$package = mysqli_fetch_assoc($result);
?>

<div class="container-fluid">
    <h2 class="mt-4">Edit Package: <?php echo htmlspecialchars($package['package_name']); ?></h2>
    <hr>
    <form action="partials/_packageManage.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
        <div class="form-group">
            <label>Package Name</label>
            <input type="text" name="package_name" class="form-control" value="<?php echo htmlspecialchars($package['package_name']); ?>" required>
            <!-- ছোট  update -->
            <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($package['package_image']); ?>">
            <!-- END update  -->
        </div>
        <div class="form-group">
            <label>Current Image:</label><br>
            <img src="../uploads/<?php echo $package['package_image']; ?>" width="150">
            <br><label class="mt-2">Change Image (optional):</label>
            <input type="file" name="package_image" class="form-control-file">
        </div>
        <button type="submit" name="update_package" class="btn btn-success">Update Package</button>
    </form>
</div>

<?php include 'partials/_footer.php'; ?>