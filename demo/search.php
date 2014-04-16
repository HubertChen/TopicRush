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

    <title>Circle | Community</title>
    
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

<?php
 	
	$search = $_POST["search"];
  	$words = explode(" ", strtolower($search));
  	$totalwords = count($words);
  	$communitylist = array();
  	$topiclist = array();
  	$productlist = array();
        $formerrors = '';

        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';
        $file = fopen($filterfile,"r");
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) { array_push($filterlist,$input); }
        }
        $filtersize = count($filterlist);

        $valid = TRUE;
        if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$search) == TRUE) {
          $valid = FALSE;
          $validform = FALSE;
          $formerrors = $formerrors . 'Invalid input, please try again!<br>';
        }
        if ($valid == TRUE) {
          $index = 0;
          $found = FALSE;
          while (($index < $filtersize) && ($valid == TRUE)) {
            $pattern = '/' . $filterlist[$index] . '/i';
            if (preg_match($pattern,$search) == TRUE) {
              $valid = FALSE;
              $validform = FALSE;
              $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
            } // end if input matches filter word
            $index += 1;
          } // end while loop to loop through each filter word
        } // end if $valid == TRUE


        if ($valid == TRUE) {  
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

  	  echo '<div class="row ">';
  		echo '<div class="col-md-12">';
  			echo '<h1>Search results for: "' . $search . '"</h1>';
  		echo '</div>';
  	  echo '</div>';
  	  echo '<div class="row ">';
	  if ($totalcommunity > 0) {
    	  echo '<div class="row ">';
    		echo '<div class="col-md-12">';
    			echo '<h3>Community</h3>';
    		echo '</div>';
    	  echo '</div>';
    	  foreach ($communitylist as $communityid) {
      		$communityname = '';
      		$communitypath = '';
      		$sql = 'select name,path from community where communityid=' . $communityid;
      		$result = mysqli_query($con,$sql);
      		while($row=mysqli_fetch_array($result)) {
        		$communityname = $row["name"];
        		$communitypath = $row["path"];
      		}
			echo '<div class="col-md-3">';
				echo '<table align="center" >';
					echo '<tr>';
						echo '<td align="center"><a href="viewcommunity.php?id=' . $communityid . '"><img class="img-circle"  src="' . $communitypath . '" width="150" height="150" alt="' . $communityname . '"></a></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td align="center">' . $communityname . '</td>';
					echo '</tr>';
				echo '</table>';
		  	echo '</div>';
    	  } // end for loop to go through each community
  	  } // end if $totalcommunity > 0
	  echo '</div>';
  	  echo '<hr/>';
  	  echo '<div class="row">';
  		echo '<div class="col-md-12"><h3>Topic</h3></div>';
  	  echo '</div>';
  	  echo '<div class="row ">';

	  if ($totaltopic > 0) {
		  foreach ($topiclist as $topicid) {
			  echo '<div class="col-md-6">';
			  echo '<div class="media">';
			  $topicavatar = '';
			  $topicname = '';
			  $ownerid = 0;
			  $sql = 'select ownerid,name from topic where topicid=' . $topicid;
			  $result = mysqli_query($con,$sql);
			  while($row=mysqli_fetch_array($result)) { 
				  $ownerid = $row["ownerid"]; 
				  $topicname = $row["name"];
			  }
			  $sql = 'select avatarpath from member where memberid=' . $ownerid;
			  $result = mysqli_query($con,$sql);
			  while($row=mysqli_fetch_array($result)) { $topicavatar = $row["avatarpath"]; }
			  echo '<a class="pull-left" href="viewtopic.php?id=' . $topicid . '">';
			  echo '<img class="img-circle" src="' . $topicavatar . '" width="50" height="50" alt="' . $topicname . '">';
			  echo $topicname . '</a>';
			  echo '</div>';
			  echo '<br/>';
		  echo '</div>';
		  } // end for loop to print topic
	  } // end if $totaltopic > 0


  	  echo '</div>';
  	  echo '<hr/>';
  	  echo '<div class="row">';
  		echo '<div class="col-md-12"><h3>Product</h3></div>';
 	  echo '</div>';
          echo '<div class="row ">';
  	
  	  if ($totalproduct > 0) {
    	  foreach ($productlist as $productid) {
      		$ratingpoints = 0;
      		$numreviews = 0;
      		$productname = '';
      		$productpath = '';
      		$sql = 'select name,rating,numreviews from product where productid=' . $productid;
      		$result = mysqli_query($con,$sql);
      		while($row=mysqli_fetch_array($result)) {
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
			echo '<div class="col-md-3">';
      		echo '<table align="center" >';
      		echo '<tr>';
      			echo '<td align="center"><a href="viewproduct.php?id=' . $productid . '"><img class="img-circle"  src="' . $productpath . '" width="150" height="150" alt="' . $productname . '"></a></td>';
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
	  echo '</div>';
      } // end for loop to display each product
    } // end if $totalproduct > 0
  
    echo '</div>';
    echo '</div>';

  } else {
    echo 'The search contains innapropriate material!<br>';
  }

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
