<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../config/dbcon.php'); // Database conection
include('../functions/myfunctions.php'); // Helper functions

// Registration Logic
if (isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role_as = mysqli_real_escape_string($con, $_POST['role_as']);
    
    // Ensure role is valid ('admin', 'retailer', 'customer')
    $allowed_roles = ['admin', 'retailer', 'customer'];
    if (!in_array($role_as, $allowed_roles)) {
        $_SESSION['message'] = "Invalid role selection.";
        header('Location: ../admin/register.php');
        exit(0);
    }

    // Hash the password
    $password = $password;  // Store plain password


    // Check if email already exists
    $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $email_check_result = mysqli_query($con, $email_check_query);
    if (mysqli_num_rows($email_check_result) > 0) {
        $_SESSION['message'] = "Email already exists.";
        header('Location: ../admin/register.php');
        exit(0);
    } else {
        // Insert user into the database
        $query = "INSERT INTO users (name, email, phone, password, role_as) VALUES ('$name', '$email', '$phone', '$hashed_password', '$role_as')";
        $result = mysqli_query($con, $query);

        if ($result) {
            $_SESSION['message'] = "Registration successful!";
            header('Location: ../admin/login.php'); // Redirect to login page
            exit(0);
        } else {
            $_SESSION['message'] = "Something went wrong. Please try again.";
            header('Location: ../admin/register.php');
            exit(0);
        }
    }
}

// Login Logic
else if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Fetch user data from database
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if ($password === $user['password']) {

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role_as' => $user['role_as']
            ];

            // Redirect based on role
            if ($user['role_as'] == 'admin') {
                header('Location: ../admin/index.php');
            } elseif ($user['role_as'] == 'retailer') {
                header('Location: ../admin/index.php');
            } else {
                header('Location: ../index.php');
            }
            exit(0);
        } else {
            $_SESSION['message'] = "Invalid Password.";
            header('Location: ../admin/login.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "No User Found.";
        header('Location: ../admin/login.php');
        exit(0);
    }
}

?>
