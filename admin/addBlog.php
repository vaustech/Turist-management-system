<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Add New Blog Post</h2>
    <hr>
    <div class="card">
        <div class="card-body">
            <form action="partials/_blogManage.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Post Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Post Content</label>
                    <textarea name="content" class="form-control" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label>Author Name</label>
                    <input type="text" name="author_name" class="form-control" value="Admin" required>
                </div>
                <div class="form-group">
                    <label>Tags (comma separated)</label>
                    <input type="text" name="tags" class="form-control" placeholder="e.g., travel, sundarbans, adventure">
                </div>
                <div class="form-group">
                    <label>Featured Image</label>
                    <input type="file" name="featured_image" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Published</option>
                        <option value="0">Draft</option>
                    </select>
                </div>
                <button type="submit" name="add_post" class="btn btn-success">Save Post</button>
            </form>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>
