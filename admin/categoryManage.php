<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Categories</h2>
    <hr>
    
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">
        <i class="fas fa-plus"></i> Create New Category
    </button>
    
    <?php
    if (isset($_SESSION['message'])) {
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success';
        echo '<div class="alert alert-' . $msg_type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="partials/_categoryManage.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="categoryName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_category" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="partials/_categoryManage.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="category_id" id="editCategoryId">
                        <div class="form-group">
                            <label for="editCategoryName">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="editCategoryName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update_category" class="btn btn-success">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">All Package Categories</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th>Category Name</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_packagetype ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['package_type']); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info edit-btn" 
                                    data-toggle="modal" 
                                    data-target="#editCategoryModal"
                                    data-id="<?php echo $row['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($row['package_type']); ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="partials/_categoryManage.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                <input type="hidden" name="category_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_category" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // যখন কোনো Edit বাটনে ক্লিক করা হবে
    $('.edit-btn').on('click', function() {
        // বাটন থেকে ডেটাগুলো নাও
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');

        // মডালের ইনপুট ফিল্ডগুলোতে ডেটাগুলো বসিয়ে দাও
        $('#editCategoryId').val(categoryId);
        $('#editCategoryName').val(categoryName);
    });
});
</script>