<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php

$memberid = $_SESSION['memberid'];

$productname = $_POST["productname"];
$description = $_POST["description"];
$category = $_POST["category"];
$newcategory = $_POST["newcategory"];
$retailprice = $_POST['retailprice'];
$listedprice = $_POST['listedprice'];
$picdesc = $_POST['picdesc'];
$productid = 0;
$productpath = 'C:\\wamp\\www\\products\\';

echo $productname . "<br>";
echo $description . "<br>";
echo $category . "<br>";
echo $newcategory . "<br>";
echo $retailprice . "<br>";
echo $listedprice . "<br>";


if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
}


// NEED TO DO FORM VALIDATION BEFORE ANY DATABASE FUNCTIONS

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';
$loggedon = FALSE;

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($category == "addnew") {
  echo "Attempting to add ( " . $newcategory . " ) <br>";
  $sql = "select * from category";
  $result = mysqli_query($con,$sql);
  $found = 0;
  $foundid = -1;
  while(($row = mysqli_fetch_array($result)) and ($found == 0)){
    $pattern = "/" . strtolower($newcategory) . "/";
    if (preg_match($pattern,strtolower($row['name']))) { 
      $found += 1; 
      $foundid = $row['categoryid'];
      echo "Found! " . $pattern . " = " . $row['name'] . "<br>";
    } 
  } // end while loop
  if ($found == 0) {
    echo "Adding new Category ( " . $newcategory . " )<br>";
    $sql = "insert into category(name) values('" . $newcategory . "')";
    mysqli_query($con,$sql);
    $sql = "select categoryid from category where name='" . $newcategory . "'";
    $result = mysqli_query($con,$sql);
    foreach($result as $row) { $category = $row['categoryid']; }
  } else {
    echo "Category Already exists at " . $foundid . "<br>";
  }

} // new category 



$sql="insert into product(ownerid,name,description,rating,retailprice,listedprice,category,numreviews) values ('$memberid','$productname','$description','0','$retailprice','$listedprice','$category','0')";
mysqli_query($con,$sql);


$sql="select * from product where name='$productname'";

$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
   $productid = $row['productid'];
}

$productid=$productid . "";
$productpath=$productpath . $productid;
mkdir($productpath,0777);
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

move_uploaded_file($_FILES["file"]["tmp_name"],$productpath . "\\" . $detailid . ".jpg");
$filepath = "/products/" . $productid . "/" . $detailid . ".jpg";
$sql = "update productdetail set path='" . $filepath . "' where detailid=" . $detailid;
mysqli_query($con,$sql);



mysqli_close($con);  

echo "Product added successfully!<br>";



?>

<a href="http://localhost/index.php">Back to Home Page</a> 
</body>
</html> 

