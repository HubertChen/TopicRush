<?php session_start(); ?>
<!DOCTYPE HTML>

<html>
<body>

<?php
  $productid = $_GET["id"];
  $memberid = $_SESSION["memberid"];
  $review = $_POST["review"];
  $rating = $_POST["rating"];
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');

  echo "Product = " . $productid . "<br>";
  echo "Member = " . $memberid . "<br>";
  echo "Review = " . $review . "<br>";
  echo "Rating = " . $rating . "<br>";

  $dbhost = 'localhost:3306';
  $dbuser = 'root';
  $dbpass = '';
  $dbname = 'delos2';
  $loggedon = FALSE;

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $sql="insert into review(memberid,productid,reviewdetails,rating,reviewdata) values ('$memberid','$productid','$review','$rating','$tstamp')";
  mysqli_query($con,$sql);

  $oldrating = 0;
  $oldreviews = 0;

  $sql="select * from product where productid=" . $productid;
  $result=mysqli_query($con,$sql);
  foreach($result as $row) {
    $oldrating = $row['rating'];
    $oldreviews = $row['numreviews'];
  }

  $newrating = $oldrating + $rating;
  $newreviews = $oldreviews + 1;
  $sql="update product set rating=" . $newrating . ",numreviews=" . $newreviews . " where productid=" . $productid;
  mysqli_query($con,$sql);



  mysqli_close($con);  



?>

<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

