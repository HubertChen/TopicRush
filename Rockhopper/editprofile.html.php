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

    <title>Circle | Edit Profile</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  <!-- NAVBAR
  ================================================== -->
  <body style="background-color:#7aadd9">
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">   
    	<div class="container">
        	<div class="navbar-header">
        
          		<!--Button for when the screen size is too small -->
          		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            		<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
          		<a class="navbar-brand" href="index.php">
          			<img src="images/logo03.png" alt="Circle" width="47" height="47" vspace="2">&nbsp;
         	 		<img src="images/logotext.png" alt="Circle" width="94" height="28">
          		</a>
        	</div>
			
            <!--Navbar that goes inside collapssed navbar-->
        	<div class="navbar-collapse collapse" align="center">  
          		<form class="navbar-form navbar-form-length"  role="search" >
            		<div class="form-group">
              			<input type="text" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70">
            		</div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            		<?php echo $navbar; ?>
  				</form>
  			</div>
  		</div>
  	</div>
    
     <!-- Edit Profile -->
    <div class="container" style="background-color:rgb(255, 255, 255)">
    	<p>&nbsp;</p>
      	<p>&nbsp;</p>
        <?php echo $errorMessage; ?>
      
		<div class="row">
          <div class="col-md-12">
          	<!--<h5 align="center"><a href="profile.php">&laquo; Go back</a>-->
          </div>
        </div>
      <div class="row">
        <div class="col-md-12">
          	<h1>Edit Profile</h1>
        </div>
      </div>  
      <div class="row">
 			<div class="col-md-6">
				<form action="editprofile.php" method="post" enctype="multipart/form-data" role="form">
					<div class="form-group">
						<label for="name">Username</label>
						<input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" value="<?php echo $username; ?>">
					</div>
					<div class="form-group">
                    	<div class="row">
                        	<div class="col-sm-6">
                    			<div class="form-group">
                					<label for="city">City</label>
  									<input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo $city; ?>">
 								</div>
                    		</div>  
                            <div class="col-sm-3">
                            	<div class="form-group">
  									<label for="state">State</label>
									<input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo $state; ?>" maxlength="2">
 								</div>
                            </div>
                            <div class="col-sm-3">
                            	<div class="form-group">
									<label for="zip">Zip Code</label>
									<input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="<?php echo $zip; ?>" maxlength="5">
								</div>
                            </div>
                        </div>
					</div>
					<div class="form-group">
						<label for="file">Profile Picture</label>
						<input type="file" name="file" id="file">
						<span class="help-block">Submit only .gif, .jgp,  .jpeg, or .png <br/>Maximum 200 KB.</span>
					</div>
                    <?php echo $button; ?>
					<!--<button type="submit" class="btn btn-default">Submit</button>-->
				</form>
			</div>
			<div class="col-md-6">
				<table align="center">
					<tr>
						<td>
                        	<!-- May switch to a generic photo rather then a users photo-->
  							<img class="img-circle" src="images/editprofileLogo-03.png" width="300" height="300" alt="Edit Profile Logo">
  						</td>
    				</tr> 
				</table>
			</div>
		</div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
      </div><!-- /end of contianer -->

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