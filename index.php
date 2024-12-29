<?php 

include('functions/userfunctions.php');
include('includes/header.php');
include('includes/slider.php');
?>

<div class="main-content"> <!-- Start main content wrapper -->
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        // Check if a session message is set and display it
                        if(isset($_SESSION['message'])) { 
                            ?>    
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php
                            unset($_SESSION['message']);
                        }
                    ?>
                    
                    <?php 
                        // Check if the user is logged in
                        if(isset($_SESSION['auth_user'])) {
                            // Display welcome message if user is logged in
                            echo "<h1>Hello, " . htmlspecialchars($_SESSION['auth_user']['name']) . "!</h1>";
                        } else {
                            // Display a default message if user is not logged in
                            echo "<h1>Welcome, Guest!</h1>";
                            echo "<p>Please <a href='login.php'>login</a> to access your account.</p>";
                        }
                    ?>
                    
                    <div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <h1>Available Now</h1>
                <div class="row">

                        <?php
                            $categories = getAllActive("categories");

                            if(mysqli_num_rows($categories) >0)
                            {
                                foreach($categories as $item)
                                {
                                    ?>
                                    <div class="col-md-2 mb-2">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <img src="uploads/<?= $item['image'];?>" alt="Category Image" class="w-100">
                                              <h4><?= $item['name'];?></h4>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No data available";
                            }
                        ?>
                </div>

            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content wrapper -->

<?php include('includes/footer.php'); ?>
