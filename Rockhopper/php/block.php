<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>


<?php
  if (isset($_SESSION['loggedin'])) {
    $memberid = $_GET['member'];
    $communityid = $_GET["community"];    
    $blockowner = FALSE;
    

    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'delos2';


    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }
    $sql="select ownerid from community where communityid=" . $communityid;
    $result=mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {   
      if ($row['ownerid'] == $memberid) { $blockowner = TRUE; }
    }
  
    if ($blockowner == FALSE) {

      $sql = "select * from block where memberid=" . $memberid . " and communityid=". $communityid;
      $result = mysqli_query($con,$sql);
      $alreadyblocked = 0;
      while($row = mysqli_fetch_array($result)) {
        $alreadyblocked += 1;
      }

      if ($alreadyblocked > 0) {
        echo "You have already blocked that member from this community!<br>";
      } else {
        $sql = "insert into block(memberid,communityid) values (". $memberid . "," . $communityid . ")";
        mysqli_query($con,$sql);
        echo "You have blocked this member from this community!<br>";
      }
    } else { // end if blockowner == false
      echo "You cannot block the owner of the community!<br>";
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
