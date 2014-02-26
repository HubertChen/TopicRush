<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<form action="login_results.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<?php
     if (isset($_SESSION['loggedin'])) {
        echo "You are already logged in!<br>";
     } else {
        echo '<input type="submit" value="Login">';
     }
?>

</form>
<a href="http://localhost/index.php">Back to Home Page</a> 
</body>
</html>
