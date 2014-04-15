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

    <title>Circle | Add Product</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  <!-- NAVBAR
  ================================================== -->
  <body class="obj-background4">
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
          		<form class="navbar-form navbar-form-length"  role="search" action="search.php" method="post">
            		<div class="form-group">
              			<input type="text" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70">
            		</div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            		<?php echo $navbar; ?>
  				</form>
  			</div>
  		</div>
  	</div>

    
    
    <!-- CIRCLE DESCRIPTION FEATURETTE
	================================================== -->
	<!-- Circle -->
    <div class="row obj-background1">-->
    	<div class="col-md-12">	
      		<div class="container">
      			<p>&nbsp;</p>
      			<p>&nbsp;</p>
                
                <!-- Page Navbar -->
				<div class="row">
          			<div class="col-md-12">
                    	<table align="center">
                        	<tr>
                        		<td>
                                    <div>
                                        <ul class="nav masthead-obj">
                                            <li><a href="#obj-community">Community</a></li>
                                            <li><a href="#obj-topic">Topic</a></li>
                                            <li><a href="#obj-product">Product</a></li>
                                        </ul>
                                    </div>
                        		</td>
                        	</tr>
                        </table>
        			</div>
        		</div>
        		<hr class="featurette-divider">
        		<div class="row featurette">
        			<div class="col-md-7">
          				<h2 class="featurette-heading">circle. <span class="text-muted">Bringing people and ideas together.</span></h2>
          				<p class="lead">Circle encompasses what is missing on the web – a place for people to share their thoughts about products ideas, and inspirations.  Circle is to products of what Yelp is to restaurants.  Circle fills the void of Amazon by bringing social networking to a missed market.  Circle brings together communities, topics, and products together to produce a perfect circle between companies and customers.</p>
        			</div>
        			<div class="col-md-5">
                 		<img class="featurette-image img-circle img-responsive" src="images/logoWhiteBig.png" height="350" width="350" align="Circle Logo">
        			</div>
      			</div>
      		</div>
		</div>
	</div>
    
    <!-- Community -->
	<div class="row obj-background2"  id="obj-community">
    	<div class="col-md-12">	
      		<div class="container">
        		<hr class="featurette-divider">
        		<div class="row featurette">
        			<div class="col-md-5">
                        <img class="featurette-image img-circle img-responsive" src="images/communityLogo-001.png" height="500" width="500" alt="Topic Logo">
        			</div>
        			<div class="col-md-7">
          				<h2 class="featurette-heading">community.<span class="text-muted">Be apart of something.</span></h2>
          				<p class="lead">Community provides a place for people to come together to talk and interact with common topics and products.  Anyone can create a community and share what they want, with complete control.  Be apart of community or join a community.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <!-- Topic -->
    <div class="row obj-background3" id="obj-topic">
    	<div class="col-md-12">	
      		<div class="container">
        		<hr class="featurette-divider">
        		<div class="row featurette">
        			<div class="col-md-7">
          				<h2 class="featurette-heading">topic. <span class="text-muted">Share a thought.</span></h2>
          				<p class="lead">Topics is a forum type section of circle where anyone can post thoughts, concerns, and questions to people allowing other people to provide pictures, insight, and answers.</p>
        			</div>
        			<div class="col-md-5">
                 		<img class="featurette-image img-circle img-responsive" src="images/topicLogo-00.png" height="500" width="500" alt="Topic Logo">
        			</div>
      			</div>
      		</div>
		</div>
	</div>
    
    <!-- Product -->
	<div class="row obj-background4" id="obj-product">
    	<div class="col-md-12">	
      		<div class="container">
        		<hr class="featurette-divider">
        		<div class="row featurette">
        			<div class="col-md-5">
                 		<img class="featurette-image img-circle img-responsive" src="images/productLogo-00.png" height="500" width="500" alt="Product Logo">
        			</div>
        			<div class="col-md-7">
          				<h2 class="featurette-heading">product. <span class="text-muted">Voice an opinion.</span></h2>
          				<p class="lead">Products provide a place for companies to promote their products and descript the importance of their products.  Users can also review products to descript and rate how great the product is or the poor experience they have had with the product.</p>
					</div>
				</div>
			</div>
		</div>
    </div><!-- /END THE FEATURETTES -->
	<br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    
    

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