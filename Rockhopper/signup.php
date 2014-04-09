<!-- DONE: 4/6/14 -->
<?php session_start(); ?>
     

<?php
	$validform = TRUE;
  	$formerrors = "";
  	$email = "";
  	$password1 = "";
  	$password2 = "";
  	$role = "";
    date_default_timezone_set('EST');
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

			$hashedPass = crypt($password1, 'Sfgh9m66MZ9zdn46XYK6');
			$sql = "insert into member(username,password,email,role,status,joindate,lastlogin) values('$username','$hashedPass','$email','$role','0','$tstamp','$tstamp')";
			mysqli_query($con,$sql);
			$sql="select memberid from member where email='$email'";
			$result=mysqli_query($con,$sql);
			$memberid = 0;
			
			foreach($result as $row) { $memberid=$row["memberid"]; }
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['username'] = $username;
			$_SESSION['memberid'] = $memberid;
			$_SESSION['role'] = $role;
                        $_SESSION['lastlogin'] = $tstamp;
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