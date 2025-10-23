<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';

// --- ১. মাসিক আয়ের রিপোর্ট (Monthly Income Report) ---
$monthly_income_sql = "SELECT DATE_FORMAT(b.created_at, '%Y-%m') AS month, SUM(p.package_price) AS total_income FROM tbl_booking AS b JOIN tbl_tourpackage AS p ON b.package_id = p.id WHERE b.status = 1 GROUP BY month ORDER BY month ASC";
$monthly_income_result = mysqli_query($conn, $monthly_income_sql);

// --- PHP: বার চার্টের জন্য ডেটা প্রস্তুত করা ---
$income_labels = [];
$income_data = [];
if ($monthly_income_result && mysqli_num_rows($monthly_income_result) > 0) {
    while($row = mysqli_fetch_assoc($monthly_income_result)){
        $income_labels[] = date("M, Y", strtotime($row['month']));
        $income_data[] = $row['total_income'];
    }
    mysqli_data_seek($monthly_income_result, 0); // পয়েন্টার রিসেট করা হচ্ছে টেবিলের জন্য
}

// --- ২. জনপ্রিয় প্যাকেজের রিপোর্ট (Most Popular Packages Report) ---
$popular_packages_sql = "SELECT p.package_name, COUNT(b.package_id) AS booking_count FROM tbl_booking AS b JOIN tbl_tourpackage AS p ON b.package_id = p.id GROUP BY p.package_name ORDER BY booking_count DESC LIMIT 5";
$popular_packages_result = mysqli_query($conn, $popular_packages_sql);

// --- PHP: পাই চার্টের জন্য ডেটা প্রস্তুত করা ---
$package_labels = [];
$package_data = [];
if ($popular_packages_result && mysqli_num_rows($popular_packages_result) > 0) {
    while($row = mysqli_fetch_assoc($popular_packages_result)){
        $package_labels[] = $row['package_name'];
        $package_data[] = $row['booking_count'];
    }
    mysqli_data_seek($popular_packages_result, 0); // পয়েন্টার রিসেট করা হচ্ছে টেবিলের জন্য
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Reports & Analytics</h2>
        <button id="print-btn" class="btn btn-primary"><i class="fas fa-print"></i> Print Report</button>
    </div>
    <hr>

    <div id="report-area">
        <h3 class="text-center mb-4">Tour Management System - Reports</h3>
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card"><div class="card-header"><i class="fas fa-chart-bar"></i> Monthly Income Chart</div><div class="card-body"><canvas id="monthlyIncomeChart"></canvas></div></div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card"><div class="card-header"><i class="fas fa-chart-pie"></i> Popular Packages Chart</div><div class="card-body"><canvas id="popularPackagesChart"></canvas></div></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header"><i class="fas fa-calendar-alt"></i> Monthly Income Report</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-light"><tr><th>Month</th><th>Total Income</th></tr></thead>
                            <tbody>
                                <?php if ($monthly_income_result && mysqli_num_rows($monthly_income_result) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($monthly_income_result)): ?>
                                        <tr><td><?php echo date("F, Y", strtotime($row['month'])); ?></td><td>BDT <?php echo number_format($row['total_income']); ?>/-</td></tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="text-center">No income data available.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header"><i class="fas fa-star"></i> Most Popular Packages</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-light"><tr><th>Package Name</th><th>Total Bookings</th></tr></thead>
                            <tbody>
                                <?php if ($popular_packages_result && mysqli_num_rows($popular_packages_result) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($popular_packages_result)): ?>
                                        <tr><td><?php echo htmlspecialchars($row['package_name']); ?></td><td><?php echo $row['booking_count']; ?></td></tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="text-center">No booking data available.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // বার চার্ট: মাসিক আয়
    const incomeCtx = document.getElementById('monthlyIncomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($income_labels); ?>,
            datasets: [{
                label: 'Total Income (BDT)',
                data: <?php echo json_encode($income_data); ?>,
                backgroundColor: 'rgba(13, 44, 78, 0.8)',
                borderColor: 'rgba(13, 44, 78, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // পাই চার্ট: জনপ্রিয় প্যাকেজ
    const packageCtx = document.getElementById('popularPackagesChart').getContext('2d');
    new Chart(packageCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($package_labels); ?>,
            datasets: [{
                label: 'Bookings',
                data: <?php echo json_encode($package_data); ?>,
                backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)'],
                hoverOffset: 4
            }]
        }
    });

    // প্রিন্ট বাটনের জন্য কোড
    document.getElementById('print-btn').addEventListener('click', function () {
        const element = document.getElementById('report-area');
        const opt = {
            margin: 0.5,
            filename: 'tms_report_<?php echo date("Y-m-d"); ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' } // ল্যান্ডস্কেপ করা হলো
        };
        html2pdf().from(element).set(opt).save();
    });
});
</script>