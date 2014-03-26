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
	-Eliminate in the first name and last name and add username
    -Password field and a confirm password field
    -Add type field of: user and seller
    	-Maybe add description of what a user and seller does
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

     <p>&nbsp;</p>
     <p>&nbsp;</p>
     <p>&nbsp;</p>
     
     <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->

<<<<<<< HEAD
<?php
	$validform = TRUE;
  	$formerrors = "";
  	$email = "";
  	$password1 = "";
  	$password2 = "";
  	$role = "";
  	$date = new DateTime();
  	$tstamp = $date->format('Y-m-d H:i:s');

  	/*WILL NEED TO CHANGE*/
  	$dbhost = "localhost";
  	$dbuser = "root";
  	$dbpass = "";
  	$dbname = "Circle";

  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) { 
  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
		$button = '<button class="btn btn-lg btn-primary btn-block" disabled="disabled" type="submit">Sign Up</button>';
	
		include 'signup.html.php';
		exit();
	}
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	$postemail = $_POST["email"];
    	$postpassword1 = $_POST["password1"];
    	$postpassword2 = $_POST["password2"];
    	$role = $_POST["role"];

    	$sql = "select email from member";
    	$result = mysqli_query($con,$sql);
    	
		foreach ($result as $row) {
      		if (strtolower($postemail) == strtolower($row["email"])) {
        		$validform = FALSE;
        		$formerrors = $formerrors . "Username already exists!<br/>";
      		} // end if email address already in database    
    	} // end for checking email already in database
		
    	if ($validform == TRUE) { $email = $postemail; }
    		$pattern = '/[a-zA-Z0-9.]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
			
    	if ((preg_match($pattern,$postemail)) == 0) {
      		$validform = FALSE;
      		$formerrors = $formerrors . "Invalid email address, please try again!<br/>";
    	} // end if email has a valid form

    	if ($postpassword1 != $postpassword2) {
      		$validform = FALSE;
      		$formerrors = $formerrors . "Passwords do not match, try again!";
    	} else { // end if $postpassword1 != $postpassword2
      		if (((preg_match("/[a-z]/",$postpassword1)) == 0) || ((preg_match("/[A-Z]/",$postpassword1)) == 0) || ((preg_match("/[0-9]/",$postpassword1)) == 0)) {
        		$validform = FALSE;
        		$formerrors = $formerrors . "Password must contain at least one uppercase, one lowercase, and one number, please try again!";
      		} else { // end if password meets complexity
        		$password1 = $postpassword1;
        		$password2 = $postpassword2;
      		} // end if-else password meets complexity requirements
    	} // end if-else $postpassword1 != $postpassword2

    	if ($validform == TRUE) {
      		$username = substr($email,0,strpos($email,"@"));

			$sql = "insert into member(username,password,email,role,status,joindate,lastlogin) values('$username','$password1','$email','$role','0','$tstamp','$tstamp')";
			mysqli_query($con,$sql);
			$sql="select memberid from member where email='$email'";
			$result=mysqli_query($con,$sql);
			$memberid = 0;
			
			foreach($result as $row) { $memberid=$row["memberid"]; }
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['username'] = $username;
			$_SESSION['memberid'] = $memberid;
			$_SESSION['role'] = $role; 
		} else { // end if $validform == TRUE
      		
			$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							' . $formerrors. '
							</div>';
			$button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';
			
			include 'signup.html.php';
			exit();
		} // end if-else $validform == TRUE
	}
	
	if (isset($_SESSION['loggedin'])) {
		$errorMessage = '<div class="alert alert-info alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Your are already logged in!
						</div>';			
		$button = '<button class="btn btn-lg btn-primary btn-block" type="submit" disabled="disabled">Sign Up</button>';
		
		include 'signup.html.php';
		exit();
  	} else {
		$button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';
	
		include 'signup.html.php';
	  	exit();
	}

	mysqli_close($con);
