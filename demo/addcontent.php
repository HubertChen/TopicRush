<!-- DONE: 4/12/14 -->
<?php session_start() ; ?>


<?php               
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

	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
  	$dbname = "Circle";
  
 	//Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
		$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Post</button>';
		include 'addcontent.html.php';
		exit(); 
  	} 

  	$loggedin = FALSE;
  	$alreadyjoined = FALSE;
  	$validtopicid = FALSE;
  	$memberid = 0;
  	$communityid = 0;
  	$topicid = $_GET["id"];
  	$formerrors = "";
  	$extension = "";
  	date_default_timezone_set('EST');
  	$date = new DateTime();
  	$tstamp = $date->format('Y-m-d H:i:s');
        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';
        $file = fopen($filterfile,"r");
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) {
            array_push($filterlist,$input);
          }
        }
        $filtersize = count($filterlist);
        $message = '';
        $picturedescription = '';

  	if (isset($_SESSION["loggedin"])) {
    	$loggedin = TRUE;
    	$memberid = $_SESSION["memberid"];
    	$sql = 'select communityid from topic where topicid=' . $topicid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) {
      		$validtopicid = TRUE;
      		$communityid = $row["communityid"];
    	} // end while loop to determine if topicid is valid
    
		$sql = "select memberid,communityid from joins where memberid='" . $memberid . "' and communityid='" . $communityid . "'";
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { 
      		$alreadyjoined = TRUE;
    	} // end while loop to verify member has joined the community   
  	} // 

  	if (($alreadyjoined == TRUE) && ($validtopicid == TRUE)) {
		$button = '<button type="submit" class="btn btn-primary pull-right">Add Post</button>';

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$validform = TRUE;
			$hasfile = FALSE;
			$extension = '';
			$postmessage = $_POST["message"];
			$postpicturedescription = $_POST["description"];
		 
      if ((strlen($postmessage) <= 4) || (is_numeric($postmessage) == TRUE)){
        $validform = FALSE;
        $formerrors = $formerrors . 'Message but be atleast five characters and not numeric!<br>';
      } else {
        $valid = TRUE;
        if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postmessage) == TRUE) { 
          $valid = FALSE;
          $validform = FALSE;
          $formerrors = $formerrors . 'Invalid input, please try again!<br>';
        }
        if ($valid == TRUE) {
          $index = 0;
          while (($index < $filtersize) && ($valid == TRUE)) {
            $pattern = '/' . $filterlist[$index] . '/i';
            if (preg_match($pattern,$postmessage) == TRUE) {
              $valid = FALSE;
              $validform = FALSE;
              $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
            } // end if input matches filter word
            $index += 1;
          } // end while loop to loop through each filter word
        } // end if $valid == TRUE
      } // end if-else $postmessage is valid	
	
			if ($_FILES["file"]["error"] > 0) {
	
			} else { // end if no file attached
				//echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				//echo "Type: " . $_FILES["file"]["type"] . "<br>";
				//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				//echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>";
				$allowedimagetype = array("gif","jpeg","jpg","png");
				$temp = explode(".", $_FILES["file"]["name"]);
				$extension = end($temp);
				//echo "Extension type = " . $extension . "<br>";
				if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/png"))
				&& ($_FILES["file"]["size"] < 204800)
				&& in_array($extension, $allowedimagetype)) {
					$hasfile = TRUE;
				} else { // end if file is a supported type
					$validform = FALSE;
					$formerrors = $formerrors . "Picture must be .gif, .jpg, .jpeg, or .png!<br/>";
				} // end if-else is a supported type
			} // end if-else no file attached
	
			if ($hasfile == TRUE) {
			        if ((strlen($postpicturedescription) <= 4) || (is_numeric($postpicturedescription) == TRUE)) {
          $validform = FALSE;
          $formerrors = $formerrors . 'File description must be atleast five characters and not numeric!<br>';
        } else {
          $valid = TRUE;
          if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postpicturedescription) == TRUE) { 
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Invalid input, please try again!<br>';
          }
          if ($valid == TRUE) {
            $index = 0;
            while (($index < $filtersize) && ($valid == TRUE)) {
              $pattern = '/' . $filterlist[$index] . '/i';
              if (preg_match($pattern,$postpicturedescription) == TRUE) {
                $valid = FALSE;
                $validform = FALSE;
                $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
              } // end if input matches filter word
              $index += 1;
            } // end while loop to loop through each filter word
          } // end if $valid == TRUE
        } // end if-else $postpicturedescription is invalid


                        } // end if $hasfile == TRUE to validate picture description
		  
			if ($validform == FALSE) {
				$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								' . $formerrors. '
								</div>';
			} else { // end if $validform == FALSE
			// PROCESS THE FORM HERE
                                $message = mysqli_real_escape_string($con,$postmessage);
                                $picturedescription = mysqli_real_escape_string($con,$postpicturedescription);
				$postproductid = $_POST["productid"];
				$sql = '';
				if ($postproductid == 0) {
					$sql="insert into content(topicid,ownerid,message,created) values('" . $topicid . "','" . $memberid . "','" . $message . "','" . $tstamp . "')";
				} else {
					$sql="insert into content(topicid,ownerid,message,productid,created) values('" . $topicid . "','" . $memberid . "','" . $message . "','" . $postproductid . "','" . $tstamp . "')";
				}
					
					mysqli_query($con,$sql);
	
				if ($hasfile == TRUE) {
					$contentid = 0;
					$sql="select contentid from content where message='" . $message . "' and created='" . $tstamp . "'";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result)) { $contentid = $row["contentid"]; }
					$topicpath = "C:\\wamp\\www\\bzk\\topic";
					move_uploaded_file($_FILES["file"]["tmp_name"],$topicpath . "/" . $contentid . "." . $extension);
					$filepath = "/bzk/topic/" . $contentid . "." . $extension;
					$sql = "update content set path='" . $filepath . "',type='1',description='" . $picturedescription . "' where contentid='" . $contentid . "'";
					mysqli_query($con,$sql);
				} // end if $hasfile == TRUE
			
				$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Content added Successfully!
								</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Post</button>';

			} // end if-else $validform == FALSE
		} // end if post message received
		include 'addcontent.html.php';
		exit();
	} else { // end if validtopic and user is community member
		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Invalid topic, please try again later!
					</div>';
		$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Post</button>';
		include 'addcontent.html.php';
		exit();
  	} // end if else validtopic and user is community member

  	mysqli_close($con);
       
?>      
