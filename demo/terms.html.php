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

    <title>Circle | Terms & Conditions</title>
    
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
          		<h1>Terms & Conditions</h1>
        	</div>
      	</div>
        <h4>1. Terms</h4>
        <p>
         	By accessing this web site, you are agreeing to be bound by these 
            web site Terms and Conditions of Use, all applicable laws and regulations, 
            and agree that you are responsible for compliance with any applicable local 
            laws. If you do not agree with any of these terms, you are prohibited from 
            using or accessing this site. The materials contained in this web site are 
            protected by applicable copyright and trade mark law.
        </p>

		<h4>2. Use License</h4>
        <ol type="a">
            <li>
                Permission is granted to temporarily download one copy of the materials 
                (information or software) on Circle's web site for personal, 
                non-commercial transitory viewing only. This is the grant of a license, 
                not a transfer of title, and under this license you may not:
                
                <ol type="i">
                    <li>modify or copy the materials;</li>
                    <li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
                    <li>attempt to decompile or reverse engineer any software contained on Circle's web site;</li>
                    <li>remove any copyright or other proprietary notations from the materials; or</li>
                    <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                </ol>
            </li>
            <li>
                This license shall automatically terminate if you violate any of these restrictions and may be terminated by Circle at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.
            </li>
        </ol>
		<h4>3. Disclaimer</h4>
		<ol type="a">
			<li>
		The materials on Circle's web site are provided "as is". Circle makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, Circle does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.
			</li>
		</ol>
		<h4>4. Limitations</h4>

        <p>
            In no event shall Circle or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on Circle's Internet site, even if Circle or a Circle authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.
        </p>
			
		<h4>5. Revisions and Errata</h4>

        <p>
            The materials appearing on Circle's web site could include technical, typographical, or photographic errors. Circle does not warrant that any of the materials on its web site are accurate, complete, or current. Circle may make changes to the materials contained on its web site at any time without notice. Circle does not, however, make any commitment to update the materials.
        </p>

		<h4>6. Links</h4>

        <p>
            Circle has not reviewed all of the sites linked to its Internet web site and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Circle of the site. Use of any such linked web site is at the user's own risk.
        </p>

		<h4>7. Site Terms of Use Modifications</h4>

        <p>
            Circle may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use.
        </p>

		<h4>8. Governing Law</h4>

        <p>
            Any claim relating to Circle's web site shall be governed by the laws of the State of New Jersey without regard to its conflict of law provisions.
        </p>

        <p>
            General Terms and Conditions applicable to Use of a Web Site.
        </p>
        <br/>
        <br/>
        <br/>
	</div><!--/end of container -->


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