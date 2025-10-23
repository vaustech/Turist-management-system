<?php 
include 'includes/header.php'; 

// ডিফল্ট ভেরিয়েবল সেট করা হচ্ছে
$user_name = '';
$user_email = '';
$user_phone = '';

// ব্যবহারকারী লগইন করা থাকলে, তার তথ্যগুলো আনা হচ্ছে
if (isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] === true) {
    $user_id = $_SESSION['user_id'];
    
    // tbl_userregistration থেকে ব্যবহারকারীর তথ্য আনা হচ্ছে
    $stmt_user = $conn->prepare("SELECT name, emailid, mobile FROM tbl_userregistration WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    
    if($result_user->num_rows > 0) {
        $user_data = $result_user->fetch_assoc();
        $user_name = htmlspecialchars($user_data['name']);
        $user_email = htmlspecialchars($user_data['emailid']);
        $user_phone = htmlspecialchars($user_data['mobile']);
    }
    $stmt_user->close();
}
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2>Create Your Custom Trip</h2>
        <p class="lead">Tell us your travel preferences, and we'll create a personalized itinerary just for you!</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="handle_trip_planner.php" method="POST">
                        <h4 class="mb-4">Contact Information</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="<?php echo $user_name; ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user_email; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $user_phone; ?>" required>
                        </div>
                        <hr class="my-4">
                        <h4 class="mb-4">Trip Details</h4>
                        <div class="form-group">
                            <label>Preferred Destination(s)</label>
                            <input type="text" name="destination" class="form-control" placeholder="e.g., Sundarbans, Sylhet, Bandarban" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Number of Travelers</label>
                                <input type="number" name="num_travelers" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Budget Per Person (BDT)</label>
                                <select name="budget_per_person" class="form-control" required>
                                    <option value="5000-10000">5,000 - 10,000</option>
                                    <option value="10000-20000">10,000 - 20,000</option>
                                    <option value="20000-30000">20,000 - 30,000</option>
                                    <option value="30000+">30,000+</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Trip Type</label>
                            <select name="trip_type" class="form-control" required>
                                <option value="Adventure & Trekking">Adventure & Trekking</option>
                                <option value="Relaxation & Leisure">Relaxation & Leisure</option>
                                <option value="Cultural & Historical">Cultural & Historical</option>
                                <option value="Family Fun">Family Fun</option>
                                <option value="Romantic Getaway">Romantic Getaway</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Additional Interests (Optional)</label>
                            <textarea name="interests" class="form-control" rows="4" placeholder="e.g., Photography, Local food, Boating..."></textarea>
                        </div>
                        <button type="submit" name="submit_trip_plan" class="btn btn-primary btn-block">Submit My Trip Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>