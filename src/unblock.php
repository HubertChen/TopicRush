<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">


<?php 
	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
  $dbname = "Circle";
  
  //Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';	
  	} 

  $communityid = $_GET["community"];
  $communityname = "";
  $sql = 'select name from community where communityid=' . $communityid;
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) { $communityname = $row["name"]; }


  echo '<title>Circle | ' . $communityname . ' </title>'; 

  mysqli_close($con);

?>


<?php               
  //navbar: user is logged in           
  	if (isset($_SESSION["loggedin"])) {
    	$navbar = '<a href="signout.php"><button type="button" class="btn btn-signin navbar-btn-right btn-sm" >Sign Out</button></a>
					<div class="navbar-right">
						<a href="profile.php">
							<img src="'. $_SESSION["avatarpath"] . '" alt="User Profile Image" width="35" height="35" class="img-circle">
						</a>
						<a href="profile.php">' . $_SESSION["username"] . '</a>
					</div>';
	
	} else { // end if user is logged in
    	$navbar ='<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
					<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
  	} // end if-else user is logged in

?>

    
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

<?php

  	if (isset($_SESSION["loggedin"])) {
 
	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
    	$dbname = "Circle";
    	$communityid = $_GET["community"];
    	$memberid = $_GET["member"];
    	$validcommunity = FALSE;
    	$validmember = FALSE;

    	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 
    	$sql = 'select name from community where communityid=' . $communityid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $validcommunity = TRUE; }

    	$sql = 'select username from member where memberid=' . $memberid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $validmember = TRUE; }

    	if (($validcommunity == TRUE) && ($validmember == TRUE)) {
      		$blockname = '';
      		$blockavatar = '';

      		$sql = 'select path from community where communityid=' . $communityid;
      		$result = mysqli_query($con,$sql);
      		while($row = mysqli_fetch_array($result)) {  $communitylogo = $row["path"]; }  

      		$sql = 'select username,avatarpath from member where memberid=' . $memberid;
      		$result = mysqli_query($con,$sql);
      		while($row = mysqli_fetch_array($result)) {
        	$blockname = $row["username"];
        	$blockavatar = $row["avatarpath"];
      	}

     	 echo '<div class="row">';
      		echo '<div class="col-md-3">';
      			echo '<table align="center">';
      				echo '<tr>';
      					echo '<td align="center">';
      						echo '<a href="viewcommunity.php?id=' . $communityid . '"><img class="img-circle"  img src="' . $communitylogo . '" height="150" width="150" alt="Generic placeholder image"></a>';
      					echo '</td>';
      				echo '</tr>';
      			echo '</table>';
      		echo '</div>';
			echo '<div class="col-md-9">';
		echo '<div class="alert alert-success alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
						$blockname . ' is now unblocked from this community!<br> 
						</strong></div>';		
		echo '</div>';
      	echo '</div>';
      		
		$sql = 'delete from block where memberid=' . $memberid . ' and communityid=' . $communityid;
      	mysqli_query($con,$sql);


    	} else { // end if $validcommunity == TRUE
      		echo 'Invalid Community or Member specified!<br';
    	} // end if-else $validcommunity == TRUE

    	mysqli_close($con);

  		} else { // end if user is logged in
    	echo 'You have navigated to this page in error, you must be logged in to use this page!<br>';
  }

?>
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
