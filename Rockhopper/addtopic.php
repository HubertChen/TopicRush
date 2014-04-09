<!-- DONE: 4/7/14 -->
<?php session_start(); ?>

<?php

	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost";
  	$dbuser = "root";
  	$dbpass = "";
  	$dbname = "Circle";
  	date_default_timezone_set('EST');
  	$date = new DateTime();
  	$tstamp = $date->format('Y-m-d H:i:s');
  	$communityid = $_GET["id"];
  	
	//navbar: user is logged in           
  	if (isset($_SESSION["loggedin"])) {
    	$navbar = '<a href="signout.php"><button type="button" class="btn btn-signin navbar-btn-right btn-sm" >Sign Out</button></a>
					<div class="navbar-right">
						<a href="profile.php">
							<img src="'. $_SESSION["avatarpath"] . '" alt="User Profile Image" width="35" height="35" class="img-circle">
						</a>
						<a href="profile.php">' . $_SESSION["username"] . '</a>
					</div>';
	
	} else { // end if user is logged in
    	$navbar ='<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
					<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
  	} // end if-else user is logged in

	$validform = TRUE;
	$topicname = '';
	$topicproduct = '';
	$formerrors = '';

  //Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
		$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Topic</button>';
		include 'addtopic.html.php';
		exit(); 
  	} 
	
	//User is logged in
	if (isset($_SESSION["loggedin"])) {
    	$memberid = $_SESSION["memberid"];
    	$button = '<button type="submit" class="btn btn-primary pull-right">Add Topic</button>';

		//If post message is received
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
      		$posttopicname = $_POST["topicname"];
      		$postproductid = $_POST["productid"];

      		if ((strlen($posttopicname) <= 5) || (is_numeric($posttopicname))) {
        		$validform = FALSE;
        		$formerrors = $formerrors . 'Name must be more than 5 characters, please try again!<br/>';
        		//echo 'Length = ' . strlen($posttopicname) . '<br>';
      		} else { // end if $posttopicname is invalid
        		$topicname = $posttopicname;
      		} // end if-else $posttopicname is invalid

      		//echo $posttopicname . '<br>';
     	 	//echo $postproductid . '<br>';

			//If form is valid
      		if ($validform == TRUE) {
        		$sql = '';
        		if ($postproductid == 0) {
          			$sql = "insert into topic(communityid,ownerid,followid,name,created) values ('$communityid','$memberid','0','$topicname','$tstamp')";
        		} else { 
          			$sql = "insert into topic(communityid,ownerid,followid,productid,name,created) values ('$communityid','$memberid','0','$postproductid','$topicname','$tstamp')";
        		}
        		mysqli_query($con,$sql);
				$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Topic added Successfully!
							</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right">Add Topic</button>';
				include 'addtopic.html.php';

      		} else { // end if $validform == TRUE
        		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									' . $formerrors. '
								</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right">Add Topic</button>';

								
				include 'addtopic.html.php';
        		$formerrors = '';
      		} // end if-else $validform == TRUE
		} // end if post message received
  		include 'addtopic.html.php';
	//If user is not logged in
	} else {
		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Need to sign in to add a community!
					</div>';
		$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Topic</button>';
		include 'addtopic.html.php';
		exit();
		
		
	}// end if user is not logged in
	mysqli_close($con);
?>