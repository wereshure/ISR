<?php 
include('../config/dbcon.php');
include('includes/header.php');
include('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
                if (isset($_SESSION['message'])):
            ?>
                <div class="alert alert-success">
                    <?= $_SESSION['message']; ?>
                </div>
            <?php 
                    unset($_SESSION['message']);
                endif;
            ?>
            <div class="card">
                <div class="card-header">
                    <h4>Admin User Management</h4>
                </div>
                <div class="card-body" id="users_table">
            
                    <hr>

                    <!-- User List Table -->
                    <h5>Users List</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <!-- <th>Password</th> --> <!-- Removed for security -->
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $users = getAll("users");
                                if(mysqli_num_rows($users) > 0) {
                                    foreach($users as $item) {
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['id']); ?></td>
                                                <td><?= htmlspecialchars($item['name']); ?></td>
                                                <td><?= htmlspecialchars($item['email']); ?></td>
                                                <td><?= htmlspecialchars($item['phone']); ?></td>
                                                <td><?= htmlspecialchars($item['role_as']); ?></td>
                                                <td>
                                                    <a href="edit-user.php?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>
                                                    <button type="button" class="btn btn-danger delete_user_btn" value="<?= $item['id']; ?>">Delete</button>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No Users Found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
