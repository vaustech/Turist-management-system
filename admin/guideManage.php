<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Expert Guides</h2>
    <hr>
    
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addGuideModal">
        <i class="fas fa-plus"></i> Add New Guide
    </button>
    
    <?php
    if(isset($_SESSION['message'])){
        $msg_type = $_SESSION['msg_type'] ?? 'success';
        echo '<div class="alert alert-'.$msg_type.'">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="modal fade" id="addGuideModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="partials/_guideManage.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header"><h4 class="modal-title">Add New Guide</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    <div class="modal-body">
                        <div class="form-group"><label>Guide Name</label><input type="text" name="guide_name" class="form-control" required></div>
                        <div class="form-group"><label>Specialty</label><input type="text" name="guide_specialty" class="form-control" placeholder="e.g., Hill Tracts Specialist" required></div>
                        <div class="form-group"><label>Display Order</label><input type="number" name="display_order" class="form-control" value="0" required></div>
                        <div class="form-group"><label>Guide Image</label><input type="file" name="guide_image" class="form-control-file" required></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="submit" name="create_guide" class="btn btn-success">Add Guide</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGuideModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="partials/_guideManage.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header"><h4 class="modal-title">Edit Guide</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    <div class="modal-body">
                        <input type="hidden" name="guide_id" id="editGuideId">
                        <input type="hidden" name="old_image" id="editOldImage">
                        <div class="form-group"><label>Guide Name</label><input type="text" name="guide_name" id="editGuideName" class="form-control" required></div>
                        <div class="form-group"><label>Specialty</label><input type="text" name="guide_specialty" id="editGuideSpecialty" class="form-control" required></div>
                        <div class="form-group"><label>Display Order</label><input type="number" name="display_order" id="editDisplayOrder" class="form-control" required></div>
                        <div class="form-group">
                            <label>Current Image:</label><br>
                            <img src="" id="currentGuideImage" width="100" class="mb-2 img-thumbnail">
                            <br><label class="mt-2">Change Image (optional):</label>
                            <input type="file" name="guide_image" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="submit" name="update_guide" class="btn btn-success">Update Guide</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-user-tie"></i> All Guides</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Specialty</th><th>Order</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_guides ORDER BY display_order ASC, id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><img src="../uploads/guides/<?php echo htmlspecialchars($row['guide_image']); ?>" width="60" class="img-thumbnail"></td>
                            <td><?php echo htmlspecialchars($row['guide_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['guide_specialty']); ?></td>
                            <td><?php echo htmlspecialchars($row['display_order']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info edit-btn" data-toggle="modal" data-target="#editGuideModal"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($row['guide_name']); ?>"
                                        data-specialty="<?php echo htmlspecialchars($row['guide_specialty']); ?>"
                                        data-order="<?php echo $row['display_order']; ?>"
                                        data-image="<?php echo htmlspecialchars($row['guide_image']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="partials/_guideManage.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="guide_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_guide" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        $('#editGuideId').val($(this).data('id'));
        $('#editGuideName').val($(this).data('name'));
        $('#editGuideSpecialty').val($(this).data('specialty'));
        $('#editDisplayOrder').val($(this).data('order'));
        $('#editOldImage').val($(this).data('image'));
        $('#currentGuideImage').attr('src', '../uploads/guides/' + $(this).data('image'));
    });
});
</script>