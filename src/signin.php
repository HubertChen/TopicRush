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
			Password: <input type="password" name="password"><br>

			<input type="submit">
		</form>
		<a href="signout.php">Logout</a>
	</body>
</html>

<?php
/* 
 * Handles the user login process
 */
include('models/Database.php');

$username = $_POST["username"];
$password = $_POST["password"];

$database = new Database();
if($database->verify_user($username, $password)){
	$_SESSION['loggedin'] = TRUE;
	$_SESSION['username'] = $username;
	echo "User signed in success";
}else
	echo "User signed in failed";
?>
