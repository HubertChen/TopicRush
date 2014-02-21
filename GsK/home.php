<?php session_start(); ?>

<!DOCTYPE html>
<html>
<body>

<?php
if (isset($_SESSION['loggedin'])) {

  echo "<head>";
  $title = "<title> Welcome " . $_SESSION['username'] . " to your home page!</title>";
  echo $title;
  echo "</head>";



} else {
  echo "You must be logged in to access this page!<br>";
}





?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</body>
</html>
