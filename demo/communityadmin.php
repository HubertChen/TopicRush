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

  $communityid = $_GET["id"];
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

	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  

  	$memberid = 0;
  	$communityid = $_GET["id"];
  	$communityname  = '';
  	$ownerid = 0;
  	$ownername = '';
  	$created = '';
  	$nummembers = 0;
  	$numtopics = 0;
  	$numcontent = 0;
  	$rating = 0;
  	$communityimage = '';
  	$loggedin = FALSE;
  	$alreadyjoined = FALSE;
  	$isowner = FALSE;


  	$sql = 'select * from community where communityid=' . $communityid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) {
    	$communityname = $row["name"];
    	$ownerid = $row["ownerid"];
    	$created = $row["created"];
    	$nummembers = $row["nummembers"];
    	$numtopics = $row["numtopics"];
    	$numcontent = $row["numcontents"];
    	$rating = $row["rating"];  
    	$communityimage = $row["path"];
  	} // end for loop to get community information

  	if (isset($_SESSION["loggedin"])) { 
    	$loggedin = TRUE;
    	$memberid = $_SESSION["memberid"];
    	$alreadyjoined = FALSE;
    	$memberid = $_SESSION["memberid"];
    	$sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }
    	if ($ownerid == $memberid) { $isowner = TRUE; }
  	}

  	$sql = 'select username from member where memberid=' . $ownerid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { $ownername = $row["username"]; }

  	echo '<div class="row ">';
  		echo '<div class="col-md-3">';
  			echo '<table align="center" >';
  				echo '<tr>';
  					echo '<td align="center"><img class="img-circle"  img src="' . $communityimage . '" width="150" height="150" alt="' . $communityname . '"></td>';
  				echo '</tr>';
  				echo '<tr>';
  					echo '<td align="center">';
  						echo '<em>Members: ' . $nummembers . '</em>';
  					echo '</td>';
  				echo '</tr>';
  			echo '</table>';
  		echo '</div>';
  		echo '<div class="col-md-9">';
  			echo '<table >';
  				echo '<tr>';
  					echo '<td>';
  						echo '<h1>';
  							echo $communityname;
  						echo '</h1>';
  					echo '</td>';
  				echo '</tr>';
  				echo '<tr>';
  					echo '<td>';
  						echo '<p>Created: ' . $created . ' by ' . $ownername . '</p><br>';
  					echo '</td>';
  				echo '</tr>';
  			echo '</table>';
  		echo '</div>';
	echo '</div>';
	echo '<hr/>';
	echo '<div class="row ">';
  		echo '<div class="col-md-3"></div>';
  		echo '<div class="col-md-6"><h3>Block Users</h3>';

			if (($loggedin == TRUE) && ($isowner == TRUE)) {
			  	$sql = 'select memberid from joins where communityid=' . $communityid;
			  	$result = mysqli_query($con,$sql);
			  
			  	while($row = mysqli_fetch_array($result)) {
				  	$membername = '';
				  	$memberavatar = '';
				  	$blockid = 0;
				  	$isblocked = FALSE;
				  	$blockreason = '';
					$sql2 = 'select username,avatarpath,memberid from member where memberid=' . $row["memberid"];
				  	$result2 = mysqli_query($con,$sql2);
				  
				  	while($row2 = mysqli_fetch_array($result2)) { 
						$membername = $row2["username"];
					  	$memberavatar = $row2["avatarpath"]; 
					  	$blockid = $row2["memberid"];
				  	}
			  
			  	$sql2 = 'select * from block where memberid=' . $row["memberid"] . ' and communityid=' . $communityid;
			  	$result2 = mysqli_query($con,$sql2);
			  
			  	while($row2 = mysqli_fetch_array($result2)) {
				  	$isblocked = TRUE;
				  	$blockreason = $row2["reason"];
			  	}
			  	echo '<img class="img-circle" src="' . $memberavatar . '" width="64" height="64" alt="' . $membername . '">';
			  	echo '&nbsp;' . $membername;
			  	if ($blockid != $memberid) {
					if ($isblocked == TRUE) {
						echo '<div class="form-group">'; 
							echo '<label for="Reason">Reason</label><br/>'; 		
							echo  $blockreason . '<br>';
						echo '</div>';
						echo '<a href="unblock.php?member=' . $row["memberid"] . '&community=' . $communityid .'"><button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Unblock</button></a>';
					  	
			  		} else { // end if $isblocked == TRUE       
				  		echo '<form role="form" action="block.php?member=' . $row["memberid"] .'&community=' . $communityid . '" method="post">';
					  		echo '<div class="form-group">'; 
						  		echo '<label for="Reason">Reason</label>'; 
						  		echo '<input type="text" class="form-control" size="100" name="Reason" id="Reason" placeholder="Block Reason" required>'; 
					  		echo '</div>';
							echo ' <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Block</button>';
				  		echo '</form>';
			  		} // end if-else $isblocked == TRUE
		  		} else { // end if $blockid != $memberid
		  
		  		echo ' Community Administrator!<br/>';
			}	 	
			echo '<hr/>';
			echo '<br>';
		} // end while loop to go through community members
	} else {
  		echo 'You do not have permission to block a member of this community!<br/>';
  	}
	
	echo '</div>';
	echo '</div>';
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
