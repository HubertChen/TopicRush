<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$memberid = $_SESSION["memberid"];
$communityid = $_GET["community"];
$topicid = $_GET["topic"];
$message = $_POST["message"];
$hasfile = $_POST["addfile"];
$picdesc = $_POST["picdesc"];
$topicpath = 'C:\\wamp\\www\\topics\\';
$date = new DateTime();
$tstamp = $date->format('Y-m-d H:i:s');

// NEED TO VALIDATE THE FORM DATA

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';


$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$newtype = 0; // 0 = Text and no picture;
$newpath = "";
$newdesc = "";
if ($hasfile == "Yes") {
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
    $newtype = 1; // Text and picture;
    $newdesc = $picdesc;
    $topicpath=$topicpath . $topicid;
  }
} // end if has file
$sql = "insert into content(topicid,ownerid,message,type,path,description,created) values('$topicid','$memberid','$message','$newtype','$newpath','$newdesc','$tstamp')";
mysqli_query($con,$sql);

if ($hasfile == "Yes") {
  $contentid = -1;
  $sql="select contentid from content where created='" . $tstamp . "'";
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) {
     $contentid = $row['contentid'];
     echo "<br> ContentID = " . $contentid . "<br>";
  }
  move_uploaded_file($_FILES["file"]["tmp_name"],$topicpath . "\\" . $contentid . ".jpg");
  $filepath = "/topics/" . $topicid . "/" . $contentid . ".jpg";
  $sql = "update content set path='" . $filepath . "' where created='" . $tstamp . "'";
  mysqli_query($con,$sql);

} // end if $hasfile == Yes for content

mysqli_close($con);  

?>

<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

