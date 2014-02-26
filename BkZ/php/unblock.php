<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>


<?php
  if (isset($_SESSION['loggedin'])) {
    $memberid = $_GET['member'];
    $communityid = $_GET["community"];    
    $isblocked = 0;
    

    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'delos2';


    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }
    $sql="select * from block where memberid=" . $memberid . " and communityid=" . $communityid;
    $result=mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {   
      $isblocked += 1;
    }
    if ($isblocked > 0) {
      $sql="delete from block where memberid=" . $memberid . " and communityid=" . $communityid;
      mysqli_query($con,$sql);
      echo "You have unblocked this member from this community!<br>";
    } else {
      echo "Member is not a part of this community, therefore, they could not be unblocked!<br>";
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
