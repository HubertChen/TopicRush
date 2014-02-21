<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$username = $_POST["username"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$city = $_POST["city"];
$state = $_POST["state"];
$zipcode = $_POST["zipcode"];
$role = $_POST["role"];
$email = $_POST["email"];
$valid = 0;
$lcname = strtolower($username);
$realrole = "";
$date = new DateTime();
$tstamp = $date->format('Y-m-d H:i:s');

if ($password1 != $password2) { 
   $valid += 1; 
   echo "Passwords DO NOT match!<br>";
}

// NEED TO VALIDATE THE FORM DATA

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';


$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$result=mysqli_query($con,"select username from member");
foreach($result as $row) { 
   $testname = strtolower($row["username"]);
//   echo $testname . " = " . $lcname . "<br>";
   if ($testname == $lcname) { 
      $valid += 1; 
      echo "Username already exists!<br>";
   }
}

if ($valid == 0) {
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

}
mysqli_close($con);  



echo $username . "<br>";
echo $password1 . "<br>";
echo $password2 . "<br>";
echo $city . "<br>";
echo $state . "<br>";
echo $zipcode . "<br>";
echo $role . "<br>";
echo $email . "<br>";
echo $valid . "<br>";

?>

<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

