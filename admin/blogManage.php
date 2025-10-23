<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Blog Posts</h2>
    <hr>
    <a href="addBlog.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add New Post</a>
    
    <div class="card">
        <div class="card-header"><i class="fas fa-newspaper"></i> All Blog Posts</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_blog ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                            <td><?php echo ($row['status'] == 1) ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-warning">Draft</span>'; ?></td>
                            <td><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="editBlog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                <form action="partials/_blogManage.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_post" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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