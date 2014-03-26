<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$communityid = $_GET["id"];
$memberid = $_SESSION["memberid"];
$topicname = $_POST["topicname"];
$product = $_POST["product"];
$productid = 0;
if ($product != "none") { $productid = $product; }
$hascontent = $_POST["content"];
$message = $_POST["message"];
$hasfile = $_POST["addfile"];
$picdesc = $_POST["picdesc"];
$date = new DateTime();
$tstamp = $date->format('Y-m-d H:i:s');
$topicpath = 'C:\\wamp\\www\\topics\\';

// NEED TO VALIDATE THE FORM DATA

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';


$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$sql = "insert into topic(communityid,ownerid,followid,productid,name,created) values ('$communityid','$memberid','0','$productid','$topicname','$tstamp')";
mysqli_query($con,$sql);

$newtopicid = -1;


if ($hascontent == "Yes") {
  $newtype = 0; // 0 = Text and no picture
  $newpath = "";
  $newdesc = "";
  $sql = "select topicid from topic where created='" . $tstamp . "'";
  $result = mysqli_query($con,$sql);
  foreach($result as $row) {
    $newtopicid = $row['topicid'];
  }

  if ($hasfile == "Yes") {
    if ($_FILES["file"]["error"] > 0) {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else {
      echo "Upload: " . $_FILES["file"]["name"] . "<br>";
      echo "Type: " . $_FILES["file"]["type"] . "<br>";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
      echo "Stored in: " . $_FILES["file"]["tmp_name"];
      echo "<br>";
      $newtype = 1; // 1 = Text and picture
      $newdesc = $picdesc;
      $newtopicid = $newtopicid . "";
      $topicpath=$topicpath . $newtopicid;
      echo "topicpath = " . $topicpath . "<br>";
      if (is_dir($topicpath)) {
        echo "Dir already exists ( " . $topicpath . " )<br>";
      } else {
        echo "Creating dir ( " . $topicpath . " )<br>";
        mkdir($topicpath,0777);
      }
    }
  } // end if has file
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');
  $sql = "insert into content(topicid,ownerid,message,type,path,description,created) values('$newtopicid','$memberid','$message','$newtype','$newpath','$newdesc','$tstamp')";
  mysqli_query($con,$sql);
  $contentid = -1;
  $sql="select contentid from content where created='" . $tstamp . "'";
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) {
     $contentid = $row['contentid'];
     echo "<br> ContentID = " . $contentid . "<br>";
  }
  

  if ($hasfile == "Yes") {
    move_uploaded_file($_FILES["file"]["tmp_name"],$topicpath . "\\" . $contentid . ".jpg");
    $filepath = "/topics/" . $newtopicid . "/" . $contentid . ".jpg";
    $sql = "update content set path='" . $filepath . "' where created='" . $tstamp . "'";
    mysqli_query($con,$sql);
  }
  
  


} // end if has content





mysqli_close($con);  

echo "Community = " . $communityid . "<br>";
echo "Topic Name = " . $topicname . "<br>";
echo "Product = " . $product . "<br>";
echo "Content = " . $hascontent . "<br>";
echo "Message = " . $message . "<br>";
echo "Has File = " . $hasfile . "<br>";
echo "Pic Desc = " . $picdesc . "<br>";



?>

<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

