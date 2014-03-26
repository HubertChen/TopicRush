<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>


<?php
  if (isset($_SESSION['loggedin'])) {
    $memberid = $_SESSION['memberid'];
    $communityid = $_GET["id"];    

    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'delos2';


    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }

    $sql = "select * from joins where memberid=" . $memberid . " and communityid=". $communityid;
    $result = mysqli_query($con,$sql);
    $alreadyjoined = 0;
    while($row = mysqli_fetch_array($result)) {
      $alreadyjoined += 1;
    }

    if ($alreadyjoined > 0) {
      $sql = "delete from joins where memberid=" . $memberid . " and communityid= " . $communityid;
      mysqli_query($con,$sql);
      echo "You have left this community!<br>";
    } else {
      echo "You are not a member of this community!<br>";
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
