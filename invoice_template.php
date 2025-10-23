<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('includes/_dbconnect.php');

// ইউজার লগইন চেক
if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true) {
    die("Authentication required.");
}

$user_id    = $_SESSION['user_id'];
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

$sql = "SELECT b.*, u.name as user_name, u.emailid as user_email,
               p.package_name, p.package_price
        FROM tbl_booking b
        JOIN tbl_userregistration u ON b.user_id = u.id
        JOIN tbl_tourpackage p ON b.package_id = p.id
        WHERE b.id=? AND b.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$details = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$details) {
    die("Invoice not found or access denied.");
}

$subtotal     = $details['package_price'] * $details['num_people'];
$total_amount = $subtotal - $details['discount_amount'];
$balance_due  = $total_amount - $details['paid_amount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $details['id']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { font-size: 14px; }
        .invoice-box { max-width: 900px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .invoice-header img { max-height: 60px; }
        .invoice-header { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        .table th { background: #f8f9fa; }
        .total-row { font-weight: bold; background: #eafbea; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="invoice-box">

    <div class="invoice-header d-flex justify-content-between align-items-center">
        <div>
            <img src="assets/images/logo.png" alt="Logo"><br>
            <strong>Porjotok Travel Agency</strong><br>
            Nurjahan Sharif Plaza, Purana Paltan, Dhaka-1200
        </div>
        <div>
            <h4>Invoice #<?php echo $details['id']; ?></h4>
            <small><?php echo date("d M, Y"); ?></small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h6>Customer Info</h6>
            <p>
                <?php echo htmlspecialchars($details['user_name']); ?><br>
                <?php echo htmlspecialchars($details['user_email']); ?>
            </p>
        </div>
        <div class="col-md-6 text-right">
            <h6>Booking Details</h6>
            <p>
                Booking Date: <?php echo date("d M, Y", strtotime($details['created_at'])); ?><br>
                Trip Date: <?php echo date("d M, Y", strtotime($details['from_date'])); ?><br>
                Payment Method: <?php echo htmlspecialchars($details['payment_method']); ?><br>
                Transaction ID: <?php echo htmlspecialchars($details['transaction_id']); ?>
            </p>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Package</th>
                <th>People</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo htmlspecialchars($details['package_name']); ?></td>
                <td><?php echo $details['num_people']; ?></td>
                <td><?php echo number_format($details['package_price']); ?> BDT</td>
                <td><?php echo number_format($subtotal); ?> BDT</td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class="table table-sm">
                <tr>
                    <th class="text-right">Discount</th>
                    <td class="text-right"><?php echo number_format($details['discount_amount']); ?> BDT</td>
                </tr>
                <tr class="total-row">
                    <th class="text-right">Total</th>
                    <td class="text-right"><?php echo number_format($total_amount); ?> BDT</td>
                </tr>
                <tr>
                    <th class="text-right">Paid</th>
                    <td class="text-right"><?php echo number_format($details['paid_amount']); ?> BDT</td>
                </tr>
                <tr class="total-row">
                    <th class="text-right">Balance Due</th>
                    <td class="text-right"><?php echo number_format($balance_due); ?> BDT</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <p>Thank you for booking with us!</p>
        <small>This is a computer-generated invoice and does not require signature.</small>
    </div>

    <div class="text-center no-print mt-3">
        <button onclick="window.print()" class="btn btn-primary">Print / Save PDF</button>
    </div>

</div>
</body>
</html>
