<!-- DONE: 4/6/14 -->
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
	
	if (isset($_SESSION["loggedin"])) {
    	if ($_SESSION["role"] == "s") {
      		$addproduct = '<a href="addproduct.php"><button type="button" class="btn btn-primary btn-lg pull-right" align="right">Add Product</button></a>';
    	} // end if user is Seller
  	} // end if user is logged in


  

  	//Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
	
		include 'product.html.php';
		exit(); 
  	} 
	
	include 'product.html.php';
		
	$totalprodducts = 0;
	$maxdisplay = 0;

  	$sql = "select count(productid) from product";
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $totalproducts = $row["count(productid)"]; }
  	//echo "Total Products = " . $totalproducts . "<br>";
  	if ($totalproducts > 0) {
    	echo '<div class="row">';
    	echo '<div class="col-md-12"><h3>Explore</h3></div>';
    	echo '</div>';
    	echo '<div class="row">';
		
		$productarray = array();
    	$sql = 'select productid from product';
    	$result = mysqli_query($con,$sql);
    	foreach ($result as $row) { array_push($productarray,$row["productid"]); }

    	$maxproducts = count($productarray);  

   	 	$randomorder = array();
    	$index = 0;
    	while ($index < $maxproducts) {
      		$rand = rand(0,($maxproducts-1));
      		if (in_array($productarray[$rand],$randomorder) == FALSE) {
        		$index += 1;
        		array_push($randomorder,$productarray[$rand]);
      		}
    	} // end while loop to generate random order

		
		if ($totalproducts > 15) {
      		$maxdisplay = 15;
    	} else { 
     		$maxdisplay = $maxproducts;
    	}
		
		$index = 0;
    	while ($index < $maxdisplay) {
      		$sql = 'select * from product where productid=' . $randomorder[$index];
      		$result = mysqli_query($con,$sql);
      		$index += 1;
      		foreach ($result as $row) {
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
		
    	/*
		if ($totalproducts > 15) {

    	} else { // end if $totalproducts > 4
      		$sql = 'select * from product';
      		$result = mysqli_query($con,$sql);
      		foreach ($result as $row) {
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
		*/		
				echo '<div class="col-md-3">';
				echo '<table align="center">';
				echo '<tr>';
				echo '<td align="center"><a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" height="150" width="150" alt="' . $row["name"] . '"></a></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td align="center">' . $row["name"] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td align="center">';
        		
				$stars = 0;
        		$rating = round($rating,1);
        		while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
          			echo '<span class="glyphicon glyphicon-star"></span>';
          			$stars += 1;
        		}
				echo '(' . $rating . ')';
					   
				echo '</td>';
				echo '</tr> ';
				echo '</table>';
				echo '</div>';
			} // end for-loop to display the products	
    	} // end to print out random order
		echo '</div>';
  	} else { // end if $totalproducts > 0
    	
		echo '<div class="alert alert-info alert-dismissable" align="center">
     			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Currently no products, please come back soon!
				</div>';					
  } // end if-else $totalproducts > 0


	/*TOP PRODUCTS*/
	// for top producs $sql = 'select * from product order by (rating/numreviews) desc';
  	echo '<p>&nbsp;</p>';
  	echo '<div class="row">';
  	echo '<div class="col-md-12">';
  	echo '<hr class="featurette-divider" id="topProduct">';
  	echo '<h3 >Top</h3>';
  	echo '</div>';
  	echo '</div>';
  	echo '<div class="row">';
  
  	$maxproducts = 0;
  	$sql = 'select * from product order by (rating/numreviews) desc';
  	$result = mysqli_query($con,$sql);
  	while(($row = mysqli_fetch_array($result)) && ($maxproducts < 4)) {
    	$rating = 0;
    	if ($row["numreviews"] != 0) {
      		$rating = $row["rating"] / $row["numreviews"];
    	}
    	$maxproducts += 1;
    	$numrecords = 0;
    	$imagepath = "";
    	$sql2 = 'select path from productdetail where productid=' . $row["productid"];
    	$result2 = mysqli_query($con,$sql2);
    	
		while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
      		$numrecords += 1;
      		$imagepath = $imagepath . $row2["path"];
    	}
    	
		echo '<div class="col-md-3">';
    	echo '<table align="center">';
    	echo '<tr>';
    	echo '<td rowspan="3" valign="top"><h4>' . $maxproducts . '.</h4></td>';
    	echo '<td align="center"><a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" height="150" width="150" alt="' . $row["name"] . '"></a></td>';
    	echo '</tr>';
    	echo '<tr>';
    	echo '<td align="center">' . $row["name"] . '</td>';
    	echo '</tr>';
    	echo '<tr>';
    	echo '<td align="center">';

    	$stars = 0;
    	$rating = round($rating,1);
    	while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
      		echo '<span class="glyphicon glyphicon-star"></span>';
      		$stars += 1;
    	}
    	echo '(' . $rating . ')';
    	echo '</td>';
    	echo '</tr>';
    	echo '</table>';     
    	echo '</div>';
	} 
	mysqli_close($con);

?>
        </div>
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