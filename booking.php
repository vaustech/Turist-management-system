<?php 
include 'includes/header.php'; 

// ব্যবহারকারী লগইন করা না থাকলে লগইন পেজে পাঠান
if(!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] != true){
    header("Location: login.php?redirect_url=" . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// URL থেকে প্যাকেজ ও অ্যাভেইলেবিলিটি আইডি নেওয়া হচ্ছে
$pkgid = isset($_GET['pkgid']) ? intval($_GET['pkgid']) : 0;
$availid = isset($_GET['availid']) ? intval($_GET['availid']) : 0;

if ($pkgid === 0 || $availid === 0) {
    die("<div class='container my-5'><div class='alert alert-danger'>Invalid booking link. Please select a date from the package details page.</div></div>");
}

// প্যাকেজের তথ্য আনা হচ্ছে
$stmt_pkg = $conn->prepare("SELECT * FROM tbl_tourpackage WHERE id = ?");
$stmt_pkg->bind_param("i", $pkgid);
$stmt_pkg->execute();
$package = $stmt_pkg->get_result()->fetch_assoc();

// অ্যাভেইলেবিলিটির তথ্য আনা হচ্ছে
$stmt_avail = $conn->prepare("SELECT * FROM tbl_package_availability WHERE id = ?");
$stmt_avail->bind_param("i", $availid);
$stmt_avail->execute();
$availability = $stmt_avail->get_result()->fetch_assoc();

if (!$package || !$availability) {
    die("<div class='container my-5'><div class='alert alert-danger'>Booking details not found.</div></div>");
}

$available_seats = $availability['total_seats'] - $availability['booked_seats'];
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="text-center mb-4">Complete Your Booking</h2>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h4>You are booking: <strong><?php echo htmlspecialchars($package['package_name']); ?></strong></h4>
                    <h5>For Trip Date: <strong><?php echo date('d F, Y', strtotime($availability['trip_date'])); ?></strong></h5>
                    <p class="lead">Price per person: <strong class="text-success">BDT <?php echo number_format($package['package_price']); ?>/-</strong></p>
                    <p class="lead">Available Seats: <strong class="text-info"><?php echo $available_seats; ?></strong></p>
                </div>
            </div>

            <form action="handle_booking.php" method="POST" id="bookingForm">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" name="package_id" value="<?php echo $pkgid; ?>">
                        <input type="hidden" name="avail_id" value="<?php echo $availid; ?>">
                        <input type="hidden" name="price_per_person" id="price_per_person" value="<?php echo $package['package_price']; ?>">
                        
                        <div class="row">
    <div class="col-md-6 form-group">
        <label for="num_people">Number of People</label>
        <input type="number" name="num_people" id="num_people" class="form-control" value="1" min="1" max="<?php echo $available_seats; ?>" required>
    </div>
</div>
<div class="form-group">
    <label>Comment (Optional)</label>
    <textarea name="comment" class="form-control" rows="4" placeholder="Any special requests?"></textarea>
</div>

<hr>
<div class="form-group">
    <label>Have a Promo Code?</label>
    <div class="input-group">
        <input type="text" name="promo_code" id="promo_code_input" class="form-control" placeholder="Enter code">
        <div class="input-group-append">
            <button type="button" id="apply_promo_btn" class="btn btn-outline-secondary">Apply</button>
        </div>
    </div>
    <small id="promo_message" class="form-text"></small>
</div>
<hr>

<div id="price_summary">
    <p class="d-flex justify-content-between">Subtotal: <span id="subtotal_price">BDT 0/-</span></p>
    <p class="d-flex justify-content-between text-success">Discount: <span id="discount_amount">BDT 0/-</span></p>
    <h5 class="d-flex justify-content-between">Grand Total: <span id="grand_total_price">BDT 0/-</span></h5>
</div>

                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#paymentModal">
                            Proceed to Payment
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <p class="mb-0">Please send the required payment to the number below and enter the transaction details.</p>
                    <hr>
                    <p class="mb-0"><strong>bKash / Nagad / Rocket:</strong> 01310483165</p>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">Select Method</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Upay">Upay</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Paid Amount</label>
                        <input type="number" name="paid_amount" class="form-control" placeholder="e.g., 5000" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Transaction ID / Details</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="e.g., 9J7K3L2M1N" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="submit_booking" class="btn btn-success">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const numPeopleInput = document.getElementById('num_people');
    const pricePerPerson = parseFloat(document.getElementById('price_per_person').value);
    
    const subtotalPriceElem = document.getElementById('subtotal_price');
    const discountAmountElem = document.getElementById('discount_amount');
    const grandTotalPriceElem = document.getElementById('grand_total_price');
    
    const applyBtn = document.getElementById('apply_promo_btn');
    const promoCodeInput = document.getElementById('promo_code_input');
    const promoMessageElem = document.getElementById('promo_message');

    let currentDiscount = 0;

    function updateTotalPrice() {
        const numPeople = parseInt(numPeopleInput.value) || 0;
        const subtotal = numPeople * pricePerPerson;
        const grandTotal = subtotal - currentDiscount;

        subtotalPriceElem.textContent = 'BDT ' + subtotal.toLocaleString() + '/-';
        discountAmountElem.textContent = 'BDT ' + currentDiscount.toLocaleString() + '/-';
        grandTotalPriceElem.textContent = 'BDT ' + grandTotal.toLocaleString() + '/-';
    }

    applyBtn.addEventListener('click', function() {
        const promoCode = promoCodeInput.value;
        const subtotal = parseInt(numPeopleInput.value) * pricePerPerson;

        // AJAX (Fetch API) ব্যবহার করে সার্ভারে রিকোয়েস্ট পাঠানো হচ্ছে
        fetch('apply_promo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'promo_code=' + encodeURIComponent(promoCode) + '&subtotal=' + subtotal
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                currentDiscount = data.discount;
                promoMessageElem.textContent = data.message;
                promoMessageElem.className = 'form-text text-success';
            } else {
                currentDiscount = 0;
                promoMessageElem.textContent = data.message;
                promoMessageElem.className = 'form-text text-danger';
            }
            updateTotalPrice();
        })
        .catch(error => {
            console.error('Error:', error);
            promoMessageElem.textContent = 'An error occurred. Please try again.';
            promoMessageElem.className = 'form-text text-danger';
        });
    });

    numPeopleInput.addEventListener('input', function() {
        // ব্যবহারকারী লোক সংখ্যা পরিবর্তন করলে ডিসকাউন্ট রিসেট হয়ে যাবে
        if (currentDiscount > 0) {
            currentDiscount = 0;
            promoCodeInput.value = '';
            promoMessageElem.textContent = 'Number of people changed. Please apply promo code again.';
            promoMessageElem.className = 'form-text text-warning';
        }
        updateTotalPrice();
    });

    updateTotalPrice(); // Initial calculation
});
</script>

<?php include 'includes/footer.php'; ?>