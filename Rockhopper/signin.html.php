<?php header('Location: http://webmaster.iu.edu/'); ?>



<!DOCTYPE html>
<html lang="en">
  <head>
  
  	<!-- Need to add necessary meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle | Sign In</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  
  
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" align="center">   
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">
          	<img src="images/logo03.png" alt="Circle" width="47" height="47" vspace="2">&nbsp;
         	 <img src="images/logotext.png" alt="Circle" width="94" height="28">
          </a>
        </div>
      </div>
    </div>
   
    
	<!-- Sign In Form
    ================================================== -->
	<div class="container">
    	<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php echo $errorMessage; ?>
        <form class="form-signin" role="form" action="signin.php" method="post">
        	<h2 class="form-signin-heading">Please sign in</h2>
            <label class="sr-only" for="email">Email</label>
			<input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $email ?>" required autofocus>
            <label class="sr-only" for="password">Password</label>
			<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php echo $password ?>" required>
			<!-- Keeps User logged In - involves cache -->
            <!--<label class="checkbox">
				<input type="checkbox" value="remember-me"> Remember me
			</label>-->
			<?php echo $button; ?>
            <!--<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button> -->
            <p class="text-center" ><a href="signup.php">Sign Up </a></p>
		</form>
	
    
    	<hr class="featurette-divider">


      	<!-- Footer
   		 ================================================== -->
      	<footer>
            <!--<ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
            </ol>-->
        	<p class="pull-right"><a href="#">Back to top</a></p>
        	<p>&copy; 2014 Circle, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">About</a></p>
     	</footer>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
  </body>
</html>