<!-- DONE: 4/6/14 -->
<?php session_start() ?>

<?php
	
	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost";
	$dbuser = "root";
  	$dbpass = "";
  	$dbname = "Circle";          
  	
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




  //Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
	
		include 'editprofile.html.php';
		exit(); 
  	} 


	//If user is logged in
  	if (isset($_SESSION["loggedin"])) {
		$memberid = $_SESSION["memberid"];
		$validform = TRUE;
		$changeavatar = FALSE;
		$formerrors = "";
		$username = "";
		$city = "";
		$state = "";
		$zip = "";
		$avatarpath = "";
		$deleteavatar = FALSE;
		$oldfile = "";
		$memberpath = 'C:\\wamp\\www\\bzk\\members\\';
		$sql = "select * from member where memberid=" . $memberid;
		$result = mysqli_query($con,$sql);
		
		$button = '<button type="submit" class="btn btn-primary pull-right">Update</button>';
    	
		//Pulls member information
		foreach($result as $row) { 
			$username = $row['username']; 
			$city = $row["city"];
			$state = $row["state"];
			$zip = $row["zip"];
			$avatarpath = $row["avatarpath"];
    	} // end loop to pull memberinformation
    
		if (preg_match('/members/',$avatarpath)) {
      		$deleteavatar = TRUE;
      		preg_match('/[0-9]+.[a-zA-Z]+/',$avatarpath,$matches);
      		$oldfile = $matches[0];
    	}

    	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$postusername = $_POST["username"];
			$postcity = $_POST["city"];
			$poststate = $_POST["state"];
			$postzip = $_POST["zip"];

      		if (strlen($postusername) > 0) {
        		if ((strlen($postusername) > 30) || (ctype_alnum($postusername) == FALSE)) {
          			$validform = FALSE;
          			$formerrors = $formerrors . "Invalid username, please try again!<br/>";
        		} else {
          			$username = $postusername;
        		}
      		} 

     		if (strlen($postzip) > 0) {
        		if (is_numeric($postzip) == FALSE) {
          			$validform = FALSE;
          			$formerrors = $formerrors . "Zip code must be a numeric value!<br/>";
        		} else {
          			$zip = $postzip;
        		}
      		}

      		if (strlen($poststate) > 0) {
        		if ((strlen($poststate) > 2) || (ctype_alpha($poststate) == FALSE)) {
          			$validform = FALSE;
          			$formerrors = $formerrors . "State must  be two letters!<br/>";
        		} else {
          			$state = $poststate;
        		}
      		}   
  
      		if (strlen($postcity) > 0) {
        		if ((strlen($postcity) > 30) || (ctype_alpha($postcity) == FALSE)){
          			$valiform = FALSE;
         			$formerrors = $formerrors . "Invalid city, please try again!<br/>";
        		} else {
          			$city = $postcity;
        		}
      		}        

      		if ($_FILES["file"]["error"] > 0) {
        		$valdiform = FALSE;
        		$formerrors = $formerrors . "Invalid picture file, please try again!<br>";
      		} else { // end if no file attached
        		$allowedimagetype = array("gif","jpeg","jpg","png");
        		$temp = explode(".", $_FILES["file"]["name"]);
        		$extension = end($temp);
				if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/png"))
				&& ($_FILES["file"]["size"] < 204800)
				&& in_array($extension, $allowedimagetype)) {
          			$changeavatar = TRUE;
        		} else { // end if file is a supported type
          			$validform = FALSE;
          			$formerrors = $formerrors . "Submit only .gif, .jgp,  .jpeg, or .png and Maximum 200 KB.<br/>";
        		} // end if-else is a supported type
      		} // end if-else no file attached

      		if ($validform == TRUE) {
        		$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Profile Updated!
							</div>';
				include 'editprofile.html.php';
        		$sql = "update member set username='" . $username . "',city='" . $city . "',state='" . $state . "',zip='" . $zip . "' where memberid=" . $memberid;
        		if ($changeavatar == TRUE) {
          			//Don't need echo statement
		  			//echo "Change Avatar<br>";
          		if ($deleteavatar == TRUE) {
            		unlink(realpath($memberpath . $oldfile));
				} // end if deleting avatar


				move_uploaded_file($_FILES["file"]["tmp_name"],$memberpath . $memberid . "." . $extension);
			  	$avatarpath = "/bzk/members/" . $memberid . "." . $extension;
			  	$sql = "update member set username='" . $username . "',city='" . $city . "',state='" . $state . "',zip='" . $zip . "',avatarpath='" . $avatarpath. "' where memberid=" . $memberid;
			  	$_SESSION["avatarpath"] = $avatarpath;
        	}
        	
			mysqli_query($con,$sql);
        	$_SESSION["username"] = $username;
		} else { // end if valid form
     		 $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									' . $formerrors. '
								</div>';
			$button = '<button type="submit" class="btn btn-primary pull-right">Update</button>';
				
			include 'editprofile.html.php';
			exit();		  
      } // end if-else form valid
    } // end if post message received
    include 'editprofile.html.php';
  } else { // end if user is logged in
    $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Need to sign in to edit profile!
						</div>';
	$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Update</button>';
	include 'editprofile.html.php';
	exit();  
  } // end if-else user is logged in

  mysqli_close($con);
  
?>
