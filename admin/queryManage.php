<?php
// Step 1: Correct file paths for includes
require_once('../includes/_dbconnect.php');
include('partials/_nav.php'); 
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage User Queries</h2>
    <hr>
    
    <?php
    // Session message display
    if (isset($_SESSION['message'])) {
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'success';
        echo '<div class="alert alert-' . $msg_type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>

    <div class="modal fade" id="replyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="partials/handle_reply.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Reply to Query</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_email" id="replyUserEmail">
                        <div class="form-group">
                            <label>To:</label>
                            <input type="text" class="form-control" id="replyUserEmailDisplay" disabled>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="send_reply" class="btn btn-primary" >Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-question-circle"></i> User Queries
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email / Mobile</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetching data from the database
                        $sql = "SELECT * FROM tbl_userquery ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr class="<?php if($row['status']==0) echo 'font-weight-bold'; ?>">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['emailid']); ?><br><?php echo htmlspecialchars($row['mobile']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo substr(htmlspecialchars($row['message']), 0, 50); ?>...</td>
                            <td>
                                <?php 
                                if($row['status'] == 0) echo '<span class="badge badge-warning">Pending</span>';
                                else echo '<span class="badge badge-success">Read</span>';
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary reply-btn"
                                        data-toggle="modal" data-target="#replyModal"
                                        data-email="<?php echo htmlspecialchars($row['emailid']); ?>">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                
                                <form action="partials/_queryManage.php" method="POST" class="d-inline">
                                    <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                                    <?php if($row['status'] == 0) { ?>
                                    <button type="submit" name="mark_read" class="btn btn-sm btn-success" title="Mark as Read"><i class="fas fa-check"></i></button>
                                    <?php } ?>
                                    <button type="submit" name="delete_query" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No queries found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
// Step 4: Correct path for footer include
include('partials/_footer.php'); 
?>

<script>
$(document).ready(function() {
    $('.reply-btn').on('click', function() {
        var userEmail = $(this).data('email');
        $('#replyUserEmail').val(userEmail);
        $('#replyUserEmailDisplay').val(userEmail);
    });
});
</script>