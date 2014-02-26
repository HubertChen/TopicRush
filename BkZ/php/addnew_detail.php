<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$memberid = $_SESSION['memberid'];
$productid = $_GET["id"];

$picdesc = $_POST["picdesc"];
$productpath = 'C:\\wamp\\www\\products\\';

echo $productid . "<br>";
echo $picdesc . "<br>";

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
}

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';
$loggedon = FALSE;

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$productid=$productid . "";
$productpath=$productpath . $productid;
$temppath = "new product path";
$sql="insert into productdetail(productid,type,path,description) values('$productid','1','$temppath','$picdesc')";
mysqli_query($con,$sql);

$detailid = -1;

$sql="select detailid from productdetail where productid=" . $productid . " and path='" . $temppath . "'";



$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
   $detailid = $row['detailid'];
   echo "<br> DetailID = " . $detailid . "<br>";
}


$filepath = "/products/" . $productid . "/" . $detailid . ".jpg";
move_uploaded_file($_FILES["file"]["tmp_name"],$productpath . "\\" . $detailid . ".jpg");
$sql = "update productdetail set path='" . $filepath . "' where detailid=" . $detailid;
mysqli_query($con,$sql);


mysqli_close($con);  

echo "Product added successfully!<br>";



?>

<a href="http://localhost/index.php">Back to Home Page</a> 
</body>
</html> 

