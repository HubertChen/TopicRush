<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle | Sign Up</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  
  
<!-- NAVBAR
Known bugs: 	
	-in Collapse it displays a line through the buttons
	-Readjusting back to full view the buttons don't display properly
    -If time at the end: add cookie to stay logged in

================================================== -->
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" align="center">   
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">
          	<img src="images/logo03.png" alt="Circle" width="47" height="47" vspace="2">&nbsp;
         	 <img src="images/logotext.png" alt="Circle" width="94" height="28">
          </a>
        </div>
      </div>
    </div>
    

	<!-- Sign Up Form
    ================================================== -->
   <div class="container">
<?php
  $formerrors = array();
  $valid = FALSE;
  $email = "";
  $password = "";
  $username = "";
  $memberid = "";
  $role = "";
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');

  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }
     
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postemail = $_POST["email"];
    $postpassword = $_POST["password"];
    $found = FALSE;
    $valid = FALSE;
    $sql = "select * from member";
    $result = mysqli_query($con,$sql);
    while(($row = mysqli_fetch_array($result)) and ($found == FALSE)){
      if (strtolower($postemail) == strtolower($row["email"])) {
        $found =  TRUE;
        if ($postpassword == $row["password"]) {
          $valid = TRUE;
          $memberid = $row["memberid"];
          $username = $row["username"];
          $role = $row["role"];
        } // end if password matches
      } // end if email found
    } // end while checking password
  } // end if post message received

  echo '<form class="form-signin" role="form" action="signin.php" method="post">';
  echo '<h2 class="form-signin-heading">&nbsp;</h2>';
  echo '<h2 class="form-signin-heading">&nbsp;</h2>';
  echo '<h2 class="form-signin-heading">Please sign in</h2>';
  echo '<input type="text" class="form-control" placeholder="Email" name="email" value="' . $email .'" required autofocus>';
  echo '<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="' . $password . '" required>';
  echo '<label class="checkbox">';
  echo '<input type="checkbox" value="remember-me"> Remember me';
  echo '</label>';
  if ($valid == TRUE) {
    $_SESSION["loggedin"] = TRUE;
    $_SESSION["username"] = $username;
    $_SESSION["memberid"] = $memberid;
    $_SESSION["role"] = $role;
    $sql = "update member set lastlogin='" . $tstamp . "' where memberid=" . $memberid;
    mysqli_query($con,$sql);
  } else { // end if successfully logged in
    echo "Invalid Login! Please Try Again!<br>";
  } // end if-else sucessfully logged in
  if (isset($_SESSION["loggedin"])) {
    echo "You are already logged in!<br>";
  } else { // end if already logged in
    echo '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>';
    echo '<p class="text-center" ><a href="signup.php">Sign Up </a></p>';
  } // end if-else already logged in
  echo '</form>';

  mysqli_close($con); 

?>

     <p>&nbsp;</p>
     <p>&nbsp;</p>
     <p>&nbsp;</p>
     <p>&nbsp;</p>
     <p>&nbsp;</p>
 

  <hr class="featurette-divider">
      <!-- /END THE FEATURETTES -->


      <!-- Footer
          Need to do:
    		-Add color to the bottom
            -May want to add bread crumb for navigation purposes
    ================================================== -->
      <!--<ol class="breadcrumb">
      	<li><a href="index.php">Home</a></li>
      </ol>-->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Circle, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">About</a></p>
      </footer>
    </div><!-- /.container -->
      <!-- /END THE FEATURETTES -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
  </body>
</html>