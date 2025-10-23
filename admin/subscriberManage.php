<?php
// প্রয়োজনীয় ফাইল যুক্ত করা হচ্ছে
include('../includes/_dbconnect.php'); // আপনার ডাটাবেস কানেকশন ফাইলের সঠিক পথ
include('partials/_nav.php'); 
// --- ডিলেট করার জন্য PHP কোড ---
if (isset($_POST['delete_id'])) {
    $id_to_delete = $_POST['delete_id'];
    
    // SQL Injection থেকে সুরক্ষিত করার জন্য prepared statement ব্যবহার করা হচ্ছে
    $stmt = $conn->prepare("DELETE FROM tbl_subscribers WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    
    if ($stmt->execute()) {
        // সফলভাবে ডিলেট হলে একটি বার্তা দেখানো হচ্ছে
        echo "<script>alert('Subscriber deleted successfully.');</script>";
        // পেজটি রিফ্রেশ করা হচ্ছে যাতে তালিকা আপডেট হয়ে যায়
        echo "<script>window.location = 'subscriberManage.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Subscribers</h2>
    <hr>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            All Subscriber Emails
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Subscribed On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ডাটাবেস থেকে সকল সাবস্ক্রাইবারের তথ্য আনা হচ্ছে
                        $sql = "SELECT * FROM tbl_subscribers ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subscribed_at']); ?></td>
                                    <td>
    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-trash-alt"></i> Delete
        </button>
    </form>
</td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No subscribers found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// ফুটার ফাইল যুক্ত করা হচ্ছে
include('partials/_footer.php'); // আপনার ফুটার ফাইলের সঠিক পথ
?>