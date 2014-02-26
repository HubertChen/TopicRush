<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>


<?php
  if (isset($_SESSION['loggedin'])) {
    $memberid = $_SESSION['memberid'];
    $topicid = $_GET["id"];    

    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'delos2';


    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }

    $sql = "select * from follows where memberid=" . $memberid . " and topicid=". $topicid;
    $result = mysqli_query($con,$sql);
    $alreadyfollows = 0;
    while($row = mysqli_fetch_array($result)) {
      $alreadyfollows += 1;
    }

    if ($alreadyfollows > 0) {
      echo "You are already following this topic!<br>";
    } else {
      $sql = "insert into follows(memberid,topicid) values (". $memberid . "," . $topicid . ")";
      mysqli_query($con,$sql);
      echo "You are now following this topic!<br>";
    }
    
    mysqli_close($con);
  } else {
    echo "You must be Logged in to perform this function!<br>";
  }

?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</form>
</body>
</html>
