<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';

// Note: This implementation is basic due to the database structure.
// A separate table for images would be more robust.
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Gallery</h2>
    <hr>
    
    <?php
    if(isset($_SESSION['message'])){
        echo '<div class="alert alert-'.(isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success').'">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="card">
        <div class="card-header">Add Images to Location</div>
        <div class="card-body">
            <form action="partials/_galleryManage.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Location Name</label>
                    <input type="text" name="location" class="form-control" placeholder="e.g., Kashmir" required>
                </div>
                <div class="form-group">
                    <label>Upload Images (you can select multiple)</label>
                    <input type="file" name="images[]" class="form-control-file" multiple required>
                </div>
                <button type="submit" name="upload_images" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>