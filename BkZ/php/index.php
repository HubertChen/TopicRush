<?php session_start(); ?>

<!DOCTYPE html>
<html>
<body>
<head>
<title> Welcome to Delos, an online community for social interests!</title>
</head>

<form action="search.php" method="post" enctype="multipart/form-data">
Search: <input type="text" name="search">
<input type="submit" value="Search">
<br>

<a href="/login.php">
<img src="/images/login_button.jpg" alt "Login"><p></p>
</a>

<a href="/register.php">
<img src="/images/register.jpg" alt "Register"><p></p>
</a>

<a href="/addproduct.php">
<img src="/images/add_product.jpg" alt "Add Product"><p></p>
</a>

<a href="/addcommunity.php">
<img src="/images/add_community.jpg" alt "Add Community"><p></p>
</a>

<?php
   echo "Welcome to Delos! </br>";
   if (isset($_SESSION['loggedin'])) {
      echo "You ARE logged in! ". $_SESSION['memberid'] . "<br>";
      echo '<a href="/home.php">Home</a>'; 
   } else {
      echo "You are NOT logged in!<br>";
   }




$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'delos2';

$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"SELECT * FROM member");

echo "<table border='1'>
<tr>
<th>MemberID</th>
<th>Username</th>
<th>Password</th>
<th>Role</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['memberid'] . "</td>";
  echo "<td>" . $row['username'] . "</td>";
  echo "<td>" . $row['password'] . "</td>";
  echo "<td>" . $row['role'] . "</td>";
  echo "</tr>";
  }
echo "</table> </br></br>";

$result = mysqli_query($con,"SELECT * FROM community");

echo "<table border='1'>
<tr>
<th>Community ID</th>
<th>Owner ID</th>
<th>Name</th>
<th>Created</th>
<th>Members</th>
<th>Topics</th>
<th>Join</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  $link = '<a href="http://localhost/community.php?id=' . $row['communityid'] . '">' . $row['communityid'] . '</a>';
  echo "<td>" . $link . "</td>";
  echo "<td>" . $row['ownerid'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['created'] . "</td>";
  echo "<td>" . $row['nummembers'] . "</td>";
  echo "<td>" . $row['numtopics'] . "</td>";
  $joinlink = '<a href="http://localhost/join.php?id=' . $row['communityid'] . '">Join</a>';
  echo "<td>" . $joinlink . "</td>";
  echo "</tr>";
  }
echo "</table> </br></br>";

$result = mysqli_query($con,"SELECT * FROM product");

echo "<table border='1'>
<tr>
<th>ProductID</th>
<th>Product Name</th>
<th>Product Description</th>
<th>Rating</th>
<th>Category</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  $link = '<a href="http://localhost/product.php?id=' . $row['productid'] . '">' . $row['productid'] . '</a>';
  echo "<td>" . $link . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $row['rating'] . "</td>";
  echo "<td>" . $row['category'] . "</td>";
  echo "</tr>";
  }
echo "</table> </br></br>";


mysqli_close($con);  


?>

<a href="/logout.php">
<img src="/images/logout_button.jpg" alt "Log Out"><p></p>
</a>

</body>
</html>
