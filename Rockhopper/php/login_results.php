<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$username = $_POST["username"];
$password = $_POST["password"];
$memberd = -1;
$role = "";

echo $username . "</br>";

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';
$loggedon = FALSE;

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"SELECT * FROM member");

while(($row = mysqli_fetch_array($result)) && ($loggedon == FALSE))
  {
    if ($username == $row['username']) {
      if ($password == $row['password']) { 
         $loggedon = TRUE; 
         $memberid = $row['memberid'];
         $role = $row['role'];
      }
    }
  echo "<tr>";
  echo "<td>" . $row['memberid'] . "</td>";
  echo "<td>" . $row['username'] . "</td>";
  echo "<td>" . $row['password'] . "</td>";
  echo "</tr>";
  }
echo "</table> </br></br>";

mysqli_close($con);  

if ($loggedon == TRUE) {
  echo "Sucessful Login!";
  $_SESSION['loggedin'] = TRUE;
  $_SESSION['username'] = $username;
  $_SESSION['memberid'] = $memberid;
  $_SESSION['role'] = $role;

} else {
  echo "BAD Login Attempt!";
}

?>
<br>



<a href="http://localhost/index.php">Back to Home Page</a> 

</body>
</html> 