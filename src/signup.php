<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Login, SignIn, Signout functions </title>
	</head>

	<body>
		<?php
			if($_SESSION['loggedin'])
				header('location:index.php');
		?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			Username: <input type="text" name="username" maxlength="30"
				value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>"
				><br>
			Password: <input type="password" name="password1"><br>
			Confirm Password: <input type="password" name="password2"><br>
			Email: <input type="email" name="email"
				value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"
				><br>

			<input type="submit">
		</form>
		<a href="signout.php">Logout</a>
	</body>
</html>

<?php
/*
 * Handles the user signup process
 */

if($_SERVER["REQUEST_METHOD"] == "POST"){
	require('/vagrant/src/models/User.php');

	$username  = $_POST["username"];
	$password1 = $_POST["password1"];
	$password2 = $_POST["password2"];
	$email 	   = $_POST["email"];

	echo User::create($username, $password1, $password2, $email); 
}
?>
