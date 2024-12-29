<?php

session_start();
include('config/dbcon.php');

// Function to fetch all records from a specified table
function getAllActive($table) {
    global $con;
    $query = "SELECT * FROM $table WHERE status='0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

// Function to redirect to a specified URL with a session message
function redirect($url, $message) {
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit(0);
}
?>