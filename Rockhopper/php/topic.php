<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
<head>
<title> Community Home Page</title>
</head>

<?php

$communityid = $_GET["community"];
$topicid = $_GET["topic"];

echo "Community,Topic = " . $communityid . "," . $topicid . "<br>";


$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$sql = "select * from topic where topicid=" . $topicid . " and communityid=" . $communityid;
$result = mysqli_query($con,$sql);
foreach($result as $row) {
  echo $row['topicid'] . "," . $row['communityid'] . "," . $row['ownerid'] . "," . $row['followid'] . "," . $row['productid'] . "," . $row['name'] . "," . $row['created'] . "<br>";
  $sql2 = "select * from content where topicid='" . $row['topicid'] . "'";
  $result2 = mysqli_query($con,$sql2);
  foreach($result2 as $content) {
    echo ".........." . $content['contentid'] . "," . $content['topicid'] . "," . $content['message'] . "," . $content['type'] . "," . $content['path'] . "," . $content['description'] . $content['created'] . "<br>";
    if ($content['type'] == 1) {
      $imagelink = '<img src="' . $content['path'] . '">';
      echo $imagelink . "<br>";
    }
  }
}



if (isset($_SESSION['loggedin'])) {
  $link = '<a href="http://localhost/addcontent.php?community=' . $communityid . '&topic=' . $topicid . '">Add Content</a><br>';
  echo $link;
} // if you are logged in

mysqli_close($con);  


?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</body>
</html>
