<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/reset.css" rel="stylesheet" media="screen">
		<link href="css/main.css" rel="stylesheet" media="screen">
	</head>

	<!-- body classes are important to css -->
	<body class="home page">
		
		<?php
			include 'header.php';
		?>
		
		<!-- haven't touched below here -->
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
