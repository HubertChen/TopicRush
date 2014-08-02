<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>TopicRush - Login</title>
		
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
			
						<button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit">Sign In</button>
						<a href="signup.php" id="signup">Sign Up</a>
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
if($_SESSION['loggedin'] == TRUE){
	session_unset();
?>
<script>
	$("#homepage").prepend("<div class='alert alert-success' role='alert'>Successfully logged out.</div>");
</script>
<?php
}



if(isset($_POST['submit'])){
	include('../models/Database.php');

	$username = $_POST["username"];
	$password = $_POST["password"];
	$database = new Database();

	if($database->verify_user($username, $password)){
        	$_SESSION['loggedin'] = TRUE;
  		$_SESSION['username'] = $username;
		header("Location: index.php");
	}else{?>
		<script>
        		$("#homepage").prepend("<div class='alert alert-danger' role='alert'>Incorrect Login</div>");
		</script>
	<?php
	}
}
?>
