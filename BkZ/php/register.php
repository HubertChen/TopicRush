<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<form action="process_registration.php" method="post" enctype="multipart/form-data">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password1"><br>
Confirm: <input type="password" name="password2"><br>
City: <input type="text" name="city"><br>
State: <input type="text" name="state"><br>
Zipcode: <input type="text" name="zipcode"><br>
Role:
<input type="radio" name="role" value="user" checked>User
<input type="radio" name="role" value="seller">Seller<br>
Email: <input type="text" name="email"><br>

<?php
     if (isset($_SESSION['loggedin'])) {
        echo "You are already registered!<br>";
     } else {
        echo '<input type="submit" value="Create"><br>';
     }
?>



<a href="http://localhost/index.php">Back to Home Page</a> 
</form>
</body>
</html>
