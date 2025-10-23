<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <h2 class="text-center mb-5">Our Travel Blog & Guides</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM tbl_blog WHERE status = 1 ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card package-card h-100">
                <img src="uploads/blog/<?php echo htmlspecialchars($row['featured_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text text-muted small">By <?php echo htmlspecialchars($row['author_name']); ?> on <?php echo date('d M, Y', strtotime($row['created_at'])); ?></p>
                    <p class="card-text"><?php echo substr(strip_tags($row['content']), 0, 100); ?>...</p>
                    <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary mt-auto">Read More</a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-12'><p class='text-center'>No blog posts found.</p></div>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>