<!-- DONE: 4/9/14 -->
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

    <title>Circle | About</title>
    
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
    
    <!-- Add Product Section-->
  	<div class="container" style="background-color:rgb(255, 255, 255)">
   		<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php if(isset($errorMessage)) { echo $errorMessage; } ?>

        <div class="row">
        	<div class="col-md-12">
            	<table align="center">
                	<tr>
                    	<td>
                        	<div>
                            	<ul class="nav masthead-nav">
                                	<li><a href="community.php">Community</a></li>
                                    <li><a href="topic.php">Topic</a></li>
                                    <li><a href="product.php">Product</a></li>
                                </ul>
                           	</div>
                  		</td>
               		</tr>
           		</table>
			</div> 
        </div>
      	<div class="row">
        	<div class="col-md-12">
          		<h1>About</h1>
        	</div>
      	</div> 
        <div class="row">
        	<div class="col-md-12">
				<p>Circle is a social networking site that merges users, communities, and products all into your own personal 'Circle'. Unlike other sites where it is more producer-focused and in-your-face; Circle is more of a consumer-focused network where consumers and potential-consumers can communicate about products they're interested in, love to use, or hate to use.</p>
            </div>
        </div>
        <br/>
        <div class="row">
        	<div class="col-md-12">                   
				<h1>History</h1>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
            	<p>Founded in the spring of 2014 by four Monmouth University students, Circle has quickly grown to tens of users. Led by Greg Kilmartin as project manager, Brian K. Zerfass, Cyrus Siganporia, and Michael Branco; we all put our blood, sweat, and tears to make a one-of-a-kind expereince, that we have dubbed, Circle. Circle was developed with guidance from Dr. Yu, a professor at Monmouth University, during the Spring 2014 semester.</p>
           	</div>
        </div>
        <br/>
        <div class="row">
                <div class="col-md-12">
                                <h1>Usage</h1>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                <p>Circle is a very easy to use, intuitive web site. However, this section provides a breif overview on how to use the website. Anyone can view the Communities, Topics and Products on the website. Only registered users can create content, such as a Community or Topic. Only users registered as Sellers can add Products to the website. Once a Community is created, users can then join the Community in order to create a Topic, once joined users may also add Content into existing conversations. Users can Follow Topics and when new content is added, the user's profile page will show which followed Topics have new content. The user who created the Community is classified as the Administrator of that Community. A Community Administrator can block and unblock users who have joined the Community, should they be posting inappropriate material or being disruptive. Once registered users can review any Product on the website, except products they have posted (this prevents product owners from always rating their products the highest). Users may only review a product once.<br> Users may modify their own profile, adding avatars, adding some basic profile information such as home state, city and zipcode. The user's homepage is the best place to quickly find the Communities they have joined, see the Topics they are following and if they are registered as a Seller, see the Products they have posted. The website restricts the sizes of images to be 200kbytes or less and only allows .gif, .jpg, .jpeg and .png image types. The website implements filtering in an attempt to prevent inappropriate material from being displayed, however, creative users may find a way around any filtering no matter how sophisticated.</p>
                </div>
        </div>
        <br/>




        <br/>
     	<br/>
        <br/>
        <br/>
     	<br/>
        <br/>
        <br/>
     	<br/>
        <br/>
	</div>    

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
