<?php
session_start(); // Start the session to access session variables

// Destroy all session variables
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Optionally, you can also remove cookies if you're using any to maintain the session
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', '', time() - 3600, '/'); // Delete the session cookie
}

// Set a session message to notify the user of successful logout
$_SESSION['message'] = "You have been logged out successfully.";

// Redirect to login page or home page after logout
header("Location: login.php");
exit();
?>
