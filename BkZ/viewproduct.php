// DONE 04/04/14 10:49 AM
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

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }
  
  $productid = $_GET["id"];
  $productname = '';
  $sql = 'select name from product where productid=' . $productid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $productname = $row["name"]; }  

  echo '<title>Circle | ' . $productname . '</title>';

  mysqli_close($con);

?>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  
  
<!-- NAVBAR
Known bugs: 	
	-in Collapse it displays a line through the buttons
	-Readjusting back to full view the buttons don't display properly

================================================== -->
  <body>
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
          <form class="navbar-form navbar-form-length"  role="search" >
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70">
            </div>

<?php               
  if (isset($_SESSION["loggedin"])) {
    echo '<a href="signout.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Out</button></a>';
    echo '<div class="navbar-right">';
    echo '<a href="profile.php">';
    echo '<img src="'. $_SESSION["avatarpath"] . '" alt="Generic placeholder image" width="35" height="35" class="img-circle">';
    echo '</a>';
    echo '<a href="profile.php">' . $_SESSION["username"] . '</a>';
    echo '</div>';


  } else { // end if user is logged in
    echo '<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>';
    echo '<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
  } // end if-else user is logged in

?>           	

          </form>  
        </div>
      </div>
    </div>

    
    
    
    <!-- Look at grid layouts on Bootstrap: http://getbootstrap.com/css/#grid -->
    <div class="container">
    	 <p>&nbsp;</p>
      	<p>&nbsp;</p>
      
		<div class="row">
          <div class="col-md-12">
          	&nbsp;
          </div>
        </div>

<?php

  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
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

  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '<table align="center">';
  echo '<tr>';
// GOING TO NEED TO WORK OUT HOW TO DISPLAY MULTIPLE PICTURES
  echo '<td align="center"><img class="img-circle"  img src="' . $imagepath . '" width="300" height="300" alt="Generic placeholder image"></td>';
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
  echo '<tr>';
  echo '<td>';
  echo '<h6>Listed Price: ' . $listedprice . '</h6>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '<div class="col-md-9">';
  echo '<table>';
  echo '<tr>';
  echo '<td>';
  echo '<h1>' . $productname . '</h1>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<h4><em>Owner : ' . $ownername . '</em></h4>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<h6>Category : ' . $categoryname . '</h6>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<p>Description : ' . $description . '</p>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '</div>';
  echo '<hr class="featurette-divider">';
  echo '<div class="row">';
  echo '<div class="col-md-12">';
  echo '<h4>Reviews &nbsp;';
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
      echo '<a href="reviewproduct.php?id=' . $productid . '"> <button type="button" class="btn btn-primary btn-xs">Write Review</button></a></h4>';
    } // end if user is the owner of the product
  } // end if user is logged in
  echo '</div>';
  echo '</div>';

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
      echo '<div class="row">';
      echo '<div class="col-md-12">';
      echo '<div class="media">';
      echo '<a class="pull-left" href="#">';
      echo '<img class="img-circle" src="' . $reviewavatar . '" width="64" height="64" alt="Generic placeholder image">';
      echo '</a>';
      echo '<div class="media-body">';
      echo '<h4 class="media-heading">' . $reviewname . '</h4>';
      echo '<p class="media-heading">';
      for ($i=0;$i < $row["rating"];$i++) {
        echo '<span class="glyphicon glyphicon-star"></span>';
      }
      echo '</p>';
      echo $row["reviewdetails"] . ' ' . $row["reviewdate"];
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '&nbsp;';
    } // end for loop for reviews
  } else { // end if $numreviews > 0
    echo "There are no reviews for this product!<br>";
  } // end if-else $numreviews > 0


        
 
  mysqli_close($con);

?> 
 
 
 
      <hr class="featurette-divider">
      <!-- /END THE FEATURETTES -->


      <!-- Footer
          Need to do:
    		-Add color to the bottom
            -May want to add bread crumb for navigation purposes
    ================================================== -->
      <!--<ol class="breadcrumb">
      	<li><a href="index.php">Home</a></li>
      </ol>-->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Circle, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">About</a></p>
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