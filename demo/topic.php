<!-- DONE: 4/10/14 -->
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

    <title>Circle | Topic</title>
    
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
        
        <div class="row">
      		<div class="col-md-12">
         		<h1>Topic</h1>
        	</div>
      	</div>

		<?php

  			$totaltopics = 0;
  			$sql = 'select count(topicid) from topic';
  			$result = mysqli_query($con,$sql);
  			while($row = mysqli_fetch_array($result)) { $totaltopics = $row["count(topicid)"]; }
  			//echo 'Total Topics = ' . $totaltopics . '<br>';

  			if ($totaltopics > 0) {

    			$topicarray = array();
    			$sql = 'select topicid from topic';
    			$result = mysqli_query($con,$sql);
    			
				while($row = mysqli_fetch_array($result)) { array_push($topicarray,$row["topicid"]); }
    			$maxtopics = count($topicarray);  
    			$randomorder = array();
    			$index = 0;
    			while ($index < $maxtopics) {
      				$rand = rand(0,($maxtopics-1));
      				
					if (in_array($topicarray[$rand],$randomorder) == FALSE) {
        				$index += 1;
        				array_push($randomorder,$topicarray[$rand]);
      				}
    			} // end while loop to generate random order

    			echo '<div class="row">';
    			echo '<div class="col-md-12" style="padding-bottom:20px;"><h3>Explore</h3></div>';
    			echo '</div>';
    			echo '<div class="row">';
    			echo '<div class="col-md-12">';
    
				$maxdisplay = 0;
    			
				if ($totaltopics > 5) {
      				$maxdisplay = 5;
    			} else {
      				$maxdisplay = $totaltopics;
    			}
    			
				$index = 0;
    			while ($index < $maxdisplay) {
      				$sql = 'select * from topic where topicid=' . $randomorder[$index];
      				$result = mysqli_query($con,$sql);
      				$index += 1;
      				$topicownerid = 0;
      				$topicownername = '';
      				while($row = mysqli_fetch_array($result)) {
        				$topicownerid = $row["ownerid"];
        				$topicavatarpath = '';
        				$sql2 = 'select username,avatarpath from member where memberid=' . $topicownerid;
        				$result2 = mysqli_query($con,$sql2);
        				
						while($row2 = mysqli_fetch_array($result2)) { 
          					$topicownername = $row2["username"]; 
          					$topicavatarpath = $row2["avatarpath"];
        				}
        				
        				echo '<div class="row">';
        					echo '<div class="col-md-3" style="padding-top:50px">';
							echo '</div>';
							echo '<div class="col-md-6">';
        						echo '<div class="media">';
        							echo '<a class="pull-left" href="viewtopic.php?id=' . $row["topicid"] . '">';
        								echo '<img class="img-circle" img src="' . $topicavatarpath . '" width="64" height="64" alt="' . $topicownername . '">';
        							echo '</a>';
        							echo '<div class="media-body">';
        							        echo '<h4 class="media-heading"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a></h4>';	
        								echo '<p>Created: ' . $row["created"] . ' by <em>' . $topicownername . '</em></p><br>';
        							echo '</div>';
        						echo '</div>'; 
								echo '<hr/>';     
        					echo '</div>';
        				echo '</div>';
        				//echo '</div>';
      				} // end for loop to individual topic
    			} // end while loop to dispay top topics
    			
				echo '</div>';
    			echo '</div>';
    			echo '<hr class="featurette-divider" id="topTopic">';

    			echo '<div class="row">';
    				echo '<div class="col-md-12">';
    					echo '<h3 style="padding-bottom:20px;">Top Topics</h3>';
    				echo '</div>';
    			echo '</div>';

    			$sql = 'select topicid from topic';
    			$result = mysqli_query($con,$sql);
    			
				while($row = mysqli_fetch_array($result)) { 
      				$sql2 = 'select count(contentid) from content where topicid=' . $row["topicid"];
      				$result2 = mysqli_query($con,$sql2);
      				while($row2 = mysqli_fetch_array($result2)) { $data[] = array("topic" => $row["topicid"], "content" => $row2["count(contentid)"]); }
    			}

    			foreach ($data as $key => $row) {
      				$topic[$key] = $row['topic'];
      				$content[$key] = $row['content'];
    			}

    			array_multisort($content,SORT_DESC,$data);

    			$toptopics = array();

    			foreach ($data as $row) {
      				array_push($toptopics,$row['topic']);
    			}

    			echo '<div class="row">';
				echo '<div class="col-md-3">';
				echo '</div>';
    			echo '<div class="col-md-6">';
    			echo '<table width="100%">';

    			$index = 0;
    			
				while ($index < $maxdisplay) {
      				$sql = 'select * from topic where topicid=' . $toptopics[$index];
      				$result = mysqli_query($con,$sql);
      				$index += 1;
      				
					while($row = mysqli_fetch_array($result)) {
        				$topicownerid = $row["ownerid"];
        				$topicownervatarpath = '';
        				$sql2 = 'select username,avatarpath from member where memberid=' . $topicownerid;
        				$result2 = mysqli_query($con,$sql2);
        				
						while($row2 = mysqli_fetch_array($result2)) { 
          					$topicownername = $row2["username"]; 
          					$topicowneravatarpath = $row2["avatarpath"];
        				}
        		
					echo '<tr>';
        				echo '<td valign="top"><h4>' . $index . '.</h4></td>';
        				echo '<td>';
        					echo '<div class="row">';
        						echo '<div class="col-md-12">';
        							echo '<div class="media">';
       		 							echo '<a class="pull-left" href="viewtopic.php?id=' . $row["topicid"] . '">';
       	 									echo '<img class="img-circle" img src="' . $topicowneravatarpath . '" width="64" height="64" alt="' . $row["name"] . '">';
        								echo '</a>';
        								echo '<div class="media-body">';
        								        echo '<h4 class="media-heading"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a></h4>';	
        									echo '<p>Created:' . $row["created"] . ' by ' . $topicownername . '</p><br>';
        								echo '</div>';
        							echo '</div>';     
        						echo '</div>';
        			echo '</div>';
					echo '<hr/>';
        			echo '</td>';
        			echo '</tr>';
					
      			} // end for loop to display individual top topic
    		} // end while loop to display top topics
			echo '</table>';
    		echo '</div>';
    		echo '</div><!-- /END THE FEATURETTES -->';
		} // end if $totaltopics > 0
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
