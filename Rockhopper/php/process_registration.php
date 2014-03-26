<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<head>
<!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/styles.css" rel="stylesheet">
    

</head>
<body>

<?php

$username = $_POST["username"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$city = $_POST["city"];
$state = $_POST["state"];
$zipcode = $_POST["zip"];
$role = $_POST["role"];
$email = $_POST["email"];
$lcname = strtolower($username);
$realrole = "";
$date = new DateTime();
$tstamp = $date->format('Y-m-d H:i:s');
$validform = TRUE;
$formerrors = array();


// NEED TO VALIDATE THE FORM DATA

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';


$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($password1 != $password2) { 
   $validform = FALSE;
   array_push($formerrors,"Password DO NOT MATCH!<br>");
}

$sql="select username from member";
$result=mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
  if (strtolower($username) == strtolower($row['username'])) {
    $validform = FALSE;
    array_push($formerrors,"Username already exists!<br>");
  }
}

if (!is_numeric($zipcode)) {
  $validform = FALSE;
  array_push($formerrors,"Zipcode must only contain numbers!<br>");
}

if ($validform == TRUE) {

  if ($role == 'user') { $realrole = 'u'; } else { $realrole = 's'; }
  $sql="insert into member(username,password,city,state,zip,role,status,email,joindate,lastlogin) values ('$username','$password1','$city','$state','$zipcode','$realrole','0','$email','$tstamp','$tstamp')";
  mysqli_query($con,$sql);
  $sql="select memberid from member where username='$username'";
  $result=mysqli_query($con,$sql);
  $memberid = 0;
  foreach($result as $row) { $memberid=$row["memberid"]; }
  $_SESSION['loggedin'] = TRUE;
  $_SESSION['username'] = $username;
  $_SESSION['memberid'] = $memberid;
  $_SESSION['role'] = $realrole; 

  echo "You have successfully registered and are now logged in!";


} else { // end if $vaidform == TRUE
  foreach($formerrors as $error) {
    echo $error;
  }
} // end if-else $validform == TRUE
mysqli_close($con);  



echo $username . "<br>";
echo $password1 . "<br>";
echo $password2 . "<br>";
echo $city . "<br>";
echo $state . "<br>";
echo $zipcode . "<br>";
echo $role . "<br>";
echo $email . "<br>";

?>

	<form action="process_registration.php" method="post" class="form-signin form-horizontal" role="form">
        <h2 class="form-signin-heading">Sign up for Circle</h2>
             <div class="form-group">
                <label class="sr-only" for="email">Email</label>
    			<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
 			 </div>
        
             
             <div class="form-group has-success has-feedback">
    				<label class="sr-only" for="inputSuccess4">Input with success</label>
                    <input type="email" class="form-control" name="emailSuccess" id="email"><span class="glyphicon glyphicon-ok form-control-feedback"></span>
  			</div>
            
            <div class="form-group has-error has-feedback">
    				<label class="sr-only" for="inputSuccess4">Input with success</label>
                    <input type="email" class="form-control" name="emailSuccess" id="email"><span class="glyphicon glyphicon-remove form-control-feedback"></span>
  			</div>
            
            
            
            
            
             <div class="form-group">
                <label class="sr-only" for="password1">Password</label>
    			<input type="password" class="form-control" name="password1" id="password1" placeholder="Password">
             </div>
             <div class="form-group">
                <label class="sr-only" for="password2">Password</label>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Retype Password">
 			 </div>
             <p>Role:</p>
             <div class="radio-inline">
                <label>
   					<input type="radio" name="role" id="user" value="user" checked>User
  				</label>
             </div>
             <div class="radio-inline">
                <label>
   					<input type="radio" name="role" id="seller" value="seller">Seller
  				</label>
             </div>
</div>
             
             
             
             
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
        <p class="text-center" ><a href="signin.html">Sign In </a></p>
      </form>




<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

