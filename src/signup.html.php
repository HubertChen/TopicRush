<!-- DONE: 4/6/14 -->
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

    <title>Circle | Sign Up</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  
  
<!-- NAVBAR
================================================== -->
  <body style="background-color:#7aadd9">
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
   
    
	<!-- Sign Up Form
    ================================================== -->
	<div class="container" style="background-color:rgb(255, 255, 255)">
    	<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php if (isset($errorMessage)) { echo $errorMessage; } ?>
        <form action="signup.php" method="post" class="form-signin form-horizontal" role="form">
  			<h2 class="form-signin-heading">Sign up for Circle</h2>
 			<div class="form-group">
                <label class="sr-only" for="email">Email</label>
 				<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required autofocus>
			</div>
			<div class="form-group">
				<label class="sr-only" for="password1">Password</label>
				<input type="password" class="form-control" name="password1" id="password1" placeholder="Password" value="<?php $password1; ?>" required>
			</div>
			<div class="form-group">
				<label class="sr-only" for="password2">Password</label>
				<input type="password" class="form-control" name="password2" id="password2" placeholder="Retype Password" value="<?php $password2; ?>" required>
			</div>
			<h5>Role:</h5>
			<div class="radio-inline">
				<label>
					<input type="radio" name="role" id="user" value="u" checked>User
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<input type="radio" name="role" id="seller" value="s">Seller
				</label>
			</div>
			<?php echo $button; ?>
            <!--<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button> -->
            <p class="text-center" ><a href="signin.php">Sign In </a></p>
		</form> 
        <br/>
        <br/>
        <br/>
        <br/>
      </div><!-- /end of container -->
 
		
        <!-- Footer
    ================================================== -->
      <div class="container">
          <footer>
              <br/>
              <br/>
              <br/>
              <div align="center">
                <img src="images/logoWhite.png" width="75" height="75" align="Circle">
              </div>
              <br/>
              <br/>
              <br/>
              <hr/>
              <p class="pull-right footer-color"><a href="#top" class="footer-color">Back to top</a></p>
              <p class="footer-color">&copy; 2014 Circle, Inc. &middot; <a href="privacy.php" class="footer-color">Privacy</a> &middot; <a href="terms.php" class="footer-color">Terms</a> &middot; <a href="about.php" class="footer-color">About</a></p>
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