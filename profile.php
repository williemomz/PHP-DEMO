<?php
/* Displays user information and a form to udate */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
  //Checking the time now when profilepage starts
  $now = time();
//if session time expires kill session variables and log off user
  if($now > $_SESSION['expire']){
    session_unset();
    session_destroy();
    //alert user session has expired and redirect to logout page
    echo "<script>alert('Your session has expired!'); window.location.href='logout.php'</script>";
    }
  else { //session not expired go on

    // Makes it easier to read
    $first_name = $_SESSION['firstname'];
    $last_name = $_SESSION['lastname'];
    $gender = $_SESSION['gender'];
    $lang = $_SESSION['languages'];
    $username = $_SESSION['username']; 
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first_name.' '.$last_name ?></title>
  <?php include 'css/css.html'; ?>
</head>

<body>
  <div class="form">

  <ul class="tab-group">
        <li class="tab"><a href="#update">Update</a></li>
        <li class="tab active"><a href="#myProfile">My Profile</a></li>
      </ul>
      
      <div class="tab-content">

      <div id="myProfile">
          <h1>Welcome</h1>          
          <h2><?php echo $first_name.' '.$last_name; ?></h2>
          <div class="forProfile">
            <p>Username: &nbsp <?= $username ?></p>
            <p>Language: &nbsp <?= $lang ?></p>
            <p>Gender: &nbsp <?= $gender ?></p>         
          </div>
            
          <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>

      </div>

      <div id="update">   
          <h1>Update My Profile</h1>
          
          <form action="update.php" method="post" autocomplete="off">
          
          
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='lastname' />
            </div>

          <div class="field-wrap">
            <label>
              Languages(Java, C or Python)<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name='languages' />
          </div>
                          
          <button type="submit" class="button button-block" name="toUpdate" />UPDATE</button>
          
          </form>

        </div> <!--  closing div id update -->

    </div> <!--  closing tab content -->

    </div> <!--  closing class form -->

<!-- jquery library minified version 2.0-->
<script src='js/jquery.min.js'></script>

<!-- custom js -->
    <script src="js/index.js"></script>

</body>
</html>

<?php
      }
    }
?>