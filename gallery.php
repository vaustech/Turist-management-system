<?php 
include 'includes/header.php'; 
// Add lightgallery css in header if not already there
// <link rel="stylesheet" href="assets/css/lightgallery.css">
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Our Gallery</h2>
    <hr>
    <?php
    $sql = "SELECT * FROM tbl_gallery";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="gallery-location my-4">
        <h3><?php echo htmlspecialchars($row['location']); ?></h3>
        <div class="row" id="lightgallery-<?php echo $row['id']; ?>">
            <?php
            $images = explode(",", $row['images']);
            foreach($images as $img) {
                $img_path = 'uploads/gallery/' . trim($img);
                if (file_exists($img_path)) {
            ?>
            <div class="col-md-3 item" data-src="<?php echo $img_path; ?>">
                <a href="<?php echo $img_path; ?>">
                    <img src="<?php echo $img_path; ?>" class="img-fluid img-thumbnail" style="height: 200px; width: 100%; object-fit: cover;">
                </a>
            </div>
            <?php 
                }
            } 
            ?>
        </div>
    </div>
    <?php } ?>
</div>

<?php 
include 'includes/footer.php'; 
// Add lightgallery js in footer if not already there
// <script src="assets/js/lightgallery-all.min.js"></script>
// <script>
//  $('[id^="lightgallery-"]').lightGallery();
// </script>
?>