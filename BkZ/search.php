<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle | Search Results</title>
    
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
    <div class="container" style="background-color:rgb(255, 255, 255)">
    	<p>&nbsp;</p>
      	<p>&nbsp;</p>
      
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
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  $search = $_POST["search"];
  $words = explode(" ", strtolower($search));
  $totalwords = count($words);
  $communitylist = array();
  $topiclist = array();
  $productlist = array();
  
  $sql = 'select name,communityid from community';
  $result = mysqli_query($con,$sql);
  while($row=mysqli_fetch_array($result)) {
    $found = FALSE;
    $index = 0;
    while (($found == FALSE) && ($index < $totalwords)) {
      $pattern = "/" . $words[$index] . "/";
      if (preg_match($pattern,strtolower($row['name'])))  { $found = TRUE; }
      $index += 1;
    }
    if ($found == TRUE) {
      if (in_array($row["communityid"],$communitylist) == FALSE) { array_push($communitylist,$row["communityid"]); }
    }
  }

  $sql = 'select name,topicid from topic';
  $result = mysqli_query($con,$sql);
  while($row=mysqli_fetch_array($result)) {
    $found = FALSE;
    $index = 0;
    while (($found == FALSE) && ($index < $totalwords)) {
      $pattern = "/" . $words[$index] . "/";
      if (preg_match($pattern,strtolower($row['name'])))  { $found = TRUE; }
      $index += 1;
    }
    $sql2 = 'select message,description from content where topicid=' . $row["topicid"];
    $result2 = mysqli_query($con,$sql2);
    while($row2=mysqli_fetch_array($result2)) {
      $index = 0;
      while (($found == FALSE) && ($index < $totalwords)) {
        $pattern = "/" . $words[$index] . "/";
        if (preg_match($pattern,strtolower($row2['message'])))  { $found = TRUE; }
        if (preg_match($pattern,strtolower($row2['description'])))  { $found = TRUE; } 
        $index += 1;
      }
    }
    if ($found == TRUE) {
      if (in_array($row["topicid"],$topiclist) == FALSE) { array_push($topiclist,$row["topicid"]); }
    }
  }

  $sql = 'select productid,name,description from product';
  $result = mysqli_query($con,$sql);
  while($row=mysqli_fetch_array($result)) {
    $found = FALSE;
    $index = 0;
    while (($found == FALSE) && ($index < $totalwords)) {
      $pattern = "/" . $words[$index] . "/";
      if (preg_match($pattern,strtolower($row['name'])))  { $found = TRUE; }
      if (preg_match($pattern,strtolower($row['description'])))  { $found = TRUE; }
      $index += 1;
    }
    $sql2 = 'select description from productdetail where productid=' . $row["productid"];
    $result2 = mysqli_query($con,$sql2);
    while($row2=mysqli_fetch_array($result2)) {
      $index = 0;
      while (($found == FALSE) && ($index < $totalwords)) {
        $pattern = "/" . $words[$index] . "/";
        if (preg_match($pattern,strtolower($row2['description'])))  { $found = TRUE; } 
        $index += 1;
      }
    }
    $sql2 = 'select reviewdetails from review where productid=' . $row["productid"];
    $result2 = mysqli_query($con,$sql2);
    while($row2=mysqli_fetch_array($result2)) {
      $index = 0;
      while (($found == FALSE) && ($index < $totalwords)) {
        $pattern = "/" . $words[$index] . "/";
        if (preg_match($pattern,strtolower($row2['reviewdetails'])))  { $found = TRUE; } 
        $index += 1;
      }
    }
    if ($found == TRUE) {
      if (in_array($row["productid"],$productlist) == FALSE) { array_push($productlist,$row["productid"]); }
    }
  }


  $totalcommunity = count($communitylist);
  $totaltopic = count($topiclist);
  $totalproduct = count($productlist);

  echo '<div class="row show-grid">';
  echo '<div class="col-md-12">';
  echo '<h1>Search results for: "' . $search . '"</h1>';
  echo '</div>';
  echo '</div>';
  if ($totalcommunity > 0) {
    echo '<div class="row show-grid">';
    echo '<div class="col-md-12">';
    echo '<h3>Community</h3>';
    echo '</div>';
    echo '</div>';
    foreach ($communitylist as $communityid) {
      $communityname = '';
      $communitypath = '';
      $sql = 'select name,path from community where communityid=' . $communityid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) {
        $communityname = $row["name"];
        $communitypath = $row["path"];
      }
      echo '<div class="row">';
      echo '<div class="col-md-3">';
      echo '<table align="center">';
      echo '<tr>';
      echo '<td align="center"><a href="viewcommunity.php?id=' . $communityid . '"><img class="img-circle"  src="' . $communitypath . '" width="150" height="150" alt="Generic placeholder image"></a></td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">' . $communityname . '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '</div>';
    } // end for loop to go through each community
  } // end if $totalcommunity > 0
  echo '<hr class="featurette-divider">';
  echo '<div class="row">';
  echo '<div class="col-md-12"><h3>Topic</h3></div>';
  echo '</div>';
  echo '<div class="row">';
  echo '<div class="col-md-6">';
  echo '&nbsp;';
  echo '<div class="row">';
  echo '<div class="col-md-12">';
  echo '<div class="media">';

  if ($totaltopic > 0) {
    foreach ($topiclist as $topicid) {
      $topicavatar = '';
      $topicname = '';
      $ownerid = 0;
      $sql = 'select ownerid,name from topic where topicid=' . $topicid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) { 
        $ownerid = $row["ownerid"]; 
        $topicname = $row["name"];
      }
      $sql = 'select avatarpath from member where memberid=' . $ownerid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) { $topicavatar = $row["avatarpath"]; }
      echo '<a class="pull-left" href="viewtopic.php?id=' . $topicid . '">';
      echo '<img class="img-circle" src="' . $topicavatar . '" width="50" height="50" alt="Generic placeholder image">';
      echo $topicname . '</a>';
    } // end for loop to print topic
  } // end if $totaltopic > 0
 
  echo '</div>';      
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '<hr class="featurette-divider">';
  echo '<div class="row">';
  echo '<div class="col-md-12"><h3>Product</h3></div>';
  echo '</div>';
  echo '<div class="row">';
  echo '<div class="col-md-3">';
  if ($totalproduct > 0) {
    foreach ($productlist as $productid) {
      $ratingpoints = 0;
      $numreviews = 0;
      $productname = '';
      $productpath = '';
      $sql = 'select name,rating,numreviews from product where productid=' . $productid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) {
        $ratingpoints = $row["rating"];
        $numreviews = $row["numreviews"];
        $productname = $row["name"];
      }
      $sql = 'select path from productdetail where productid=' . $productid;
      $result = mysqli_query($con,$sql);
      $found = FALSE;
      while(($row=mysqli_fetch_array($result)) && ($found == FALSE)) {
        $found = TRUE;
        $productpath = $row["path"];
      }
      echo '<table align="center">';
      echo '<tr>';
      echo '<td align="center"><a href="viewproduct.php?id=' . $productid . '"><img class="img-circle"  src="' . $productpath . '" width="150" height="150" alt="Generic placeholder image"></a></td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">' . $productname . '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">';
      $rating = 0;
      if ($numreviews != 0) {
        $rating = $ratingpoints / $numreviews;
      }
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
    } // end for loop to display each product
  } // end if $totalproduct > 0
  echo '</div>';
  echo '</div>';
  echo '</div>';

  mysqli_close($con);

?>
      <br/>
      <br/>
      <br/>
      </div><!-- /end container -->
      
      
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
</html>