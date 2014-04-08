// DONE 04/04/14 10:50 AM
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

    <title>Circle | Product</title>
    
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
          <form class="navbar-form navbar-form-length"  role="search" action="search.php" method="post">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70" required>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            	
 
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
          	<div class="btn-group btn-group-justified">
              <!-- MAY WANT TO USE THIS FOR THE 3 HEADINGS
              <div class="btn-group">
                <button type="button" class="btn btn-default">Left</button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-default">Middle</button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-default">Right</button>
              </div>
            </div>-->
            
            
            <h5 align="center"><a href="community.php">Community</a> |  <a href="#">Topic</a> | <a href="product.php">Product</a></h5>
          </div>
        </div>
        </div>
      <div class="row">
        <div class="col-md-6">
          	<h1>Product</h1>
        </div>

<?php
  if (isset($_SESSION["loggedin"])) {
    if ($_SESSION["role"] == "s") {
      echo '<div class="col-md-6" align="right">';
      echo '<a href="addproduct.php"><button type="button" class="btn btn-primary btn-lg">Add Product</button></a>';
      echo '</div>';
      echo '</div>';
    } // end if user is Seller
  } // end if user is logged in


  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  $totalprodducts = 0;
  $maxdisplay = 0;

  $sql = "select count(productid) from product";
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totalproducts = $row["count(productid)"]; }
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
        echo '<div class="col-md-3">';
        echo '<table align="center">';
        echo '<tr>';
        echo '<td align="center"><a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" height="300" width="300" alt="Generic placeholder image"></a></td>';
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

    } // end while loop to print random order

    echo '</div>';

  } else { // end if $totalproducts > 0
    echo "There are currently no products to display!<br>";
    echo "Please check back soon!<br>";
  } // end if-else $totalproducts > 0

  echo '<p>&nbsp;</p>';
  echo '<div class="row">';
  echo '<div class="col-md-12">';
  echo '<hr class="featurette-divider" id="topProduct">';
  echo '<p>&nbsp;</p>';
  echo '<h3 >Top Products</h3>';
  echo '</div>';
  echo '</div>';
  echo '<div class="row">';
  $maxproducts = 0;
  $sql = 'select * from product order by (rating/numreviews) desc';
  $result = mysqli_query($con,$sql);
  while(($row = mysqli_fetch_array($result)) && ($maxproducts < 5)) {
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
    echo '<td align="center"><a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" height="300" width="300" alt="Generic placeholder image"></a></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td align="center">' . $row["name"] . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td align="center">';

    $stars = 0;
    $rating = round($rating,2);
    while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
      echo '<span class="glyphicon glyphicon-star"></span>';
      $stars += 1;
    }
    echo '(' . $rating . ')';
    echo '</td>';
    echo '</tr>';
    echo '</table>';     
    echo '</div>';
    
  } // end while loop to print the products by rating

  mysqli_close($con);

?>
        </div>
      
        <p>&nbsp;</p>
      	<p>&nbsp;</p>
      	<p>&nbsp;</p>
    	<p>&nbsp;</p>
     	<p>&nbsp;</p>
      
      
      
      
      <!-- /END THE FEATURETTES -->


      <!-- Footer
          Need to do:
    		-Add color to the bottom
            -May want to add bread crumb for navigation purposes
    ================================================== -->
      <!--<ol class="breadcrumb">
      	<li><a href="index.php">Home</a></li>
      </ol>-->
      <hr class="featurette-divider">
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