<?php
/* User login process, checks if user exists and password is correct */

// Escape username to protect against SQL injections
$username = $mysqli->escape_string($_POST['username']);
$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that username doesn't exist!";
    header("location: error.php");
}
else {
     //if  User exists fetch data
    $user = $result->fetch_assoc();
 
    //if (password_verify($_POST['password'], $user['password']) ) {
    if (($_POST['password']) == ($user['password']) ) {
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['firstname'] = $user['first_name'];
        $_SESSION['lastname'] = $user['last_name'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['languages'] = $user['languages'];
        $_SESSION['password'] =   $user['password'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;
        // Taking now logged in time
        $_SESSION['start'] = time();
        //Ending a session in 5 minutes form the starting time
        $_SESSION['expire'] = $_SESSION['start']+(5*60);
        header("location: profile.php");
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}

