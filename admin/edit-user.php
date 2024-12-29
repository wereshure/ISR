<?php 

include('includes/header.php');
include('../middleware/adminMiddleware.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $user = getByID("users", $id);

                    if(mysqli_num_rows($user) > 0)
                    {
                        $data = mysqli_fetch_array($user);
                        ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit user
                                    <a href="user_management.php" class="btn btn-primary float-end">Back</a>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="code.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="user_id" value="<?= $data['id'] ?>"> 
                                                <label for="">Name</label>
                                                <input type="text" name="name" value="<?= $data['name'] ?>" placeholder="Enter user Name" class="form-control">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <textarea rows="1" name="email" placeholder="Enter email" class="form-control"><?= $data['email']?></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Password</label>
                                                <?php 
                                                // Generate masked password using asterisks
                                                $maskedPassword = str_repeat('*', strlen($data['password']));
                                                ?>
                                                <!-- Display masked password -->
                                                <input type="password" name="password" placeholder="<?= $maskedPassword ?>" class="form-control" autocomplete="new-password">
                                            </div>


                                            
                                            <div class="col-md-12">
                                                <label for="">Phone Number</label>
                                                
                                                <input type="text" name="phone" value="<?= $data['phone'] ?>" placeholder="Enter Phone Number" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-0">Select Role As</label>
                                                <select name="role_as" class="form-select mb-2" required>
                                                    <option value="" disabled selected>Select Role</option> <!-- Make this option unselectable -->
                                                    <?php
                                                        // Define roles
                                                        $roles = [
                                                            'customer' => 'Customer',
                                                            'retailer' => 'Retailer',
                                                            'admin' => 'Admin'
                                                        ];
                                                        
                                                        foreach ($roles as $roleValue => $roleName) {
                                                            ?>
                                                                <option value="<?= $roleValue; ?>" <?= $data['role_as'] == $roleValue ? 'selected' : '' ?>><?= $roleName; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" name="update_user_btn">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                    }
                    else
                    {
                        echo "user not found";
                    }
                }
                else
                {
                    echo "ID missing from url";
                }
                    ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php');?>