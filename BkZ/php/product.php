<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
<head>
<title>Product Home Page</title>
</head>

<?php

$product = $_GET["id"];
$productowner = -1;
$hasreview = 0;
$memberreviewed = 0;

echo "Selected product = " . $product . "<br>";


$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "<table border='1'>
<tr>
<th>ProductID</th>
<th>OwnerID</th>
<th>Product Name</th>
<th>Product Description</th>
<th>Rating</th>
<th>Retail</th>
<th>Listed</th>
<th>Category</th>
<th>Reviews</th>
</tr>";

$sql="select * from product where productid=" . $product;
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
  $calculatedrating = 0;
  if ($row['numreviews'] > 0) {
    $calculatedrating = $row['rating'] / $row['numreviews'];
    $hasreview = TRUE;
  }
  $productowner = $row['ownerid'];
  echo "<tr>";
  echo "<td>" . $row['productid'] . "</td>";
  echo "<td>" . $productowner . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $calculatedrating . "</td>";
  echo "<td>" . $row['retailprice'] . "</td>";
  echo "<td>" . $row['listedprice'] . "</td>";
  echo "<td>" . $row['category'] . "</td>";
  echo "<td>" . $row['numreviews'] . "</td>";
  echo "</tr>";

}
echo "</table> </br>";

echo "<table border='1'>
<tr>
<th>DetailID</th>
<th>ProductID</th>
<th>Type</th>
<th>Description</th>
<th>Picture</th>
</tr>";

$piclink = "";
$sql="select * from productdetail where productid=" . $product;
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['detailid'] . "</td>";
  echo "<td>" . $row['productid'] . "</td>";
  echo "<td>" . $row['type'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  $piclink = '<img src="' . $row['path'] . '">';
  echo "<td>" . $piclink . "</td>";
  echo "</tr>";
  }
echo "</table> </br>";

if ($hasreview > 0) {
  $sql="select * from review where productid=" . $product;
  $result = mysqli_query($con,$sql);
  echo "<table border='1'>
  <tr>
  <th>Member ID</th>
  <th>Review</th>
  <th>Rating</th>
  <th>Date</th>
  </tr>";


  while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['memberid'] . "</td>";
    echo "<td>" . $row['reviewdetails'] . "</td>";
    echo "<td>" . $row['rating'] . "</td>";
    echo "<td>" . $row['reviewdata'] . "</td>";
    echo "</tr>";
    if (isset($_SESSION['memberid'])) {
      if ($row['memberid'] == $_SESSION['memberid']) { $memberreviewed += 1; }
    }
  }
  echo "</table> </br>";

}



mysqli_close($con);  

if (isset($_SESSION['memberid'])) {
  if ($memberreviewed == 0) {
    $reviewlink = '<a href="http://localhost/reviewproduct.php?id=' . $product . '">Review</a>';
    echo $reviewlink . "<br>";
  } else {
    echo "You have already reviewed this product! <br>";
  }
  if ($_SESSION['memberid'] == $productowner) {
    $addnewdetaillink = '<a href="http://localhost/addnewdetail.php?id=' . $product . '">New Detail</a>';
    echo $addnewdetaillink . "<br>";
  }
}

?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</body>
</html>
