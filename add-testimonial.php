<?php 
include 'includes/header.php'; 

// Check if user is logged in
if(!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] != true){
    header("Location: login.php");
    exit;
}

// Get package ID from URL and validate
$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;
if ($package_id === 0) {
    die("<div class='container my-5'><div class='alert alert-danger'>Invalid request. Please go back to your booking history page.</div></div>");
}

// Fetch package name to display
$stmt_pkg = $conn->prepare("SELECT package_name FROM tbl_tourpackage WHERE id = ?");
$stmt_pkg->bind_param("i", $package_id);
$stmt_pkg->execute();
$package = $stmt_pkg->get_result()->fetch_assoc();
$package_name = $package ? htmlspecialchars($package['package_name']) : 'this package';
$stmt_pkg->close();

?>
<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    font-size: 2rem;
}
.star-rating input { display: none; }
.star-rating label {
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f5b301;
}
</style>

<<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="text-center">Share Your Experience for "<?php echo $package_name; ?>"</h3></div>
                <div class="card-body">
                    <form action="handle_testimonial.php" method="POST" enctype="multipart/form-data">
                        <!-- Hidden input to send package_id -->
                        <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                        
                        <div class="form-group text-center">
                            <label>Your Rating</label>
                            <div class="star-rating">
                                <input type="radio" id="5-stars" name="rating" value="5" required /><label for="5-stars" class="star">&#9733;</label>
                                <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars" class="star">&#9733;</label>
                                <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="star">&#9733;</label>
                                <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="star">&#9733;</label>
                                <input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" class="star">&#9733;</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Testimonial</label>
                            <textarea name="message" id="message" class="form-control" rows="6" placeholder="Write about your amazing journey..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="user_image">Upload Your Photo (Optional)</label>
                            <input type="file" name="user_image" id="user_image" class="form-control-file">
                        </div>
                        <button type="submit" name="submit_testimonial" class="btn btn-primary btn-block">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>






