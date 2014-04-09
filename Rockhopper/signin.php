<!-- DONE: 4/6/14 -->
<?php session_start(); ?>



<?php
	$formerrors = array();
	$valid = FALSE;
	$email = "";
	$password = "";
	$username = "";
	$memberid = "";
	$role = "";
	$avatarpath = "";
  	$lastlogin = "";
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
		$button = '<button class="btn btn-lg btn-primary btn-block" disabled="disabled" type="submit">Sign In</button>';
	
		include 'signin.html.php';
		exit(); 
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
				if (crypt($postpassword, 'Sfgh9m66MZ9zdn46XYK6')==$row["password"]){
          $valid = TRUE;
          $memberid = $row["memberid"];
          $username = $row["username"];
          $role = $row["role"];
          $avatarpath = $row["avatarpath"];
          $lastlogin = $row["lastlogin"];
        }// end if password matches
      		} // end if email found
		} // end while checking password
  		//header("Location: http://www.google.com");
  	} // end if post message received
	
	if ($valid == TRUE) {
		$_SESSION["loggedin"] = TRUE;
		$_SESSION["username"] = $username;
		$_SESSION["memberid"] = $memberid;
		$_SESSION["role"] = $role;
		$sql = "update member set lastlogin='" . $tstamp . "' where memberid=" . $memberid;
		mysqli_query($con,$sql);
		//
	} else { // end if successfully logged in
		//$errorMessage = "Invalid Login! Please Try Again!<br>";
  	} // end if-else sucessfully logged in
	
	
	
	if (isset($_SESSION["loggedin"])) {
		$errorMessage = '<div class="alert alert-info alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Your are already logged in!
						</div>';			
		$button = '<button class="btn btn-lg btn-primary btn-block" type="submit" disabled="disabled">Sign In</button>';
		
		include 'signin.html.php';
		exit();
  	} else {
		$button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>';
	
		include 'signin.html.php';
	  	exit();
	}
	
	mysqli_close($con); 
?>

