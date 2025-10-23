<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id === 0) {
    die("Invalid Post ID.");
}

$stmt = $conn->prepare("SELECT * FROM tbl_blog WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    die("Post not found.");
}
?>

<div class="container-fluid">
    <h2 class="mt-4">Edit Blog Post</h2>
    <hr>
    <div class="card">
        <div class="card-body">
            <form action="partials/_blogManage.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <input type="hidden" name="old_image" value="<?php echo $post['featured_image']; ?>">
                
                <div class="form-group">
                    <label>Post Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Post Content</label>
                    <textarea name="content" class="form-control" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Author Name</label>
                    <input type="text" name="author_name" class="form-control" value="<?php echo htmlspecialchars($post['author_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Tags (comma separated)</label>
                    <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($post['tags']); ?>">
                </div>
                <div class="form-group">
                    <label>Current Image:</label><br>
                    <img src="../uploads/blog/<?php echo $post['featured_image']; ?>" width="150" class="img-thumbnail mb-2"><br>
                    <label>Change Image (optional):</label>
                    <input type="file" name="featured_image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?php if($post['status']==1) echo 'selected'; ?>>Published</option>
                        <option value="0" <?php if($post['status']==0) echo 'selected'; ?>>Draft</option>
                    </select>
                </div>
                <button type="submit" name="update_post" class="btn btn-success">Update Post</button>
            </form>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>
