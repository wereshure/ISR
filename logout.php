<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if(isset($_SESSION['auth'])) //Checks if the user is authenticated by checking the auth session variable.
{
    unset($_SESSION['auth']); //effectively logging the user out.
    unset($_SESSION['auth_user']); //removing the user information from the session.
    $_SESSION['message'] = "Logout successfully"; //Sets a session message indicating successful logout.
}

header('Location: index.php');

?>