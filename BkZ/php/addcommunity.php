<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<form action="addnew_community.php" method="post" enctype="multipart/form-data">
Community Name: <input type="text" name="communityname"><br>
<?php
     if (isset($_SESSION['loggedin'])) {
        echo '<input type="submit" value="Create"><br>';
     } else {
        echo "You must be Logged in to perform this function!<br>";
     }
?>

<a href="http://localhost/index.php">Back to Home Page</a> 

</form>
</body>
</html>
