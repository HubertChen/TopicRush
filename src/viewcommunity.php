<!-- DONE: 4/12/14 -->
<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

                $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
                $communityid = 0;
  		if (isset($_GET["id"])) { $communityid = $_GET["id"]; }
  		$communityname = "";

  		$sql = 'select name from community where communityid=' . $communityid;

  		$result = mysqli_query($con,$sql);
  		while($row = mysqli_fetch_array($result)) {
    	      	  $validcommunityid = TRUE;
    	          $communityname = $row["name"]; 
  		}
  		echo '<title>Circle | ' . $communityname . ' </title>'; 

  		mysqli_close($con);
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
  	?>
    
    
    
    <!-- Look at grid layouts on Bootstrap: http://getbootstrap.com/css/#grid -->
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
  			
			$validcommunityid = FALSE;
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
  			$blocked = FALSE;
  			$blockreason = '';

  			if (isset($_SESSION["loggedin"])) { 
    			$loggedin = TRUE;
					$memberid = $_SESSION["memberid"];
					$alreadyjoined = FALSE;
					$memberid = $_SESSION["memberid"];
					$sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }
					$sql = 'select * from block where memberid=' . $memberid . ' and communityid=' . $communityid;
					$result = mysqli_query($con,$sql);
    				while($row = mysqli_fetch_array($result)) { 
      					$blocked = TRUE; 
      					$blockreason = $row["reason"];
    				}    
  			}

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
		  						echo '<h1>' . $communityname .'&nbsp;&nbsp;&nbsp;';
  				if (isset($_SESSION["loggedin"])) {
    				if ($alreadyjoined == FALSE) {
      					if ($blocked == FALSE) { echo '<a href="join.php?id=' . $communityid . '"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"> <strong>Join</strong></span></button></a>'; 
						}
    				} else { // end if $alreadyjoined == FALSE
      					echo '<a href="leave.php?id=' . $communityid . '"><button type="button" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-remove"> <strong>Leave</strong></span></button></a>';
    				}
  				} // end if user logged in
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
			echo '<div class="col-md-3">';
			echo '</div>';
  				echo '<div class="col-md-9">';
  if ($blocked == TRUE) {
    echo 'You have been blocked from this community for the following reason:<br>' . $blockreason . '<br>';
  } else { // end if $blocked == TRUE
    echo '<h3>Topics &nbsp;';
    if (isset($_SESSION["loggedin"])) {
      $alreadyjoined = FALSE;
      $memberid = $_SESSION["memberid"];
      $sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }
      if ($alreadyjoined == TRUE) {
        echo '<a href="addtopic.php?id=' . $communityid . '"> <button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Create Topic</button></a>';
      }
      if ($ownerid == $memberid) {
        echo '<a href="communityadmin.php?id=' . $communityid . '"> <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Block Users</button></a>';
      } // end if user is community owner
    } // end if user logged in

    echo '</h3>';

    if ($numtopics > 0) {
      $sql = 'select * from topic where communityid=' . $communityid;
      $result = mysqli_query($con,$sql);
      $topicowner = 0;
      $topicownername = '';
      $topicavatarpath = '';
      while($row = mysqli_fetch_array($result)) {    
        $productid = $row["productid"];
        $productname = '';

        $sql2 = 'select username,avatarpath from member where memberid=' . $row["ownerid"];
        $result2 = mysqli_query($con,$sql2);
        while($row2 = mysqli_fetch_array($result2)) { 
          $topicownername = $row2["username"]; 
          $topicavatarpath = $row2["avatarpath"];
        }
        echo '<div class="row ">';
        	echo '<div class="col-md-12">';
        		echo '<div class="media">';
        			echo '<div class="pull-left">';
        				echo '<img class="img-circle" img src="' . $topicavatarpath . '" width="64" height="64" alt="' . $topicownername . '">';
        			echo '</div>';
        			echo '<div class="media-body">';
        				echo '<h4 class="media-heading"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a>';
        				if ($alreadyjoined == TRUE) {
          					echo '<a href="addcontent.php?id=' . $row["topicid"] . '"> <button type="button" class="btn btn-primary btn-sm pull-right"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comment</button></a>';
        				} // end if alreadyjoined == TRUE to display add content button
        				echo '</h4>';
						if (is_numeric($productid)) {
          					$sql4 = 'select name from product where productid=' . $productid;
          					$result4 = mysqli_query($con,$sql4);
          					while($row4 = mysqli_fetch_array($result4)) { $productname = $row4["name"]; }
          					echo '<div style="padding-left:15px;"><a href="viewproduct.php?id=' . $productid . '">' . $productname . '</a><br/></div>';
   						} 
						echo '<div class="created-size" style="padding-left:15px">Created: ' . $row["created"] . ' by ' . $topicownername . '.</div>';
						echo '<hr>';
        				
						$numtopiccontent = 0;
        				$sql2 = 'select count(contentid) from content where topicid=' . $row["topicid"];
        				$result2 = mysqli_query($con,$sql2);
        				while($row2 = mysqli_fetch_array($result2)) { $numtopiccontent = $row2["count(contentid)"]; }
        				if ($numtopiccontent > 0) {
        					$sql2 = 'select * from content where topicid=' . $row["topicid"];
          					$result2 = mysqli_query($con,$sql2);
          	
          				while($row2 = mysqli_fetch_array($result2)) {
            				$contentownername = '';
            				$contentowneravatarpath = '';
            				$sql3 = 'select username,avatarpath from member where memberid=' . $row2["ownerid"];
            				$result3 = mysqli_query($con,$sql3);
            	
							while($row3 = mysqli_fetch_array($result3)) { 
              					$contentownername = $row3["username"]; 
              					$contentowneravatarpath = $row3["avatarpath"];
            				}
            	
							echo '<img class="img-circle" img src="' . $contentowneravatarpath . '" width="64" height="64" alt="' . $contentownername . '">';
            				//echo '<div class="media-body>';
							echo ' ' . $row2["message"] . '';
            	
				if (is_numeric($row2["productid"])) { 
              		$sql4 = 'select name from product where productid=' . $row2["productid"];
              		$result4 = mysqli_query($con,$sql4);
              		
					while($row4 = mysqli_fetch_array($result4)) {
                		echo '<a href="viewproduct.php?id=' . $row2["productid"] . '">' . $row4["name"] . '</a>';
              		} // end foreach loop to build product link
            	} // end if productid is numeric for content   
            //echo '<br>';
            echo '<div class="created-size" style="padding-left:75px">added: ' . $row2["created"] . ' by ' . $contentownername;
            if ($loggedin == TRUE) {
              if ($row2["created"] > $_SESSION["lastlogin"]) { echo '&nbsp;<span class="glyphicon glyphicon-asterisk" style="color:red"></span>&nbsp;<font color="red"><strong>New Post</strong></font>'; }
            }
			echo '</div>';
            echo '<br/>';
            if ($row2["type"] == 1) { 
			  echo '<div style="padding-left:75px">';
			  echo '<img class="img-circle" img src="' . $row2["path"] . '" width="100" height="100" alt="Post Picture">';
              echo '&nbsp;' . $row2["description"];
			  echo '</div>';
			  echo '<br/>';
            }
          } // end for loop to print content
        } else { // end if $numtopiccontent > 0

        } // end if-else $numtopiccontent > 0


        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      } // end for loop to print topics
    } else { // end if $numtopics > 0
      echo "There are currenty no topics!<br/>Join and create one!";
    }

  } // end if-else $blocked == TRUE

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
