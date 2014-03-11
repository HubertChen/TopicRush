<?php session_start(); ?>

<?php     
  $validform = FALSE;
  $formerrors = array();
  $email = "";
  $password1 = "";
  $password2 = "";
  $role = "";
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
  	
	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Failed to connect to MySQL: </strong>' . mysqli_connect_error() . '. Please try again later.
					</div>';
					
	$button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';

	
	include 'signup.html.php';
	exit();
  }
     
	 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numerrors = 0;
    $postemail = $_POST["email"];
    $postpassword1 = $_POST["password1"];
    $postpassword2 = $_POST["password2"];
    $role = $_POST["role"];

    $sql = "select email from member";
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) {
      if (strtolower($postemail) == strtolower($row["email"])) {
        $numerrors += 1;
		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Email address already registered!
						 </div>';
        array_push($formerrors);
      } // end if email address already in database    
    } // end for checking email already in database
    if ($numerrors == 0) { $email = $postemail; }

    if ($postpassword1 != $postpassword2) {
		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Passwords do not match!
						 </div>';
      array_push($formerrors);
      $numerrors += 1;
    } else { // end if $postpassword1 != $postpassword2
      $password1 = $postpassword1;
      $password2 = $postpassword2;
    } // end if-else $postpassword1 != $postpassword2

    if ($numerrors == 0) {
      $validform = TRUE;
      $username = substr($email,0,strpos($email,"@"));
      /*echo "Username = " . $username . "<br>";*/

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

    } else { // end if $numerrors == 0
      foreach ($formerrors as $error) {
        echo $error . "<br>";
      } // end foreach $formerrors
      $formerrors = array();
    } // end if-else $numerrors == 0
	$button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';

	include 'signup.html.php';
	
	exit();
  }
 
 
 
  if (isset($_SESSION['loggedin'])) {
    $errorMessage = '<div class="alert alert-info alert-dismissable" align="center">
     				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					Already logged In.
					</div>';
					
	/*Disables button if the user is already logged in */				
	$button = '<button class="btn btn-lg btn-primary btn-block" type="submit" disabled="disabled">Sign Up</button>';
	include 'signup.html.php';
	exit();
	} 
  else {
    if ($validform == FALSE) {
		
      $button = '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>';
		include 'signup.html.php';
	  exit();
    }
  }

  mysqli_close($con);

?>
