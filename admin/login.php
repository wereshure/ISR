<?php
// Check if session is not already started

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['auth'])) //Checks if a session variable named 'auth' is set. This indicates if the user is already logged in.
{
    $_SESSION['message'] = "Already Login. Logout to switch account";  //f the user is already logged in, a message is set in the session indicating they need to log out to switch accounts.
    header('Location: index.php'); //Redirects the user to the index.php page and stops further script execution.
    exit();
}


include('includes/header.php');  // Include header
?>

<div class="py-5">      <!-- add padding on the y-axis (top and bottom). -->
    <div class="container">     <!--to center the content and give it some padding. -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php 
                // Checks if there's a session message set.
                if(isset($_SESSION['message'])) 
                { 
                    ?>
                    <!-- Displays an alert box     -->
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
                <!-- Login Form -->
                <div class="card">
                    <div class="card-header">
                        <h4>Login Form</h4>
                    </div>
                    <div class="card-body"> 
                        <form action="../functions/authenticator.php" method="POST">
                            <label>Email:</label><br>
                            <input type="email" name="email" required><br><br>

                            <label>Password:</label><br>
                            <input type="password" name="password" required><br><br>

                            <button type="submit" name="login_btn">Login</button>
                        </form>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); // Include footer ?>
