<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>
<?php
   session_destroy();
   echo "You have successfully logged out!<br>";
?>
<a href="http://localhost/bzk/index.php">Back to Home Page</a> 
</body>
</html>
