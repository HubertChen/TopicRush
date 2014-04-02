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
            		<?php echo $navbar; ?>
  				</form>
  			</div>
  		</div>
  	</div>
    
    <!-- Add Product Section-->
  	<div class="container" style="background-color:rgb(255, 255, 255)">
   		<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php echo $errorMessage; ?>

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
          		<h1>Add Product</h1>
        	</div>
      	</div>
        
      	<div class="row">
        	<div class="col-md-6">
          		<form action="addproduct.php" method="post" enctype="multipart/form-data" role="form">         
					<div class="form-group">
						<label for="productname">Name</label>
						<input type="text" class="form-control" name="productname" id="productname" placeholder="Enter name" value="<?php echo $productname; ?>" required>
					</div>
					<div class="form-group">
						<label for="Product Description">Product Description</label>
						<textarea class="form-control" rows="3" name="productdescription" id="prodctdescription" placeholder="Product Description" value="<?php echo $productdescription; ?>" required></textarea>
					</div>
					<div class="form-group">
                    	<div class="row">
                        	<div class="col-sm-6">
                            	<label for="listedprice">Listed Price</label>
								<input type="text" class="form-control" name="listedprice" id="listedprice" placeholder="Enter Price" value="<?php echo $listedprice; ?>" required>
                            </div>
                            <div class="col-sm-6">
                            	<label for="retailprice">Retail Price</label>
								<input type="text" class="form-control" name="retailprice" id="retailprice" placeholder="Enter Price" value="<?php echo $retailprice; ?>" required>
                            </div>
                      	</div>
						
					</div>
					<div class="form-group">
                    	<div class="row">
                        	<div class="col-sm-6">
                            	<label for="Category">Category</label>
								<select name="category" class="form-control">
								<?php 						
                                	$result = mysqli_query($con,"select categoryid,name  from category");
                                	foreach($result as $row) {
                                    	echo '<option value="'.$row['categoryid'].'"';
                                    	echo '>'. $row['name'] . '</option>'."\n";
                                	} // end for loop to print Category 
                            	?>
                                <option value="addnew">Add New</option>
								</select>
                            </div>
                            <div class="col-sm-6">
                            	<label for="retailprice">New Category</label>
								<input type="text" class="form-control" name="newcategory" id="newcategory" placeholder="Enter Category">
                            </div>
                        </div>								                  
					</div>
					<div class="form-group">
						<label for="file">Picture</label>
						<input type="file" name="file" id="file">
						<span class="help-block">Submit only .gif, .jgp,  .jpeg, or png <br/>Maximum 200 KB.</span>
					</div>
					<div class="form-group">
						<label for="retailprice">Picture Description</label>
						<textarea class="form-control" rows="3" name="picturedescription" id="picturedescription" placeholder="Picture Description" value="<?php echo $picturedescription ?>" required></textarea>
					</div>
                    <?php echo $button; ?>
				</form>
        	</div>	
            <div class="col-md-6">
          		<br/>
                <table align="center">
                    <tr>
                        <td>
                          <img class="img-circle" src="images/productLogo-03.png" height="300" width="300" alt="Product Logo">
                        </td>
                  </tr>    
              </table>
        	</div>
      	</div>
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