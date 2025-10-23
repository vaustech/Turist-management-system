<?php
require_once('../includes/_dbconnect.php');
include 'partials/_nav.php';
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Users</h2>
    <hr>
    
    <?php
    if(isset($_SESSION['message'])){
        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
    }
    ?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-users"></i> All Registered Users
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_userregistration ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['emailid']); ?></td>
                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                            <td><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <form action="partials/_userManage.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_user" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/_footer.php'; ?>