<!-- DONE: 4/6/14 -->

<?php session_start(); ?>

<?php

	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "Circle";
	date_default_timezone_set('EST');
  	$date = new DateTime();
  	$tstamp = $date->format('Y-m-d H:i:s');
        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';
        $file = fopen($filterfile,"r");
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) { array_push($filterlist,trim(fgets($file))); }
        }
        $filtersize = count($filterlist);	
	
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
	$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Community</button>';
		include 'addcommunity.html.php';
		exit(); 
  	} 
	
	//If user is signed in
  	if (isset($_SESSION["loggedin"])) {
    	$memberid = $_SESSION["memberid"];
    	$validform = TRUE;
    	$formerrors = '';
    	$postcommunityname = '';
    	$communityname = '';
    	$communityid = 0;
    	$communitypath = 'C:\\wamp\\www\\bzk\\community\\';
    	$button = '<button type="submit" class="btn btn-primary pull-right">Add Community</button>';
		//If post message is received
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $postcommunityname = $_POST["communityname"];
      if ((strlen($postcommunityname) < 3) || (strlen($postcommunityname) > 30)) {
        $validform = FALSE;
        $formerrors = $formerrors . "Community name must be between three and thirty characters!<br>";
      } 
      $found = FALSE;
      $sql = "select communityid from community where name='" . $postcommunityname . "'";
      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result)) { $found = TRUE; }
      if ($found == TRUE) {
        $validform = FALSE;
        $formerrors = $formerrors . $postcommunityname . " community already exists!<br>";
      } else { // end if community already exists
      $valid = TRUE;
      if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postcommunityname) == TRUE) { 
        $valid = FALSE; 
        $validform = FALSE;
        $formerrors = $formerrors . "Invalid input, please try again<br>";
      }
      if ($valid == TRUE) {
        $index = 0;
        $found = FALSE;
        while (($index < $filtersize) && ($valid == TRUE)) {
          $pattern = '/' . $filterlist[$index] . '/i';
          if (preg_match($pattern,$postcommunityname) == TRUE) {
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . "Community name contains innapropriate material<br>";
          } // end if 
          $index += 1;
        } // end while loop to check filter list
      } // end if valid == TRUE
    } // end if-else communityname already exists
      		//No file is attached
			if ($_FILES["file"]["error"] > 0) {
        		$valdiform = FALSE;
        		$formerrors = $formerrors . "No file provided or invalid type!<br>";
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
        		} else { // end if file is a supported type
          			$validform = FALSE;
          			$formerrors = $formerrors . "File must be gif jpg jpeg or png and 200kbytes maximum!<br>";
        		} // end if-else is a supported type
      		} // end if-else no file attached

		//form is valid
      	if ($validform == TRUE) {
                $communityname = mysqli_real_escape_string($con,$postcommunityname);	
        	$sql="insert into community(ownerid,name,created,nummembers,numtopics,numcontents,rating) values ('$memberid','$communityname','$tstamp','0','0','0','0')";
        	mysqli_query($con,$sql);
       	 	$sql = "select communityid from community where name='" . $communityname . "'";
       		$result = mysqli_query($con,$sql);
       		while($row = mysqli_fetch_array($result)) { $communityid = $row["communityid"]; }
       		move_uploaded_file($_FILES["file"]["tmp_name"],$communitypath . $communityid . "." . $extension);
	        $graphicpath = '/bzk/community/' . $communityid . "." . $extension;
                $sql = "update community set path='" . $graphicpath . "' where communityid=" . $communityid;
                mysqli_query($con,$sql);		
			$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Community added Successfully!
							</div>';
			$button = '<button type="submit" class="btn btn-primary pull-right">Add Community</button>';
			include 'addcommunity.html.php';
    	} else { // end if valid form
        	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									' . $formerrors. '
								</div>';
								$button = '<button type="submit" class="btn btn-primary pull-right">Add Community</button>';
			include 'addcommunity.html.php';
			//exit();			
      	} // end if-else form valid
    } // end if post message received
	include 'addcommunity.html.php';
  } else { // end if user is logged in
	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Need to sign in to add a community!
					</div>';
	$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Community</button>';
	
	include 'addcommunity.html.php';
	exit();
  } // end if-else user is logged in
  mysqli_close($con);

?>
