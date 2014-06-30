<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Home </title>
	</head>

	<body>
		<?php 
			if($_SESSION['loggedin']) 
				echo "Welcome " . $_SESSION['username'];
			else
				echo "Welcome! You are not logged in";
		?>
		<br>
		<a href="signin.php">Sign in</a>
		<a href="signup.php">Sign Up</a>
		<a href="signout.php">Logout</a>
	</body>
</html>
