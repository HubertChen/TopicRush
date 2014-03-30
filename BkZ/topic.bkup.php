<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle | Topic</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  
  
<!-- NAVBAR
Known bugs: 	
	-in Collapse it displays a line through the buttons
	-Readjusting back to full view the buttons don't display properly

================================================== -->
  <body>
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
          <a class="navbar-brand" href="index.html">
          	<img src="images/logo03.png" alt="Circle" width="47" height="47" vspace="2">&nbsp;
         	 <img src="images/logotext.png" alt="Circle" width="94" height="28">
          </a>
        </div>
		<!--Navbar that goes inside collapssed navbar-->
        <div class="navbar-collapse collapse" align="center">  
          <form class="navbar-form navbar-form-length"  role="search" >
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Seach for communities, topics, and products" size="70" maxlength="70">
            </div>
            	
                <!--USER IS LOGGED IN-->
                <div class="navbar-right">
                	<a href="profile.html">
                    	
                        <!--If the user doesn't have a picture it will show this generic photo-->
                  		<img src="images/userDefault.png" alt="Generic placeholder image" width="35" height="35" class="img-circle">
                  	</a>
				  	<a href="profile.html">[User Name]</a>
                    <a href="signout.php"><button type="button" class="btn btn-signin navbar-btn-right btn-sm">Sign Out</button></a>

                </div>
                    
                <!--USER IS NOT LOGGED IN-->    
            	<!--<a href="signin.html"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
            	<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>-->
          </form>  
        </div>
      </div>
    </div>

    
    
    
    <!-- Look at grid layouts on Bootstrap: http://getbootstrap.com/css/#grid -->
    <div class="container">
    	<p>&nbsp;</p>
      	<p>&nbsp;</p>
      
		<div class="row">
          			<div class="col-md-12">
                    	<table align="center">
                        	<tr>
                        		<td>
                                    <div>
                                        <ul class="nav masthead-nav">
                                            <li><a href="community.html">Community</a></li>
                                            <li><a href="topic.html">Topic</a></li>
                                            <li><a href="product.html">Product</a></li>
                                        </ul>
                                    </div>
                        		</td>
                        	</tr>
                        </table>
        			</div>
        		</div>
      <div class="row">
        <div class="col-md-6">
          	<h1>Topic</h1>
        </div>
        <div class="col-md-6" align="right">
        	<a href="addtopic.html"><button type="button" class="btn btn-primary btn-lg">Add Topic</button></a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"><h3>Explore</h3></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
            </div>
            <div class="col-md-6">
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
                &nbsp;
                <div class="row">
                	<div class="col-md-12">
            			<div class="media">
                  			<a class="pull-left" href="viewtopic.html">
                    			<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  			</a>
                  			<div class="media-body">
                  				<h4 class="media-heading">[Topic Name]</h4>
                    				[Topic Decription from the user]
                  			</div>
                		</div>         
            		</div>
        		</div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <hr class="featurette-divider" id="topTopic">
          <h3 >Top</h3>
          </div>
        </div>
        &nbsp;
		<div class="row">
        	<div class="col-md-6">
            	<table>
                	<tr>
                    	<td valign="top"><h4>1.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                    	<td valign="top"><h4>2.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                    	<td valign="top"><h4>3.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
            	<table>
                	<tr>
                    	<td valign="top"><h4>4.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                    	<td valign="top"><h4>5.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                    	<td valign="top"><h4>6.</h4></td>
                    	<td>
                        	<div class="row">
                				<div class="col-md-12">
            						<div class="media">
                  						<a class="pull-left" href="viewtopic.html">
                    						<img class="img-circle" data-src="holder.js/100x100" alt="Generic placeholder image">
                  						</a>
                  						<div class="media-body">
                  							<h4 class="media-heading">[Topic Name]</h4>
                    						[Topic Decription from the user.  The quick brown fox jumped over the lazy dog the quick brown fox jumped over the lazy sog]
                  						</div>
                					</div>         
            					</div>
        					</div>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </div>
          </div><!-- /END THE FEATURETTES -->


      <!-- Footer
          Need to do:
    		-Add color to the bottom
            -May want to add bread crumb for navigation purposes
    ================================================== -->
      <!--<ol class="breadcrumb">
      	<li><a href="index.html">Home</a></li>
      </ol>-->
      <hr class="featurette-divider">
      <footer>
        <p class="pull-right"><a href="#top">Back to top</a></p>
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