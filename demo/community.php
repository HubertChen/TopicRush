<!--DONE: 4/10/14 -->
<?php session_start(); ?>

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

?>




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

    <title>Circle | Community</title>
    
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
				$addCommunity = '<a href="addcommunity.php"><button type="button" class="btn btn-primary btn-lg pull-right">Add Community</button></a>';
			} // end if user is logged in
  		?>      	
         
        
        <div class="row">
      		<div class="col-md-12">
         		<h1>Community <?php if (isset($addCommunity)) { echo $addCommunity; } ?></h1>
        	</div>
      	</div>

		<?php
  			$totalcommunities = 0;
  			$sql = 'select count(communityid) from community';
  			$result = mysqli_query($con,$sql);
  			while($row = mysqli_fetch_array($result)) { $totalcommunities = $row["count(communityid)"]; }

  			if ($totalcommunities > 0) {

    		$communityarray = array();
    		$sql = 'select communityid from community';
    		$result = mysqli_query($con,$sql);
    		while($row = mysqli_fetch_array($result)) { array_push($communityarray,$row["communityid"]); }

    		$maxcommunity = count($communityarray);  

    		$randomorder = array();
    		$index = 0;
    		while ($index < $maxcommunity) {
      			$rand = rand(0,($maxcommunity-1));
      			if (in_array($communityarray[$rand],$randomorder) == FALSE) {
        			$index += 1;
        			array_push($randomorder,$communityarray[$rand]);
      			}
    		} // end while loop to generate random order



    		echo '<div class="row">';
    		echo '<div class="col-md-12"><h3>Explore</h3></div>';
			echo '</div>';
			echo '<div class="row">';
    		
			$communityowners = array();
    		$index = 0;
    		while ($index < $maxcommunity) {
      		$sql = 'select * from community where communityid=' . $randomorder[$index];
      		$result = mysqli_query($con,$sql);
      		$index += 1;
      		while($row = mysqli_fetch_array($result)) {
        		//echo '</div>';
        		echo '<div class="col-md-3">';
        		echo '<table align="center">';
        		echo '<tr>';
        		echo '<td align="center">';
        		echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="' . $row["name"] . '"></a>';
        		echo '</td>';
        		echo '</tr>';
        		echo '<tr>';
        		echo '<td align="center">';
        		echo $row["name"];
        		echo '</td>';
        		echo '</tr>';
        		echo '</table>';
				echo '</div>';
      		} // end for loop to display communities
    	} // end while loop to print community randomly

    	echo '</div>';
    	echo '<hr class="featurette-divider" id="topCommunity">';

    	echo '<div class="row">';
    		echo '<div class="col-md-12">';
    			echo '<h3 >Top</h3>';
    		echo '</div>';
    	echo '</div>';
    	echo '<div class="row">';

    	$count = 0;
    	$sql = 'select * from community order by rating desc';
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) {        
      		$count += 1;

     	 	echo '<div class="col-md-3">';
      		echo '<table align="center">';
      		echo '<tr>';
      		echo '<td rowspan="3" valign="top"><h4>' . $count . '.</h4></td>';
      		echo '<td align="center"><a href="viewcommunity.php?id= ' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="' . $row["name"] . '"></a></td>';
      		echo '</tr>';
      		echo '<tr>';
      		echo '<td align="center">';
      		echo $row["name"];
      		echo '</td>';
      		echo '</tr>';
      		echo '<tr>';
      		echo '<td align="center"> (' . $row["rating"] . ')</td>';// M=' . $row["nummembers"] . ',T=' . $row["numtopics"] . ',C=' . $row["numcontents"] . '.</td>';
      		echo '</tr>';
      		echo '</table>';
      		echo '</div>';

    } // end for loop to display top communties

    	echo '</div>';

  	} else { // end if $totalcommunities > 0
    echo '<div class="alert alert-info alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There are currently no communities, please check back soon!
						</div>';
  
  } // end if-else $totalcommunities > 0

  mysqli_close($con);

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
