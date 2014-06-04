
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">
    
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
              <input type="text" name="search" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70" required>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
			<?php echo $navbar; ?>

          </form>  
        </div>
      </div>
    </div>

    <div class="container" style="background-color:rgb(255, 255, 255)">
   		<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php if (isset($errorMessage)) { echo $errorMessage; } ?>

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
        
      	<div class="row ">
      		<div class="col-md-3">
      			<table align="center" >
      				<tr>
      					<td align="center"><img class="img-circle"  img src="<?php echo $imagepath; ?>" width="150"  height="150" alt="<?php echo $productname; ?>"></td>
     				</tr>
      				<tr>
      					<td align="center">
      						<?php 
								$stars = 0;
      							$rating = round($rating,1);
      							while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
       			 					echo '<span class="glyphicon glyphicon-star"></span>';
        							$stars += 1;
      							}
      							echo '(' . $rating . ')';
	  						?>
      					</td>
      				</tr>
      				<tr>
      					<td align="center"><h6>$<?php echo $listedprice; ?></h6></td>
      				</tr>
      			</table>
      		</div>
      		<div class="col-md-9">
      			<table >
      				<tr>
      					<td><h1><?php echo $productname; ?></h1></td>
      				</tr>
      				<tr>
      					<td><h4><em>Owner: <?php echo $ownername; ?></em></h4></td>
      				</tr>
      				<tr>
      					<td><h6>Category: <?php echo $categoryname; ?></h6></td>
      				</tr>
      				<tr>
      					<td><p>Description: <?php echo $description; ?></p></td>
      				</tr>
      			</table>
      		</div>
      	</div>
        <hr class="featurette-divider">
        
        <div class="row ">
      		<div class="col-md-12">
        		<h4>Write Review</h4>
        	</div>
        </div>
        
        	<div class="row ">
        		<div class="col-md-1">
                <form action="reviewproduct.php?id=<?php echo $productid; ?>" method="post" role="form">
        			<div class="form-group">
        				<label for="rating">Rating</label>
        					<select class="form-control" name="rating" id="rating">
        						<option value="0">0</option>
        						<option value="1">1</option>
        						<option value="2">2</option>
        						<option value="3">3</option>
        						<option value="4">4</option>
        						<option value="5">5</option>
        				</select>
        			</div>
        		</div>
        		<div class="col-md-7">
        			<div class="form-group">
        				<label for="ratedescript">Description</label>
        				<textarea class="form-control" rows="3" name="ratedescript" id="ratedescript" placeholder="Descriptions" required></textarea>
        			</div>
        		</div>
        		<div class="row ">
        			<div class="col-md-8">
        				<?php echo $button; ?>
        			</div>
        		</div>
        	</form>    
        </div>
            
            
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
