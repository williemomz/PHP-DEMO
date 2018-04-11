<?php 
/* Form to reset password and send the new password to the user's email */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $username = $mysqli->escape_string($_POST['username']);
    $password = $mysqli->escape_string($_POST['newPassword']);
    $email = $mysqli->escape_string($_POST['email']);

    $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that username doesn't exist!";
        header("location: error.php");
    }
    else { 
      // User exists (num_rows != 0)
      
//Query to update the new password for the specified username
$sql = "UPDATE users SET password='$password' WHERE username='$username'";

// Update user password to the database
if ( $mysqli->query($sql) ){      

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for your new password</p>";

        // Send password to email
        $to      = $email;
        $subject = 'your new password';
        $message_body = 'Hello '.$username.' your new password is '.$password;  

        mail($to, $subject, $message_body);

        header("location: success.php");
    }
    else {
      $_SESSION['message'] = 'Password reset unsuccessful!<br> Please try again';
      header("location: error.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">

    <div class="field-wrap">
      <label>
        Username<span class="req">*</span>
      </label>
      <input type="text"required autocomplete="off" name="username"/>
    </div>

    <div class="field-wrap">
      <label>
        New Password<span class="req">*</span>
      </label>
      <input type="password"required autocomplete="off" name="newPassword"/>
    </div>

     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>
          

<!-- jquery library minified version 2.0-->
<script src='js/jquery.min.js'></script>

<!-- custom js -->
    <script src="js/index.js"></script>

</body>

</html>
