<!-- DONE: 4/8/14 -->
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
  
    	include 'community.html.php';
    	exit(); 
    }
	
	if (isset($_SESSION["loggedin"])) {
    	$addcommunity = '<a href="addcommunity.php"><button type="button" class="btn btn-primary btn-lg pull-right">Add Community</button></a>';
  	} // end if user is logged in

  	$totalcommunities = 0;
  	$sql = 'select count(communityid) from community';
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $totalcommunities = $row["count(communityid)"]; }

  	if ($totalcommunities > 0) {

    	$communityarray = array();
    	$sql = 'select communityid from community';
    	$result = mysqli_query($con,$sql);
    	foreach ($result as $row) { array_push($communityarray,$row["communityid"]); }

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

		include 'community.html.php';

		echo '<div class="row">';
    	$communityowners = array();
    	$index = 0;
    	while ($index < $maxcommunity) {
    		$sql = 'select * from community where communityid=' . $randomorder[$index];
      		$result = mysqli_query($con,$sql);
      		$index += 1;
      	
		foreach ($result as $row) {
        	echo '
				  <div class="col-md-3">
					  <table align="center" border="1">
						  <tr>
							  <td align="center">
								  <a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="'. $row["name"] . '"></a>
							  </td>
						  </tr>
						  <tr>
							  <td align="center">' . $row["name"] . '</td>
						  </tr>
					  </table>
				  </div>';
      	} // end for loop to display communities
    } // end while loop to print community randomly
    echo '</div>';
	echo '<hr class="featurette-divider" id="topCommunity">';
    echo '<div class="row show-grid">';
    echo '<div class="col-md-12">';
    echo '<h3 >Top</h3>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';

    $count = 0;
    $sql = 'select * from community order by rating desc';
    $result = mysqli_query($con,$sql);
    
	foreach ($result as $row) {        
    	$count += 1;
		
		echo '<div class="col-md-3">';
      	echo '<table align="center">';
      	echo '<tr>';
      	echo '<td rowspan="3" valign="top"><h4>' . $count . '.</h4></td>';
      	echo '<td align="center"><a href="viewcommunity.php?id= ' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="'. $row["name"] . '"></a></td>';
      	echo '</tr>';
      	echo '<tr>';
      	echo '<td align="center">';
      	echo $row["name"];
		//echo '<a href="php/join.php"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span></button></a>';
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
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
             		 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            			There are currently no communities, please add one!
            			</div>';
  	} // end if-else $totalcommunities > 0

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