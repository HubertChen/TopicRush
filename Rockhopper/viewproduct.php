<!-- DONE: 4/8/14 -->

<?php session_start(); ?>

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
	
	} else { // end if user is logged in
    	$navbar ='<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
					<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
  	} // end if-else user is logged in


  //Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
	//$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Community</button>';
	include 'viewproduct.html.php';
	exit(); 
  	} 

  	$productid = $_GET["id"];
  	$productname = '';
  	$ownerid = '';
  	$ownername = '';
  	$description = '';
  	$ratingpoints = 0;
  	$numreviews = 0;
  	$rating = 0;
  	$listedprice = '';
  	$categoryid = 0;
  	$categoryname = '';
  	$imagepath = '';

  	$sql = 'select * from product where productid=' . $productid;
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) {
    	$productname = $row["name"];
    	$ownerid = $row["ownerid"];
    	$description = $row["description"];
    	$ratingpoints = $row["rating"];
    	$numreviews = $row["numreviews"];
    	$listedprice = $row["listedprice"];
    	$categoryid = $row["category"];
  	} // end for loop to get product information

  	if ($numreviews > 0) { $rating = $ratingpoints / $numreviews; }

  	$sql = 'select name from category where categoryid=' . $categoryid;
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $categoryname = $row["name"]; }

  	$sql = 'select username from member where memberid=' . $ownerid;
  	$result = mysqli_query($con,$sql);
  	foreach ($result as $row) { $ownername = $row["username"]; }

  	$numrecords = 0;
  	$sql2 = 'select path from productdetail where productid=' . $productid;
  	$result2 = mysqli_query($con,$sql2);
  	while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
    	$numrecords += 1;
    	$imagepath = $imagepath . $row2["path"];
  	}

  if (isset($_SESSION["loggedin"])) {
  	$alreadyreviewed = FALSE;
    $memberid = $_SESSION["memberid"];
    $sql = 'select * from review where productid=' . $productid . ' and memberid=' . $memberid;
    $result = mysqli_query($con,$sql);
    $found = 0;
    while($row = mysqli_fetch_array($result)) { 
      $found += 1; 
    }
    if ($found > 0) { $alreadyreviewed = TRUE; }

    if (($ownerid != $_SESSION["memberid"]) && ($alreadyreviewed == FALSE)) {
      $button = '<a href="reviewproduct.php?id=' . $productid . '"> <button type="button" class="btn btn-primary btn-xs">Write Review</button></a>';
    } // end if user is the owner of the product
  } // end if user is logged in

  if ($numreviews > 0) {
    $sql = 'select * from review where productid=' . $productid;
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) {
      $reviewname = '';
      $reviewavatar = '';
      $sql2 = 'select username,avatarpath from member where memberid=' . $row["memberid"];
      $result2 = mysqli_query($con,$sql2);
      foreach ($result2 as $row2) { 
        $reviewname = $row2["username"]; 
        $reviewavatar = $row2["avatarpath"];
      }
	  
	  for ($i=0;$i < $row["rating"];$i++) {
      		$starglyph = '<span class="glyphicon glyphicon-star"></span>';
      }
	  
	  $review = '<div class="row">
	  			<div class="col-md-12">
					<div class="media">
						<a class="pull-left" href="#">
							<img class="img-circle" src="' . $reviewavatar . '" width="64" height="64" alt="Generic placeholder image">
						</a>
						<div class="media-body">
							<h4 class="media-heading">' . $reviewname . '</h4>
								<p class="media-heading">' . $starglyph . '</p>' 
								. $row["reviewdetails"] . ' ' . $row["reviewdate"] . '</div>
						</div>
					</div>
				</div>
				&nbsp;';
		include 'viewprodut.html.php';
		exit();
    } // end for loop for reviews
  } else { // end if $numreviews > 0
    $review = "There are no reviews for this product<br/>";
	include 'viewproduct.html.php';
	exit();
  } // end if-else $numreviews > 0

  mysqli_close($con);

?> 
 
 
