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

    <title>Circle | Join</title>
    
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
          	&nbsp;
          </div>
        </div>

<?php

  if (isset($_SESSION["loggedin"])) {
 
    $dbhost = "localhost:3306";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "Circle";
    $communityid = $_GET["id"];
    $memberid = $_SESSION["memberid"];
    $validcommunity = FALSE;
    $alreadyjoined = FALSE;

    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      echo "Failed to connect to MySQL: " . mysqli_connect_error();  
    }

    $sql = 'select name from community where communityid=' . $communityid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $validcommunity = TRUE; }

    if ($validcommunity == TRUE) {
      $sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }

      if ($alreadyjoined == FALSE) {

        $sql = 'select path from community where communityid=' . $communityid;
        $result = mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($result)) {  $communitylogo = $row["path"]; }

        echo '<div class="row">';
        echo '<div class="col-md-3">';
        echo '<table align="center">';
        echo '<tr>';
        echo '<td align="center">';
        echo '<a href="viewcommunity.php?id=' . $communityid . '"><img class="img-circle"  img src="' . $communitylogo . '" height="150" width="150" alt="Generic placeholder image"></a>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo 'You have successfully joined this community!<br>';
        $sql = "insert into joins(memberid,communityid) values('" . $memberid . "','" . $communityid . "')";
        mysqli_query($con,$sql);


      } else { // end if $alreadyjoined == FALSE
        echo 'You have already joined this community!<br>';
      } // end if-else $alreadyjoined == FALSE

    } else { // end if $validcommunity == TRUE
      echo 'Community does not exist<br>';
    } // end if-else $validcommunity == TRUE







    mysqli_close($con);

  } else { // end if user is logged in
    echo 'You have navigated to this page in error, you must be logged in to use this page!<br>';
  }

?>
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
        <p>&copy; 2014 Circle, Inc. &middot; <a href="#top">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">About</a></p>
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