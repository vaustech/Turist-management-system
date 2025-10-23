<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Testimonials</h2>
    <hr>
    
    <?php
    if (isset($_SESSION['message'])) {
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success';
        echo '<div class="alert alert-' . $msg_type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-comment-alt"></i> All Customer Testimonials
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_testimonials ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo substr(htmlspecialchars($row['message']), 0, 100); ?>...</td>
                            <td>
                                <?php 
                                if($row['status'] == 0) echo '<span class="badge badge-warning">Pending</span>';
                                else echo '<span class="badge badge-success">Approved</span>';
                                ?>
                            </td>
                            <td>
                                <form action="partials/_testimonialManage.php" method="POST" class="d-inline">
                                    <input type="hidden" name="testimonial_id" value="<?php echo $row['id']; ?>">
                                    <?php if($row['status'] == 0) { ?>
                                    <button type="submit" name="approve_testimonial" class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                    <?php } ?>
                                    <button type="submit" name="delete_testimonial" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No testimonials found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>