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

    <title>Review | Circle</title>
    
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
              <input type="text" class="form-control" placeholder="Seach for communities, topics, and products" size="70" maxlength="70">
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
  
  if (isset($_SESSION["loggedin"])) {

    $dbhost = "localhost:3306";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "Circle";

    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }

    $memberid = $_SESSION["memberid"];
    $productid = $_GET["id"];
    $alreadyreviewed = FALSE;
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
    $imagepath = '/bzk';
    $date = new DateTime();
    $tstamp = $date->format('Y-m-d H:i:s');

    $sql = 'select * from review where productid=' . $productid . ' and memberid=' . $memberid;
    $result = mysqli_query($con,$sql);
    $found = 0;
    while($row = mysqli_fetch_array($result)) { 
      $found += 1; 
    }
    if ($found > 0) { $alreadyreviewed = TRUE; }
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
    echo '<td align="center"><img class="img-circle"  img src="' . $imagepath . '" alt="Generic placeholder image"></td>';
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
    echo '<h4><em>' . $ownername . '</em></h4>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<h6>' . $categoryname . '</h6>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<p>' . $description . '</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '<hr class="featurette-divider">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    if ($alreadyreviewed == FALSE) {
      echo '<h4>Write Review</h4>';
      echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-md-1">';
      echo '<form action="reviewproduct.php?id=' . $productid . '" method="post" role="form">';
      echo '<div class="form-group">';
      echo '<label for="rating">Rating</label>';
      echo '<select class="form-control" name="rating" id="rating">';
      echo '<option value="0">0</option>';
      echo '<option value="1">1</option>';
      echo '<option value="2">2</option>';
      echo '<option value="3">3</option>';
      echo '<option value="4">4</option>';
      echo '<option value="5">5</option>';
      echo '</select>';
      echo '</div>';
      echo '</div>';
      echo '<div class="col-md-7">';
      echo '<div class="form-group">';
      echo '<label for="ratedescript">Description</label>';
      echo '<textarea class="form-control" rows="3" name="ratedescript" id="ratedescript" placeholder="Descriptions" required></textarea>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-md-8" align="right">';
      if (($ownerid != $memberid) && ($alreadyreviewed == FALSE)) {
        echo '<button type="submit" class="btn btn-primary">Review</button>';
      }
      echo '</div>';
      echo '</div>';
      echo '</form>';
    } else { // end if $alreadyreviewed == FALSE
      echo "You have already reviewed this product!<br>";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $validform = TRUE;
      $formerrors = '';
      $postrating = $_POST["rating"];
      $postdescription = $_POST["ratedescript"];
 //     echo $postrating . "<br>" . $postdescription . "<br>";
      if ($postrating == 0) {
        $validform = FALSE;
        $formerrors = $formerrors . "Rating must be between 1 and 5!<br>";
      }
      if ((strlen($postdescription) < 20) || is_numeric($postdescription)) {
        $validform = FALSE;
        $formerrors = $formerrors . "Description must be twenty or more characters and must not contain all numbers!<br>";
      }

      if ($validform == TRUE) {
        $sql="insert into review(memberid,productid,reviewdetails,rating,reviewdate) values ('$memberid','$productid','$postdescription','$postrating','$tstamp')";
        mysqli_query($con,$sql);

      } else { // end if $validform == TRUE
        echo "Form has the following errors:<br>" . $formerrors;
        $formerrors = '';
      } // end if-else $valiform == TRUE


    }

      
  mysqli_close($con);

  } else { // end if user is logged in
    echo "You must be registered and logged in to use this page!<br>";
  }
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