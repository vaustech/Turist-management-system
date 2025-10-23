<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <h2 class="text-center mb-4">All Tour Packages</h2>

    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">Find Your Perfect Trip</h4>
            <form action="popular-package.php" method="GET">
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label>Destination</label>
                        <input type="text" name="destination" class="form-control" placeholder="e.g., Cox's Bazar, Sundarban" value="<?php echo isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : ''; ?>">
                    </div>
                    <div class="col-md-5 form-group">
                        <label>Budget Range (Per Person)</label>
                        <select name="budget" class="form-control">
                            <option value="">Select Budget</option>
                            <option value="0-10000" <?php if(isset($_GET['budget']) && $_GET['budget'] == '0-10000') echo 'selected'; ?>>Under 10,000 BDT</option>
                            <option value="10001-20000" <?php if(isset($_GET['budget']) && $_GET['budget'] == '10001-20000') echo 'selected'; ?>>10,001 - 20,000 BDT</option>
                            <option value="20001-30000" <?php if(isset($_GET['budget']) && $_GET['budget'] == '20001-30000') echo 'selected'; ?>>20,001 - 30,000 BDT</option>
                            <option value="30001" <?php if(isset($_GET['budget']) && $_GET['budget'] == '30001') echo 'selected'; ?>>30,001+ BDT</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php
    // SQL কুয়েরি এবং পেজিনেশন লজিক
    $today = date('Y-m-d');
    
    $base_sql = " FROM tbl_tourpackage AS p
                 LEFT JOIN tbl_package_availability AS av ON p.id = av.package_id AND av.trip_date >= ?
                 WHERE 1=1";
    $params = [$today];
    $types = 's';

    // Destination অনুযায়ী ফিল্টার
    if (!empty($_GET['destination'])) {
        $destination = "%" . $_GET['destination'] . "%";
        $base_sql .= " AND p.package_location LIKE ?";
        $params[] = $destination;
        $types .= 's';
    }

    // Budget অনুযায়ী ফিল্টার
    if (!empty($_GET['budget'])) {
        $budget = $_GET['budget'];
        if ($budget == '30001') {
            $base_sql .= " AND p.package_price >= ?";
            $params[] = 30001;
            $types .= 'i';
        } else {
            $budget_range = explode('-', $budget);
            if(count($budget_range) == 2) {
                $base_sql .= " AND p.package_price BETWEEN ? AND ?";
                $params[] = (int)$budget_range[0];
                $params[] = (int)$budget_range[1];
                $types .= 'ii';
            }
        }
    }
    
    $group_by_sql = " GROUP BY p.id";

    // পেজিনেশন লজিক
    $records_per_page = 6;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($current_page < 1) $current_page = 1;
    $offset = ($current_page - 1) * $records_per_page;

    // =======================================================
    //  এখানে ভুলটি সংশোধন করা হয়েছে
    // =======================================================
    // মোট রেকর্ডের সংখ্যা বের করা (সার্চ ফিল্টারসহ)
    $total_records_sql = "SELECT COUNT(DISTINCT p.id) as total" . $base_sql;
    $stmt_total = mysqli_prepare($conn, $total_records_sql);
    // মূল $params এবং $types ব্যবহার করতে হবে কারণ তারিখের প্যারামিটারটিও প্রয়োজন
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt_total, $types, ...$params);
    }
    mysqli_stmt_execute($stmt_total);
    $total_result = mysqli_stmt_get_result($stmt_total);
    $total_records = mysqli_fetch_assoc($total_result)['total'];
    $total_pages = ceil($total_records / $records_per_page);
    ?>

    <div class="row">
        <?php
        // প্যাকেজ দেখানোর জন্য ফাইনাল SQL কুয়েরি
        $sql = "SELECT p.*, 
                       SUM(av.total_seats) AS total_capacity, 
                       SUM(av.booked_seats) AS total_booked " 
               . $base_sql . $group_by_sql . " ORDER BY p.package_name ASC LIMIT ? OFFSET ?";
        
        $final_params = $params;
        $final_params[] = $records_per_page;
        $final_params[] = $offset;
        $final_types = $types . 'ii';

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $final_types, ...$final_params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $available_seats = 0;
                if ($row['total_capacity'] !== null) {
                    $available_seats = $row['total_capacity'] - $row['total_booked'];
                }
        ?>
        <div class="col-md-4">
            <div class="card package-card mb-4 h-100">
                <img src="uploads/<?php echo htmlspecialchars($row['package_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['package_name']); ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['package_name']); ?></h5>
                    <p class="card-text"><b>Location:</b> <?php echo htmlspecialchars($row['package_location']); ?></p>
                    <h6 class="price">Price: BDT <?php echo number_format($row['package_price']); ?>/-</h6>
                    
                    <div class="mt-auto">
                        <p class="card-text mb-2">
                            <b>Available Seats:</b> 
                            <span class="font-weight-bold <?php echo ($available_seats > 0) ? 'text-success' : 'text-danger'; ?>">
                                <?php echo $available_seats; ?>
                            </span>
                        </p>

                        <?php if ($available_seats > 0): ?>
                            <a href="package-details.php?pkgid=<?php echo $row['id']; ?>" class="btn btn-success btn-block">View Details</a>
                        <?php else: ?>
                            <button class="btn btn-danger btn-block" disabled>Fully Booked</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-warning text-center'>No packages found matching your criteria.</div></div>";
        }
        ?>
    </div>

    <?php 
    $query_params = $_GET;
    if (isset($query_params['page'])) {
        unset($query_params['page']);
    }

    if ($total_pages > 1): 
    ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1; ?>&<?php echo http_build_query($query_params); ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&<?php echo http_build_query($query_params); ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            
            <?php if ($current_page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1; ?>&<?php echo http_build_query($query_params); ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>