?>
=======
<?php     
  $validform = TRUE;
  $formerrors = "";
  $email = "";
  $password1 = "";
  $password2 = "";
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
    $postpassword1 = $_POST["password1"];
    $postpassword2 = $_POST["password2"];
    $role = $_POST["role"];

    $sql = "select email from member";
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) {
      if (strtolower($postemail) == strtolower($row["email"])) {
        $validform = FALSE;
        $formerrors = $formerrors . "Username already exists!<br>";
      } // end if email address already in database    
    } // end for checking email already in database
    if ($validform == TRUE) { $email = $postemail; }
    $pattern = '/[a-zA-Z0-9.]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
    if ((preg_match($pattern,$postemail)) == 0) {
      $validform = FALSE;
      $formerrors = $formerrors . "Invalid email address format!<br>";
    } // end if email has a valid form

    if ($postpassword1 != $postpassword2) {
      $validform = FALSE;
      $formerrors = $formerrors . "Passwords do not match!";
    } else { // end if $postpassword1 != $postpassword2
      if (((preg_match("/[a-z]/",$postpassword1)) == 0) || ((preg_match("/[A-Z]/",$postpassword1)) == 0) || ((preg_match("/[0-9]/",$postpassword1)) == 0)) {
        $validform = FALSE;
        $formerrors = $formerrors . "Password must contain atleast one uppercase, one lowercase and one numeral!<br>";
      } else { // end if password meets complexity
        $password1 = $postpassword1;
        $password2 = $postpassword2;
      } // end if-else password meets complexity requirements
    } // end if-else $postpassword1 != $postpassword2

    if ($validform == TRUE) {
      $username = substr($email,0,strpos($email,"@"));
//      echo "Username = " . $username . "<br>";

      $sql = "insert into member(username,password,email,role,status,joindate,lastlogin,avatarpath) values('$username','$password1','$email','$role','0','$tstamp','$tstamp','/images/avatar1.png')";
      mysqli_query($con,$sql);
      $sql="select memberid from member where email='$email'";
      $result=mysqli_query($con,$sql);
      $memberid = 0;
      foreach($result as $row) { $memberid=$row["memberid"]; }
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['username'] = $username;
      $_SESSION['memberid'] = $memberid;
      $_SESSION['role'] = $role; 
      $_SESSION['avatarpath'] = '/images/avatar1.png';

    } else { // end if $validform == TRUE
      echo "The form has the following errors!<br>";
      echo $formerrors;
    } // end if-else $validform == TRUE

  }
     
  echo '<form action="signup.php" method="post" class="form-signin form-horizontal" role="form">';
  echo '<h2 class="form-signin-heading">Sign up for Circle</h2>';
  echo '<div class="form-group">';
  echo '<label class="sr-only" for="email">Email</label>';
  echo '<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="' . $email .'" required>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label class="sr-only" for="password1">Password</label>';
  echo '<input type="password" class="form-control" name="password1" id="password1" placeholder="Password" value="' . $password1 . '"required>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label class="sr-only" for="password2">Password</label>';
  echo '<input type="password" class="form-control" name="password2" id="password2" placeholder="Retype Password" value="' . $password2 .'"required>';
  echo '</div>';
  echo '<p>Role:</p>';
  echo '<div class="radio-inline">';
  echo '<label>';
  echo '<input type="radio" name="role" id="user" value="u" checked>User';
  echo '</label>';
  echo '</div>';
  echo '<div class="radio-inline">';
  echo '<label>';
  echo '<input type="radio" name="role" id="seller" value="s">Seller';
  echo '</label>';
  echo '</div>';
  if (isset($_SESSION['loggedin'])) {
    echo "You are already registered!<br>";
  } else {
    echo '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';
    echo '<p class="text-center" ><a href="signin.php">Sign In </a></p>';
  }

  mysqli_close($con);

?>

      </form>
</div>
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
>>>>>>> FETCH_HEAD
