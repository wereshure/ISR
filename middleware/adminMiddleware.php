<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../functions/myfunctions.php');

// Check if the user is authenticated
if (!isset($_SESSION['auth'])) {
    // If not logged in, redirect to login page
    redirect("../login.php", "Login to continue");
    exit;
}

// Allow access to both 'admin' and 'retailer'
if ($_SESSION['auth_user']['role_as'] != 'admin' && $_SESSION['auth_user']['role_as'] != 'retailer') {
    $_SESSION['message'] = "Hey! You are not authorized to access this page.";
    header('Location: ../index.php');
    exit(0);
}

// Manage users (adding, updating, deleting)
if (isset($_POST['save_user'])) {
    // Validate CSRF token
    if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
        redirect("user_management.php", "CSRF token validation failed.");
        exit;
    }

    $id = $_POST['user_id'] ?? null;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role_as'];

    if ($id) {
        if (!empty($password)) {
            // Only update password if a new one is provided
            updateUserWithPassword($id, $name, $email, $phone, $password, $role);
        } else {
            updateUser($id, $name, $email, $phone, $role);
        }
    } else {
        addUser($name, $email, $phone, $password, $role);
    }
    redirect("user_management.php", "User saved successfully.");
    exit;
}

if (isset($_POST['delete_user'])) {
    // Validate CSRF token
    if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
        redirect("user_management.php", "CSRF token validation failed.");
        exit;
    }

    $id = $_POST['user_id'];
    deleteUser($id);
    redirect("user_management.php", "User deleted successfully.");
    exit;
}

?>
