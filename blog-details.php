<?php 
include 'includes/header.php'; 

// URL থেকে পোস্টের ID নেওয়া হচ্ছে
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id === 0) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Invalid blog post link.</div></div>";
    include 'includes/footer.php';
    exit;
}

// ডাটাবেস থেকে নির্দিষ্ট পোস্টের তথ্য আনা হচ্ছে
$stmt = $conn->prepare("SELECT * FROM tbl_blog WHERE id = ? AND status = 1");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Blog post not found or is not published yet.</div></div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- পোস্টের শিরোনাম -->
            <h1 class="mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
            
            <!-- লেখকের তথ্য -->
            <p class="text-muted">
                <i class="fas fa-user"></i> By <?php echo htmlspecialchars($post['author_name']); ?> | 
                <i class="fas fa-calendar-alt"></i> <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
            </p>
            
            <hr>

            <!-- ফিচার্ড ইমেজ -->
            <img src="uploads/blog/<?php echo htmlspecialchars($post['featured_image']); ?>" class="img-fluid rounded shadow-sm mb-4" alt="<?php echo htmlspecialchars($post['title']); ?>">
            
            <!-- পোস্টের সম্পূর্ণ লেখা -->
            <div class="blog-content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>

            <hr class="mt-5">

            <!-- ট্যাগস (যদি থাকে) -->
            <?php if (!empty($post['tags'])): ?>
            <div class="tags-section">
                <strong>Tags:</strong>
                <?php 
                $tags = explode(',', $post['tags']);
                foreach ($tags as $tag):
                ?>
                    <span class="badge badge-info"><?php echo htmlspecialchars(trim($tag)); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <a href="blog.php" class="btn btn-outline-primary mt-4"><i class="fas fa-arrow-left"></i> Back to Blog</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
