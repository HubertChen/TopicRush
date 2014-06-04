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

    <title>Circle | Privacy</title>
    
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
          		<h1>Privacy Policy</h1>
        	</div>
      	</div>
        <hr/>
        <div class="row">
        	<div class="col-md-12">
			<h4>What information do we collect?</h4>
    		p>We collect information from you when you register on our site.  When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address or phone number. You may, however, visit our site anonymously.</p>
            <br/>    
    		<h4>What do we use your information for?</h4> 
    		<p>Any of the information we collect from you may be used in one of the following ways:</p>
    		<ul>
            	<li>To personalize your experience (your information helps us to better respond to your individual needs)</li>
            	<li>To improve our website (we continually strive to improve our website offerings based on the information and feedback we receive from you)</li>
                <li>To improve customer service (your information helps us to more effectively respond to your customer service requests and support needs)</li>
                <li>To process transactions - Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</li>
                <li>To send periodic emails.  The email address you provide may be used to send you information, respond to inquiries, and/or other requests or questions.</li>
            </ul>	
            <br/>
            <h4>How do we protect your information?</h4>
			<p>We implement a variety of security measures to maintain the safety of your personal information when you enter, submit, or access your personal information. </p>
            <br/>
	    	<h4>Do we disclose any information to outside parties?</h4> 
    		<p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>
			<br/>
    		<h4>Third party links</h4>
     		<p>Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>
            <br/>
     		<h4>California Online Privacy Protection Act Compliance</h4>
     		<p>Because we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent. As part of the California Online Privacy Protection Act, all users of our site may make any changes to their information at anytime by logging into their profile through the sign in page and going to the 'Edit Profile' page.</p>
     		<br/>
     		<h4>Childrens Online Privacy Protection Act Compliance</h4> 
     		<p>We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.</p>
     		<br/>
     		<h4>Online Privacy Policy Only</h4> 
     		<p>This online privacy policy applies only to information collected through our website and not to information collected offline.</p>
            <br/>
     		<h4>Terms and Conditions</h4> 
     		<p>Please also visit our Terms and Conditions section establishing the use, disclaimers, and limitations of liability governing the use of our website at <a href="terms.php">/terms</a></p>
     		<br/>
     		<h4>Your Consent</h4> 
     		<p>By using our site, you consent to our <a style='text-decoration:none; color:#3C3C3C;' href='http://www.freeprivacypolicy.com/' target='_blank'>online privacy policy</a>.</p>
     		<br/>
     		<h4>Changes to our Privacy Policy</h4> 
			<p>If we decide to change our privacy policy, we will post those changes on this page, send an email notifying you of any changes, and/or update the Privacy Policy modification date below.</p>
     		<br/>
     		<p>This policy was last modified on March 12, 2014</p>
            <br/>
            <br/>
            <br/>
     		<h4 align="center">Contact Us</h4> 
     		<p align="center">If there are any questions regarding this privacy policy you may contact us using the information below.</p>
            <br/>
     		<div align="center">
                <address>
                    Circle, Inc.<br/>
                    400 Cedar Ave<br/>
                    West Long Branch, New Jersey 07764<br/>
                    USA<br/>
                    info@circle.com<br/>
                </address>
            </div>
		</div>
	</div>
    </div>
    
    <!--/end of container -->

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