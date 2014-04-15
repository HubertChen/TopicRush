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
        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';;
        $file = fopen($filterfile,"r");
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) {
            array_push($filterlist,$input);
          }
        }
        $filtersize = count($filterlist);

  	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost:3306";
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
    	
		while ($row=mysqli_fetch_array($result)) {
      		if (strtolower($postemail) == strtolower($row["email"])) {
        		$validform = FALSE;
        		$formerrors = $formerrors . "Username already exists!<br/>";
      		} // end if email address already in database    
    	} // end for checking email already in database

        $valid = TRUE;
        if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postemail) == TRUE) {
          $valid = FALSE;
          $validform = FALSE;
          $formerrors = $formerrors . 'Invalid input, please try again!<br>';
        }
        if ($valid == TRUE) {
          $index = 0;
          while (($index < $filtersize) && ($valid == TRUE)) {
            $pattern = '/' . $filterlist[$index] . '/i';
            if (preg_match($pattern,$postemail) == TRUE) {
              $valid = FALSE;
              $validform = FALSE;
              $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
            } // end if input matches filter word
            $index += 1;
          } // end while loop to loop through each filter word
        } // end if $valid == TRUE


		
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
                $randomavatar = rand(1,8);
                $avatarpath = 'C:\\wamp\\www\\bzk\\images\\avatars\\' . $randomavatar . '.png';
			$hashedPass = crypt($password1, 'Sfgh9m66MZ9zdn46XYK6');
			$sql = "insert into member(username,password,email,role,status,joindate,lastlogin,avatarpath) values('$username','$hashedPass','$email','$role','0','$tstamp','$tstamp','$avatarpath')";
			mysqli_query($con,$sql);
			$sql="select memberid from member where email='$email'";
			$result=mysqli_query($con,$sql);
			$memberid = 0;
			
			while ($row=mysqli_fetch_array($result)) { $memberid=$row["memberid"]; }
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['username'] = $username;
			$_SESSION['memberid'] = $memberid;
			$_SESSION['role'] = $role;
      $_SESSION['lastlogin'] = $tstamp;
      $_SESSION['avatarpath'] = $avatarpath;
      header('Location: /bzk/index.php');
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
