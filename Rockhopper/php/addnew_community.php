<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<?php


$memberid = $_SESSION['memberid'];
$communityname = $_POST["communityname"];

echo $communityname . "<br>";
echo $memberid . "<br>";

$date = new DateTime();
$tstamp = $date->format('Y-m-d H:i:s');

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';
$loggedon = FALSE;

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql="insert into community(ownerid,name,created,nummembers,numtopics) values ('$memberid','$communityname','$tstamp','0','0')";
mysqli_query($con,$sql);


mysqli_close($con);  

echo $communityname . " Community Successfully created!<br>";


?>

<a href="http://localhost/index.php">Back to Home Page</a> 
</body>
</html> 

