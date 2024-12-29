<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../config/dbcon.php');
include('myfunctions.php');

// User registration
if(isset($_POST['register_btn'])) //Checks if the registration form has been submitted.
{
    $name = mysqli_real_escape_string($con,$_POST['name']); //Escapes special characters in a string for use in an SQL statement, preventing SQL injection.
    $phone = mysqli_real_escape_string($con,$_POST['phone']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $cpassword = mysqli_real_escape_string($con,$_POST['cpassword']);

    // Check if email already register
    $check_email_query = "SELECT email FROM users WHERE email='$email' "; 
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0) //Checks if any rows are returned
    {
        $_SESSION['message'] = "Email already registered";
        header('Location: ../register.php'); //Redirects to the registration page.
    }
    else
    {

        if($password == $cpassword) //Checks if the passwords match.
        {
            // Insert user data
            $insert_query = "INSERT INTO users (name,email,phone,password) VALUES ('$name','$email','$phone','$password')";
            $insert_query_run = mysqli_query($con,$insert_query);

            if($insert_query_run) // Checks if the insert query was successful and redirects accordingly.
            {
                $_SESSION['message'] = "Registered Successfully";
                header('Location: ../login.php');
            }
            else
            {
                $_SESSION['message'] = "Something went wrong..";
                header('Location: ../register.php');
            }
        }
        else
        {
            $_SESSION['message'] = "Password do not match";
            header('Location: ../register.php');
        }
    }
}

// User Login
else if(isset($_POST['login_btn']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' ";
    $login_query_run = mysqli_query($con, $login_query);

    if(mysqli_num_rows($login_query_run) > 0)
    {
        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $username = $userdata['name'];
        $useremail = $userdata['email'];
        $role_as = $userdata['role_as'];

        $_SESSION['auth_user'] = [
            'name' => $username,
            'email' => $useremail
        ];

        $_SESSION['role_as'] = $role_as;

        if($role_as == 1)
        {
            $_SESSION['message'] = "Welcome to Dashboard";
            header('Location: ../admin/index.php');
        }
        else
        {
            $_SESSION['message'] = "Login Successfully";
            header('Location: ../index.php');
        }

        
    }
    else
    {
        $_SESSION['message'] = "Invalid Credentials";
        header('Location: ../login.php');
    }
}

?>