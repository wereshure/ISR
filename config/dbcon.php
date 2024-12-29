<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "isr";

    // Creating database connection
    $con = mysqli_connect($host, $username, $password, $database);

    // Check database connection
    if(!$con)
    {
        die("Connection Failed: ".mysqli_connect_error());
    }
    

?>