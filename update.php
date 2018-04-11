<?php 
/* Update process, updates user info in the database */
require 'db.php';
session_start();

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['toUpdate']))){

//username session from profile page
$username = $_SESSION['username'];


// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$lang = $mysqli->escape_string($_POST['languages']);


//check connection
if($mysqli->connect_error){
    die("Connection faiiled:".$mysqli->connect_error);
}

//Query to update the specified three columns where username is user logged in
$sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', languages='$lang' WHERE username='$username'";

    // Update user details to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['message'] = 'Details Update succesfully';
        header("location: success.php"); 

    }

    else {
        $_SESSION['message'] = 'Update failed!';
        header("location: error.php");
    }
    
}

else{
    $_SESSION['message'] = 'Please use the right  channel!';
    header("location: error.php");
}