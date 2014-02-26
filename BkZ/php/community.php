<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
<head>
<title> Community Home Page</title>
</head>

<?php

$community = $_GET["id"];
$isowner = FALSE;
$blocked = FALSE;
echo "Selected community = " . $community . "<br>";


$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_SESSION['loggedin'])) {
  $sql = "select * from block where communityid=" . $community;
  $result=mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) {
    if ($row['memberid'] == $_SESSION['memberid']) { $blocked=TRUE; }
  }
} // end if user is logged in to check for block

if ($blocked == FALSE) {

  $sql = "select * from topic where communityid='" . $community . "'";
  $result = mysqli_query($con,$sql);

  foreach($result as $row) {
    $topiclink = '<a href="http://localhost/topic.php?community=' . $community . '&topic=' . $row['topicid'] . '">' . $row['topicid'] . '</a>';
    echo $topiclink . "," . $row['communityid'] . "," . $row['ownerid'] . "," . $row['followid'] . "," . $row['productid'] . "," . $row['name'] . "," . $row['created'];
    if (isset($_SESSION['loggedin'])) {
      $followlink = '<a href="http://localhost/follow.php?id=' . $row['topicid'] . '">' . "Follow" . '</a>';
      echo " " . $followlink;
    } // user logged in
    echo "<br>";
    $sql2 = "select * from content where topicid='" . $row['topicid'] . "'";
    $result2 = mysqli_query($con,$sql2);
    foreach($result2 as $content) {
      echo ".........." . $content['contentid'] . "," . $content['topicid'] . "," . $content['ownerid'] . "," .$content['message'] . "," . $content['type'] . "," . $content['path'] . "," . $content['description'] . $content['created'] . "<br>";
      if ($content['type'] == 1) {
        $imagelink = '<img src="' . $content['path'] . '">';
        echo $imagelink . "<br>";
      }
    }
  }
  
  if (isset($_SESSION['loggedin'])) {
    $memberid = $_SESSION['memberid'];
    $sql = "select ownerid from community where communityid=" . $community;
    $result=mysqli_query($con,$sql);
    foreach($result as $row) {
      if ($row['ownerid'] == $memberid) {
        $isowner = TRUE;  
      }
    }
    if ($isowner == TRUE) {
      echo "You are the owner of this community!<br>";
      $sql="select * from joins where communityid=" . $community;
      $result=mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result)) {
        if ($row['memberid'] != $memberid) {
          $isblocked = 0;
          $sql2="select * from block where memberid=" . $row['memberid'] . " and communityid=" . $community;
          $result2=mysqli_query($con,$sql2);
          while($row2 = mysqli_fetch_array($result2)) {
            $isblocked += 1;
          }
          $blocklink = '<a href="http://localhost/block.php?community=' . $community . '&member=' . $row['memberid'] . '">Block</a><br>';
          $unblocklink = '<a href="http://localhost/unblock.php?community=' . $community . '&member=' . $row['memberid'] . '">Unblock</a><br>';
          if ($isblocked == 0) {
            echo $row['memberid'] . " " . $blocklink;
          } else {
            echo $row['memberid'] . " " . $unblocklink;          
          } // end if else member is blocked
        }
      }
    } else {
      echo "You are NOT the owner of this community<br>";
    }
    $sql = "select * from joins where memberid=" . $memberid . " and communityid=". $community;
    $result = mysqli_query($con,$sql);
    $alreadyjoined = 0;
    while($row = mysqli_fetch_array($result)) {
      $alreadyjoined += 1;
    }

    $link = '<a href="http://localhost/addtopic.php?id=' . $community . '">Add Topic</a><br>';
    $leavelink = '<a href="http://localhost/leavecommunity.php?id=' . $community . '">Leave Community</a><br>';
    if ($alreadyjoined > 0) {
      echo $link;
      echo $leavelink;
    } else {
      echo "You must join the community before posting!<br>";
    }



  } // if you are logged in

} else { // end if blocked == false

}

mysqli_close($con);  


?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</body>
</html>
