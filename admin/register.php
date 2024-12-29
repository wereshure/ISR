<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['auth']))
{
    $_SESSION['message'] = "Already Login. Logout to switch account";
    header('Location: index.php');
    exit();
}

include('includes/header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                        <h2>Register</h2>
                    </div>
                    <div class="card-body">
                        <form action="../functions/authenticator.php" method="POST">
                            <div class="mb-3">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone:</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role_as">Register as:</label>
                                <select id="role_as" name="role_as" required>
                                    <option value="customer">Customer</option>
                                    <option value="retailer">Retailer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                                <button type="submit" name="register_btn">Register</button>
                        </form>
</body>
</html>


<?php include('includes/footer.php'); ?>