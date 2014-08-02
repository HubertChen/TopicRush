<?php 
	session_start(); 

	if($_SESSION['loggedin'] == true)
		header("Location: index.php");	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>TopicRush - Signup</title>
		
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet" media="screen">
	</head>
	
	<body id="homepage">
		<div class="container">
			<div class="panel panel-default">
				<h1>Sign Up</h1>
				<div class="panel-body">
					<form id="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<div class="input-group" id="username">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input class="form-control" name="username" type="text" placeholder="Username" required="" autofocus="">
						</div>

						<div class="input-group" id="password">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password1" class="form-control" placeholder="Password" required="">
						</div>

						<div class="input-group" id="password2">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password2" class="form-control" placeholder="Confirm Password" required="">
						</div>
			
						<div class="input-group" id="email">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="email" name="email" class="form-control" placeholder="E-mail" required="">
						</div>

						<button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit">Sign Up</button>
						<a href="signin.php" id="signin">Sign In</a>
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
 * Handles the user signup process
 */

if($_SERVER["REQUEST_METHOD"] == "POST"){
        require('/vagrant/src/models/User.php');

        $username  = $_POST["username"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $email     = $_POST["email"];

        $status = User::create($username, $password1, $password2, $email);

	if(strpos($status, "!") == false){
	?>
		<script>
			$("#homepage").prepend("<div class='alert alert-danger' role='alert'><?php echo $status ?></div>");
		</script>
	<?php
	} else{
		echo "HI";
		$_SESSION['username'] = $username;
		$_SESSION['loggedin'] = TRUE;
		header("Location: index.php");
	}
}
?>
