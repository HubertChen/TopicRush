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

	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "Circle";
  
  	//connected to database
    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
             		 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            			There seems to be a problem, please try again later!
            			</div>';
  
    	include 'viewcommunity.html.php';
    	exit(); 
    }

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

	//If user is logged in
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
  	foreach ($result as $row) {
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
  	foreach ($result as $row) { $ownername = $row["username"]; }

  //if user is logged in
  if (isset($_SESSION["loggedin"])) {
    if ($alreadyjoined == FALSE) {
      if ($blocked == FALSE) { 
	  	$btnState = '<a href="join.php?id=' . $communityid . '"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"> Join</span></button></a>'; 
		}
    } else { // end if $alreadyjoined == FALSE
      $btnState = '<a href="leave.php?id=' . $communityid . '"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-remove"> Leave</span></button></a>';
    }
  } // end if user logged in
  /*
  echo '</h1>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<p>Created:' . $created . ' by ' . $ownername . '</p><br>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '</div>';
  echo '&nbsp;';
  echo '<div class="row">';
  echo '<div class="col-md-8">';
  */
	if ($blocked == TRUE) {
  		$blockmessage = 'You have been blocked from this community for the following reason:<br>' . $blockreason . '<br>';
		include 'viewcommynity.html.php';
  	} else { // end if $blocked == TRUE
    	
    	if (isset($_SESSION["loggedin"])) {
      		$alreadyjoined = FALSE;
      		$memberid = $_SESSION["memberid"];
      		$sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
      		$result = mysqli_query($con,$sql);
      		while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }
      		
			if ($alreadyjoined == TRUE) {
        		$createtopic = '<a href="addtopic.php?id=' . $communityid . '"> <button type="button" class="btn btn-primary btn-xs">Create Topic</button></a>';
      		}
      		if ($ownerid == $memberid) {
        		$adminpage = '<a href="communityadmin.php?id=' . $communityid . '"> <button type="button" class="btn btn-primary btn-xs">Community Admin Page</button></a>';
      		} // end if user is community owner
    	} // end if user logged in

    //echo '</h4>';
		
//STOPPPED HERE*******************************************
    	if ($numtopics > 0) {
      		$sql = 'select * from topic where communityid=' . $communityid;
      		$result = mysqli_query($con,$sql);
      		$topicowner = 0;
      		$topicownername = '';
      		$topicavatarpath = '';
      		include 'viewcommunity.html.php';
			foreach ($result as $row) {    
        		$productid = $row["productid"];
        		$productname = '';

        		$sql2 = 'select username,avatarpath from member where memberid=' . $row["ownerid"];
        		$result2 = mysqli_query($con,$sql2);
        		
				foreach ($result2 as $row2) { 
          			$topicownername = $row2["username"]; 
          			$topicavatarpath = $row2["avatarpath"];
        		}
        		echo '<div class="row show-grid">
						<div class="col-md-12">
							<div class="media">
							<a class="pull-left" href="#">
								<img class="img-circle" img src="' . $topicavatarpath . '" width="64" height="64" alt="' . $topicownername . '">
							</a>
							<div class="media-body">
								<h4 class="media-heading"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a>' . '</h4>
								Created: ' . $row["created"] . ' by ' . $topicownername . '.';
        		
				if ($alreadyjoined == TRUE) {
          			echo '<a href="addcontent.php?id=' . $row["topicid"] . '"> <button type="button" class="btn btn-primary btn-xs">Add Content</button></a>';
        		} // end if alreadyjoined == TRUE to display add content button
        		if (is_numeric($productid)) {
          			$sql4 = 'select name from product where productid=' . $productid;
          			$result4 = mysqli_query($con,$sql4);
          			foreach ($result4 as $row4) { $productname = $row4["name"]; }
          			echo '<td align="center"><a href="viewproduct.php?id=' . $productid . '">' . $productname . '</a></td>';
        		} 
        		
				$numtopiccontent = 0;
        		$sql2 = 'select count(contentid) from content where topicid=' . $row["topicid"];
        		$result2 = mysqli_query($con,$sql2);
        		while($row2 = mysqli_fetch_array($result2)) { $numtopiccontent = $row2["count(contentid)"]; }
        		if ($numtopiccontent > 0) {
          			$sql2 = 'select * from content where topicid=' . $row["topicid"];
          			$result2 = mysqli_query($con,$sql2);
          			echo '<br>';
          			
					foreach ($result2 as $row2) {
            			$contentownername = '';
            			$contentowneravatarpath = '';
            			$sql3 = 'select username,avatarpath from member where memberid=' . $row2["ownerid"];
            			$result3 = mysqli_query($con,$sql3);
            			
						foreach ($result3 as $row3) { 
              				$contentownername = $row3["username"]; 
              				$contentowneravatarpath = $row3["avatarpath"];
            			}
            		
						echo '<img class="img-circle" img src="' . $contentowneravatarpath . '" width="64" height="64" alt="' . $contentownername . '">';
            			echo '     ' . $row2["message"] . ' ';
            			
						if (is_numeric($row2["productid"])) { 
              				$sql4 = 'select name from product where productid=' . $row2["productid"];
              				$result4 = mysqli_query($con,$sql4);
              				
							foreach ($result4 as $row4) {
                				echo '<a href="viewproduct.php?id=' . $row2["productid"] . '">' . $row4["name"] . '</a>';
              				} // end foreach loop to build product link
            			} // end if productid is numeric for content   
            			echo '<br>';
            			echo '          added: ' . $row2["created"] . ' by ' . $contentownername . '.';
            			
						if ($loggedin == TRUE) {
              				if ($row2["created"] > $_SESSION["lastlogin"]) { echo '<font color="red">NEW!</font>'; }
            			}
            			echo '<br>';
            			
						if ($row2["type"] == 1) { 
              				echo '<img class="img-circle" img src="' . $row2["path"] . '" width="100" height="100" alt="Generic placeholder image">';
              				echo $row2["description"] . '<br>';
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
		$notopic = '<div class="row">
						<div class="col-md-12" style="padding-left:5em">There are currenty no topics, please check back soon!</div>
					</div>	';
		include 'viewcommunity.html.php';
    }
	} // end if-else $blocked == TRUE
  echo '</div>';


  mysqli_close($con);

?>      
 <br/>
        <br/>
	</div><!-- /end of container-->
    
      

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