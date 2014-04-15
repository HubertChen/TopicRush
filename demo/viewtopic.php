<!-- DONE: 4/12/14 -->
<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
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

  	$topicid = $_GET["id"];
 	$topicname = '';
  	$sql = 'select name from topic where topicid=' . $topicid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { $topicname = $row["name"]; }

  	echo '<title>Circle | ' . $topicname . '</title>';

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

	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
  	$dbname = "Circle";

  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  

  
  	$topicid = $_GET["id"];
  	$communityid = 0;
  	$memberid = 0;
  	$numposts = 0;
  	$communitylogo = '';
  	$topicownerid = 0;
  	$topicownername = '';
  	$topicname = '';
  	$topiccreated = '';
  	$topicproduct = 0;
  	$topiccommunityid = 0;
  	$topicavatarpath = '';

  	$loggedin = FALSE;
  	$communitymember = FALSE;
  	$memberjoined = FALSE;
  	$memberfollows = FALSE;
  	if (isset($_SESSION["loggedin"])) { 
    	$loggedin = TRUE;
    	$memberid = $_SESSION["memberid"];
  	}
  	
	$sql = 'select communityid from topic where topicid=' . $topicid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { $communityid = $row["communityid"]; }
  	if ($loggedin == TRUE) {
    	$sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $memberjoined = TRUE; }    
    	$sql = 'select * from follows where memberid=' . $memberid . ' and topicid=' . $topicid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $memberfollows = TRUE; }
  	}

  	$sql = 'select path from community where communityid=' . $communityid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) {  $communitylogo = $row["path"]; }

  	$sql = 'select count(topicid) from content where topicid=' . $topicid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { $numposts = $row["count(topicid)"]; }

  	$sql = 'select * from topic where topicid=' . $topicid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { 
    	$topicownerid = $row["ownerid"]; 
    	$topicproductid = $row["productid"];
    	$topicname = $row["name"];
    	$topiccreated = $row["created"];
    	$topiccommunityid = $row["communityid"];
  	}
  	
	$communitylogo = '';
  	$sql = 'select path from community where communityid=' . $topiccommunityid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { $communitylogo = $row["path"]; }

  	$sql = 'select username,avatarpath from member where memberid=' . $topicownerid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { 
    	$topicownername = $row["username"]; 
    	$topicavatarpath = $row["avatarpath"];
  	}

  	echo '<div class="row ">';
  		echo '<div class="col-md-3">';
  			echo '<table align="center" >';
  				echo '<tr>';
  					echo '<td align="center">';
  						echo '<a href="viewcommunity.php?id=' . $topiccommunityid . '"><img class="img-circle"  img src="' . $communitylogo . '" height="150" width="150" alt="Generic placeholder image"></a>';
  					echo '</td>';
  				echo '</tr>';
  				echo '<tr>';
  					echo '<td align="center">';
  						echo $numposts . ' Responses';
  					echo '</td>';
  				echo '</tr>';
  			echo '</table>';
  		echo '</div>';
  		echo '<div class="col-md-9">';
  			echo '<table >';
  				echo '<tr>';
  					echo '<td>';
  					echo '<h1>';
  					echo $topicname . '&nbsp;&nbsp;&nbsp;';
  					if ($loggedin == TRUE) {
    					if ($memberfollows == TRUE) {
      						echo '<a href="unfollow.php?id=' . $topicid . '"><button type="button" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-remove"><strong> Unfollow</strong></span></button></a>';
    					} else {
      						echo '<a href="follow.php?id=' . $topicid . '"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"><strong> Follow</strong></span></button></a>';
    					}
  					} // end if $loggedin == TRUE
  					echo '</h1>';
  					echo '</td>';
 				echo '</tr>';
  				echo '<tr>';
  					echo '<td>';
  						echo '<p>Created: ' . $topiccreated . ' by ' . $topicownername . '</p><br>';
  					echo '</td>';
  				echo '</tr>';
  			echo '</table>';
  		echo '</div>';
	echo '</div>';
 	echo '&nbsp;';
  	echo '<div class="row ">';
  		echo '<div class="col-md-3">';
  		echo '</div>';
  		echo '<div class="col-lg-9">';
  			echo '<ul class="media-list">';
  				echo '<li class="media">';
  					echo '<div class="media-body">';
  					
					if ($memberjoined == TRUE) {
    					echo '<h4 class="media-heading">Add Comment <a href="addcontent.php?id=' . $topicid . '"> <button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> Create Post</button></a></h4>';
  					}

  					$numtopiccontent = 0;
 			 		$sql = 'select count(contentid) from content where topicid=' . $topicid;
  					$result = mysqli_query($con,$sql);
  					while($row = mysqli_fetch_array($result)) { $numtopiccontent = $row["count(contentid)"]; }

  					if ($numtopiccontent > 0) {
    					$sql = 'select * from content where topicid=' . $topicid;
    					$result = mysqli_query($con,$sql);
    					echo '<br>';
    				
					while($row = mysqli_fetch_array($result)) {
      					$contentownername = '';
      					$contentowneravatarpath = '';
     				 	$sql2 = 'select username,avatarpath from member where memberid=' . $row["ownerid"];
      					$result2 = mysqli_query($con,$sql2);
      					while($row2 = mysqli_fetch_array($result2)) { 
        					$contentownername = $row2["username"]; 
        					$contentowneravatarpath = $row2["avatarpath"];
      					}
      					echo '<hr/>';
						echo '<img class="img-circle" img src="' . $contentowneravatarpath . '" width="64" height="64" alt="' . $contentownername . '">';
      					echo ' ' . $row["message"] . ' ';
      					if (is_numeric($row['productid'])) { 
        					$sql3 = 'select name from product where productid=' . $row["productid"];
        					$result3 = mysqli_query($con,$sql3);
        					while($row3 = mysqli_fetch_array($result3)) {
          						echo '<a href="viewproduct.php?id=' . $row["productid"] . '">' . $row3["name"] . '</a>';
        					} // end foreach loop to build product link
      					} // end if productid is numeric for content
      echo '<div class="created-size" style="padding-left:75px">Added: ' . $row["created"] . ' by ' . $contentownername;
	  
      		if ($loggedin == TRUE) {
        			if ($row["created"] > $_SESSION["lastlogin"]) { echo '&nbsp;<span class="glyphicon glyphicon-asterisk" style="color:red"></span>&nbsp;<font color="red"><strong>New Post</strong></font>'; }
      		}
			echo '</div>';
	 
      if ($row["type"] == 1) { 
         echo '<br/>';
		echo '<div style="padding-left:75px">';
		echo '<img class="img-circle" img src="' . $row["path"] . '" width="100" height="100" alt="Post Picture">';
        echo '&nbsp;' .$row["description"] . '<br>';
		echo '</div>';
      }
    } // end for loop to print content
  } // end if $numtopiccontent > 0
	
 echo '<hr/>';	
  echo '</div>';
  echo '</li>';
  echo '</ul>';
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