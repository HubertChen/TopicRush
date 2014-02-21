<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<?php

$search = $_POST['search'];

echo "Searching for : " . $search . "<br>";
$words = explode(" ", strtolower($search));

$count = 0;

foreach($words as $word) {
  $count += 1;
  echo $count . " - " . $word . "<br>";
}



// NEED TO VALIDATE THE FORM DATA

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';


$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "select * from product";
$result=mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
  $hits = 0;
  foreach($words as $word) {
/*
    $name = explode(" ", strtolower($row['name']));
    $description = explode(" ", strtolower($row['description']));    

    if (in_array($word,$name)) { $hits += 1; }
    if (in_array($word,$description)) { $hits += 1; }
*/
    $pattern = "/" . $word . "/";
    if (preg_match($pattern,strtolower($row['name']))) { $hits += 1; }
    if (preg_match($pattern,strtolower($row['description']))) { $hits += 1; }

  }

  if ($hits > 0) {
    $link = '<a href="http://localhost/product.php?id=' . $row['productid'] . '">' . $row['name'] . '</a>';
    echo $link;
    echo " - " . $row['description'] . "<br>";
  }
}






mysqli_close($con);  


?>


<a href="http://localhost/index.php">Back to Home Page</a>

</body>
</html> 

