<?php 
	session_start(); 

	if($_SESSION['logged_in'] != TRUE)
		header('login.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>TopicRush</title>
		
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet" media="screen">
	</head>
	
	<body id="homepage">
		<div class="container">
			<div class="panel panel-default">
				<h1>Sign in</h1>
				<div class="panel-body">
				<form id="signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<div class="input-group" id="username">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input class="form-control" name="username" type="text" placeholder="Username" required="" autofocus="">
					</div>

					<div class="input-group" id="password">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" name="password" class="form-control" placeholder="Password" required="">
					</div>
		
					<button class="btn btn-sm btn-primary btn-block" type="submit" id="submit" name="submit">Sign In</button>
				</form>
			</div>
		</div>
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
/* 
 * Handles the user login process
 */
include('../models/Database.php');

$username = $_POST["username"];
$password = $_POST["password"];

$database = new Database();
echo $_POST['submit'];

if(isset($_POST['submit'])){
if($database->verify_user($username, $password)){
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['username'] = $username;
}else{?>
	<script>
        	$("#submit").after("<p id='status'>Incorrect Login</p>");
	</script>
<?php
}
}
?>
