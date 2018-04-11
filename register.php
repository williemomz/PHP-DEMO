<?php
//Registration process, inserts user info into the database 


// Set session variables to be used on profile.php page
$_SESSION['firstname'] = $_POST['firstname'];
$_SESSION['lastname'] = $_POST['lastname'];
$_SESSION['gender'] = $_POST['gender'];
$_SESSION['languages'] = $_POST['languages'];
$_SESSION['username'] = $_POST['username'];


// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$gender = $mysqli->escape_string($_POST['gender']);
$lang = $mysqli->escape_string($_POST['languages']);
$username = $mysqli->escape_string($_POST['username']);
$password = $mysqli->escape_string($_POST['password']);

      
// Check if user with that username already exists
$result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());

// We know username already exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this username already exists!';
    header("location: error.php");
    
}
else { 
    // Username doesn't already exist in a database, proceed...

    $sql = "INSERT INTO users (first_name, last_name, gender, languages, username, password) " 
            . "VALUES ('$first_name','$last_name','$gender','$lang', '$username', '$password')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;
        // Taking now logged in time
        $_SESSION['start'] = time();
        //Ending a session in 5 minutes form the starting time
        $_SESSION['expire'] = $_SESSION['start']+(5*60);
        header("location: profile.php");
    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}