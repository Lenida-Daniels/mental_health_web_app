<?php
# handles database connection
$host = "localhost";
$user = "root";        // default XAMPP username
$pass = "";           
$dbname = "therapy_app";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
/*
if($conn){
    echo "Connection successful!";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
*/