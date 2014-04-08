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

  $communityid = $_GET["id"];
  $communityname = "";
  $sql = 'select name from community where communityid=' . $communityid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $communityname = $row["name"]; }


  echo '<title>Circle | ' . $communityname . ' </title>'; 

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
          <form class="navbar-form navbar-form-length"  role="search" action="search.php" method="post">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70" required>
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

  $memberid = 0;
  $communityid = $_GET["id"];
  $communityname  = '';
  $ownerid = 0;
  $ownername = '';
  $created = '';
  $nummembers = 0;
  $numtopics = 0;
  $numcontent = 0;
  $rating = 0;
  $communityimage = '';
  $loggedin = FALSE;
  $alreadyjoined = FALSE;
  $isowner = FALSE;


  $sql = 'select * from community where communityid=' . $communityid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) {
    $communityname = $row["name"];
    $ownerid = $row["ownerid"];
    $created = $row["created"];
    $nummembers = $row["nummembers"];
    $numtopics = $row["numtopics"];
    $numcontent = $row["numcontents"];
    $rating = $row["rating"];  
    $communityimage = $row["path"];
  } // end for loop to get community information

  if (isset($_SESSION["loggedin"])) { 
    $loggedin = TRUE;
    $memberid = $_SESSION["memberid"];
    $alreadyjoined = FALSE;
    $memberid = $_SESSION["memberid"];
    $sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $alreadyjoined = TRUE; }
    if ($ownerid == $memberid) { $isowner = TRUE; }
  }

  $sql = 'select username from member where memberid=' . $ownerid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $ownername = $row["username"]; }

  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '<table align="center">';
  echo '<tr>';
  echo '<td align="center"><img class="img-circle"  img src="' . $communityimage . '" width="150" height="150" alt="Generic placeholder image"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td align="center">';
  echo '(' . $rating . ') M=' . $nummembers . ',T=' . $numtopics . ',C=' . $numcontent . '.';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '<div class="col-md-9">';
  echo '<table>';
  echo '<tr>';
  echo '<td>';
  echo '&nbsp;';
  echo '<h1>';
  echo $communityname;
  echo '</h1>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<p>Created:' . $created . ' by ' . $ownername . '</p><br>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '</div>';
  echo '&nbsp;';
  echo '<div class="row">';
  echo '<div class="col-md-8">';
  echo '</div>';
  echo '</div>';

  if (($loggedin == TRUE) && ($isowner == TRUE)) {
    $sql = 'select memberid from joins where communityid=' . $communityid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
      $membername = '';
      $memberavatar = '';
      $blockid = 0;
      $isblocked = FALSE;
      $blockreason = '';
      $sql2 = 'select username,avatarpath,memberid from member where memberid=' . $row["memberid"];
      $result2 = mysqli_query($con,$sql2);
      foreach ($result2 as $row2) { 
        $membername = $row2["username"];
        $memberavatar = $row2["avatarpath"]; 
        $blockid = $row2["memberid"];
      }
      $sql2 = 'select * from block where memberid=' . $row["memberid"] . ' and communityid=' . $communityid;
      $result2 = mysqli_query($con,$sql2);
      while($row2 = mysqli_fetch_array($result2)) {
        $isblocked = TRUE;
        $blockreason = $row2["reason"];
      }
      echo '<img class="img-circle" src="' . $memberavatar . '" width="64" height="64" alt="Generic placeholder image">';
      echo $membername . ' ';
      if ($blockid != $memberid) {
        if ($isblocked == TRUE) {
          echo '<a href="unblock.php?member=' . $row["memberid"] . '&community=' . $communityid .'"><button type="button">Unblock</button></a>';
          echo 'Blocked for : ' . $blockreason . '<br>';
        } else { // end if $isblocked == TRUE       
          echo '<form role="form" action="block.php?member=' . $row["memberid"] .'&community=' . $communityid . '" method="post">';
          echo '<div class="form-group">'; 
          echo '<label for="Reason">Reason</label>'; 
          echo '<input type="text" class="form-control" size="100" name="Reason" id="Reason" placeholder="Block Reason" required>'; 
          echo '</div>';
          echo '<button type="submit">Block</button>';
          echo '</form>';
        } // end if-else $isblocked == TRUE
      } else { // end if $blockid != $memberid
        echo 'You are the community admin!<br>';
      }
      echo '<br>';


    } // end while loop to go through community members






  } else {
    echo 'You have navigated to this page in error!<br>';
  }


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