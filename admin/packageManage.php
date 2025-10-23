<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Tour Packages</h2>
    <hr>
    
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPackageModal">
        <i class="fas fa-plus"></i> Create New Package
    </button>
    
    <?php
    if(isset($_SESSION['message'])){
        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
    }
    ?>

    <div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="partials/_packageManage.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Package</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"><label>Package Name</label><input type="text" name="package_name" class="form-control" required></div>
                        <div class="form-group"><label>Package Type</label><select name="package_type" class="form-control" required><?php $r = mysqli_query($conn, "SELECT * FROM tbl_packagetype"); while($rw = mysqli_fetch_assoc($r)){ echo "<option value='".$rw['id']."'>".htmlspecialchars($rw['package_type'])."</option>"; } ?></select></div>
                        <div class="form-group"><label>Package Location</label><input type="text" name="package_location" class="form-control" required></div>
                        <div class="form-group"><label>Price (BDT)</label><input type="number" name="package_price" class="form-control" required></div>
                        <div class="form-group"><label>Package Details</label><textarea name="package_details" class="form-control" rows="5" required></textarea></div>
                        <div class="form-group"><label>Package Image</label><input type="file" name="package_image" class="form-control-file" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_package" class="btn btn-success">Create Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPackageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="partials/_packageManage.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header"><h4 class="modal-title">Edit Package</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    <div class="modal-body">
                        <input type="hidden" name="package_id" id="editPackageId">
                        <input type="hidden" name="old_image" id="editOldImage">
                        <div class="form-group"><label>Package Name</label><input type="text" name="package_name" id="editPackageName" class="form-control" required></div>
                        <div class="form-group"><label>Package Type</label><select name="package_type" id="editPackageType" class="form-control" required><?php $result_types = mysqli_query($conn, "SELECT * FROM tbl_packagetype"); while($row_type = mysqli_fetch_assoc($result_types)){ echo "<option value='".$row_type['id']."'>".htmlspecialchars($row_type['package_type'])."</option>"; } ?></select></div>
                        <div class="form-group"><label>Package Location</label><input type="text" name="package_location" id="editPackageLocation" class="form-control" required></div>
                        <div class="form-group"><label>Price (BDT)</label><input type="number" name="package_price" id="editPackagePrice" class="form-control" required></div>
                        <div class="form-group"><label>Package Details</label><textarea name="package_details" id="editPackageDetails" class="form-control" rows="5" required></textarea></div>
                        <div class="form-group"><label>Current Image:</label><br><img src="" id="currentPackageImage" width="150" class="mb-2 img-thumbnail"><br><label class="mt-2">Change Image (optional):</label><input type="file" name="package_image" class="form-control-file"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="submit" name="update_package" class="btn btn-success">Update Package</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">All Packages</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_tourpackage ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['package_location']); ?></td>
                            <td><?php echo number_format($row['package_price']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info edit-btn"
                                        data-toggle="modal" data-target="#editPackageModal"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($row['package_name']); ?>"
                                        data-type="<?php echo $row['package_type']; ?>"
                                        data-location="<?php echo htmlspecialchars($row['package_location']); ?>"
                                        data-price="<?php echo $row['package_price']; ?>"
                                        data-details="<?php echo htmlspecialchars($row['package_details']); ?>"
                                        data-image="<?php echo htmlspecialchars($row['package_image']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="partials/_packageManage.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this package?');">
                                    <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_package" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var type = $(this).data('type');
        var location = $(this).data('location');
        var price = $(this).data('price');
        var details = $(this).data('details');
        var image = $(this).data('image');

        $('#editPackageId').val(id);
        $('#editPackageName').val(name);
        $('#editPackageType').val(type);
        $('#editPackageLocation').val(location);
        $('#editPackagePrice').val(price);
        $('#editPackageDetails').val(details);
        $('#editOldImage').val(image);
        $('#currentPackageImage').attr('src', '../uploads/' + image);
    });
});
</script>