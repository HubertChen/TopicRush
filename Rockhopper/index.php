<!-- DONE: 4/7/14 -->
<?php session_start(); ?>
	<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">

<?php
	/*WILL NEED TO CHANGE*/
   	$dbhost = "localhost";
  	$dbuser = "root";
  	$dbpass = "";
  	$dbname = "Circle";
	          
  //navbar: user is logged in           
  	if (isset($_SESSION["loggedin"])) {
    	$navbar = '<a href="signout.php"><button type="button" class="btn btn-signin navbar-btn-right btn-sm" >Sign Out</button></a>
					<div class="navbar-right">
						<a href="profile.php">
							<img src="'. $_SESSION["avatarpath"] . '" alt="User Profile Image" width="35" height="35" class="img-circle">
						</a>
						<a href="profile.php">' . $_SESSION["username"] . '</a>
					</div>';
					
					//include 'product.html.php';
	
	} else { // end if user is logged in
    	$navbar ='<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
					<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
					
					//include 'product.html.php';
  	} // end if-else user is logged in

  	//Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
	
		include 'index.html.php';
		exit(); 
  	} 
	
	include 'index.html.php';

  	$totalcommunity = 0;
  	$totaltopic = 0;
  	$totalproduct = 0;
  	$maxcommunity = 0;
  	$maxtopic = 0;
  	$maxproduct = 0;

  	$sql = 'select count(communityid) from community';
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $totalcommunity = $row["count(communityid)"]; }
  	if ($totalcommunity > 2) {
    	$maxcommunity = 3;
  	} else {
    	$maxcommunity = $totalcommunity;
  	}

  	$sql = 'select count(topicid) from topic';
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $totaltopic = $row["count(topicid)"]; }
 	if ($totaltopic > 2) {
    	$maxtopic = 3;
  	} else {
    	$maxtopic = $totaltopic;
  	}

  	$sql = 'select count(productid) from product';
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $totalproduct = $row["count(productid)"]; }
  	if ($totalproduct > 2) {
   		$maxproduct = 3;
  	} else {
    	$maxproduct = $totalproduct;
  	}  
	
	echo '<div class="row">';
	echo '<div class="col-lg-4">';
  	echo '<h3>Top Community</h3>'; 
  	echo '<table align="center">';
  	if ($maxcommunity > 0) {
    	$count = 0;
    	$sql = 'select * from community order by rating desc';
    	$result = mysqli_query($con,$sql);

    	while(($row = mysqli_fetch_array($result)) && ($count < $maxcommunity)) {
      		$count += 1;
      		echo '<tr>';
      			echo '<td class="table-top-product-padding" rowspan="2">' . $count . '.</td>';
      			echo '<td class="text-left table-top-product-padding" rowspan="2">';
      				echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="90" width="90" alt="' . $row["name"] . '"></a>';
      			echo '</td>';
      			echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >';
      				echo $row["name"];
      			echo '</td>';
      		echo '</tr>';
      		echo '<tr>';
      			//echo '<td class="table-top-product-stars" align="left" valign="top">';
      			echo '<td align="left" valign="top" style="font-size:12"><em>' . $row["nummembers"] . ' Members</em></td>';
      		echo '</td>';
      		echo '</tr>';
    	} // end while loop to display top community
	} else { // end if $maxcommunity > 0
		echo 'There are currently no communities, please check back soon!';
  	} // end if-else $maxcommunity > 0
  	
	echo '</table>'; 
  	echo '<p><a class="btn btn-default" href="community.php#topCommunity" role="button">more &raquo;</a></p>';
  	echo '</div><!-- /.col-lg-4 -->';   

 
  	echo '<!--Topic Head -->';
 	echo '<div class="col-lg-4">';
  	echo '<h3>Top Topic</h3>';       
  	echo '<table class="table-top" align="center">';
  
  	if ($maxtopic > 0) {
    	$sql = 'select topicid from topic';
    	$result = mysqli_query($con,$sql);
    	foreach ($result as $row) { 
      		$sql2 = 'select count(contentid) from content where topicid=' . $row["topicid"];
      		$result2 = mysqli_query($con,$sql2);
      		foreach ($result2 as $row2) { $data[] = array("topic" => $row["topicid"], "content" => $row2["count(contentid)"]); }
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

    	$count = 0;

    	while($count < $maxtopic) {
      		$sql = 'select * from topic where topicid=' . $toptopics[$count];
      		$result = mysqli_query($con,$sql);

      	foreach ($result as $row) {
        	echo '<tr>';
        	echo '<td>' . ($count+1) . '.</td>';
        	echo '<td class="text-left"> <a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a></td>';
        	echo '</tr>';
      	} // end for loop to print Topic Information.
      	$count += 1;
	} // end while loop to print top topics
  } else { // end if $maxtopic > 0
	echo 'There are currently no products, please check back soon!';
  } // end if-else $maxtopic > 0

  	echo '</table>';   
  	echo '<p><a class="btn btn-default" href="topic.php#topTopic" role="button">more &raquo;</a></p>';
  	echo '</div><!-- /.col-lg-4 -->';  

  
  	echo '<!--Product Head -->';
  	echo '<div class="col-lg-4">';
  	echo '<h3>Top Product</h3>';
  	echo '<table align="center">';

  	if ($maxproduct > 0) {
    	$count = 0;
    	$sql = 'select * from product order by (rating/numreviews) desc';
    	$result = mysqli_query($con,$sql);
    	
		while(($row = mysqli_fetch_array($result)) && ($count < $maxproduct)) {
      		$count += 1;

      		$rating = 0;
      		
			if ($row["numreviews"] != 0) {
        		$rating = $row["rating"] / $row["numreviews"];
      		}

      		$numrecords = 0;
      		$imagepath = "";
      		$sql2 = 'select path from productdetail where productid=' . $row["productid"];
      		$result2 = mysqli_query($con,$sql2);
      		while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
        		$numrecords += 1;
        		$imagepath = $imagepath . $row2["path"];
      		}


      		echo '<tr>';
      		echo '<td class="table-top-product-padding" rowspan="2">' . $count . '.</td>';
      		echo '<td class="text-left table-top-product-padding" rowspan="2">';
      		echo '<a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" width="90" height="90" alt="' . $row["name"] . '"></a>';
      		echo '</td>';
      		echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >' . $row["name"] . '</td>';
      		echo '</tr>';
      		echo '<tr>';
      		echo '<td class="table-top-product-stars" align="left" valign="top">';
      		
			$stars = 0;
      		$rating = round($rating,1);
      		while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
        		echo '<span class="glyphicon glyphicon-star"></span>';
        		$stars += 1;
      		}
      		echo '(' . $rating . ')';
      		echo '</tr>';
    	} // end while loop to print top proucts
	} else { // end if $maxproduct > 0
	echo 'There are currently no products, please check back soon!';
  	} // end if-else $maxproduct > 0

	echo '</table>';
  	echo '<p><a class="btn btn-default" href="product.php#topProduct" role="button">more &raquo;</a></p>';
  	echo '</div><!-- /.col-lg-4 -->';
 	echo '</div><!-- /.row -->';

	mysqli_close($con);

?><!-- /END THE FEATURETTES -->
	<br/>
    <br/>


	<!-- Footer
    ================================================== -->
      <div class="container">
          <footer>
              <br/>
              <br/>
              <br/>
              <div align="center">
                <img src="images/logo03.png" width="75" height="75" align="Circle">
              </div>
              <br/>
              <br/>
              <br/>
              <hr/>
              <p class="pull-right"><a href="#top">Back to top</a></p>
              <p>&copy; 2014 Circle, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a> &middot; <a href="about.php">About</a></p>
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