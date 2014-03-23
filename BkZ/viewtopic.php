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

    <title>Circle | [Topic Name]</title>
    
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
  $topicid = $_GET["id"];
  $communityid = 0;
  $memberid = 0;
  $numposts = 0;
  $communitylogo = '';
  $topicownerid = 0;
  $topicownername = '';
  $topicname = '';
  $topiccreated = '';
  $topicproduct = 0;

  $loggedin = FALSE;
  $communitymember = FALSE;
  $memberjoined = FALSE;
  $memberfollows = FALSE;
  if (isset($_SESSION["loggedin"])) { 
    $loggedin = TRUE;
    $memberid = $_SESSION["memberid"];
  }
  $sql = 'select communityid from topic where topicid=' . $topicid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $communityid = $row["communityid"]; }
  if ($loggedin == TRUE) {
    $sql = 'select * from joins where memberid=' . $memberid . ' and communityid=' . $communityid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $memberjoined = TRUE; }    
    $sql = 'select * from follows where memberid=' . $memberid . ' and topicid=' . $topicid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $memberfollows = TRUE; }
  }

  $sql = 'select path from community where communityid=' . $communityid;
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) {  $communitylogo = $row["path"]; }

  $sql = 'select count(topicid) from content where topicid=' . $topicid;
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) { $numposts = $row["count(topicid)"]; }

  $sql = 'select * from topic where topicid=' . $topicid;
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) { 
    $topicownerid = $row["ownerid"]; 
    $topicproductid = $row["productid"];
    $topicname = $row["name"];
    $topiccreated = $row["created"];
  }

  $sql = 'select username from member where memberid=' . $topicownerid;
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $topicownername = $row["username"]; }

  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '<table align="center">';
  echo '<tr>';
  echo '<td align="center"><img class="img-circle"  img src="' . $communitylogo . '" width="150" height="150" alt="Generic placeholder image"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td align="center">';
  echo $numposts . ' Responses';
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
  echo $topicname;
  if ($loggedin == TRUE) {
    if ($memberfollows == TRUE) {
      echo '<a href="php/unfollow.php?id=' . $topicid . '"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-minus"></span></button></a>';
    } else {
      echo '<a href="php/follow.php?id=' . $topicid . '"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></button></a>';
    }
  } // end if $loggedin == TRUE
  echo '</h1>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo '<p>Created:' . $topiccreated . ' by ' . $topicownername . '</p><br>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</div>';
  echo '</div>';
  echo '&nbsp;';
  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '</div>';
  echo '<div class="col-lg-9">';
  echo '<ul class="media-list">';
  echo '<li class="media">';
  echo '<a class="pull-left" href="#">';
  echo '<img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="#" style="width: 64px; height: 64px;">';
  echo '</a>';
  echo '<div class="media-body">';
  if ($memberjoined == TRUE) {
    echo '<h4 class="media-heading">Add Comment <a href="#"> <button type="button" class="btn btn-primary btn-xs">comment</button></a></h4>';
  }

  $numtopiccontent = 0;
  $sql = 'select count(contentid) from content where topicid=' . $topicid;
  $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($result)) { $numtopiccontent = $row["count(contentid)"]; }

  if ($numtopiccontent > 0) {
    $sql = 'select * from content where topicid=' . $topicid;
    $result = mysqli_query($con,$sql);
    echo '<br>';
    foreach ($result as $row) {
      $contentownername = '';
      $sql2 = 'select username from member where memberid=' . $row["ownerid"];
      $result2 = mysqli_query($con,$sql2);
      foreach ($result2 as $row2) { $contentownername = $row2["username"]; }
      echo '     ' . $row["message"] . '<br>';
      echo '          added: ' . $row["created"] . ' by ' . $contentownername . '.<br>';
      if ($row["type"] == 1) { 
        echo '<img class="img-circle" img src="' . $row["path"] . '" width="100" height="100" alt="Generic placeholder image">';
        echo $row["description"] . '<br>';
      }
    } // end for loop to print content
  } // end if $numtopiccontent > 0

  echo '</div>';
  echo '</li>';
  echo '</ul>';
  echo '</div>';
  echo '</div>';
  echo '<hr class="featurette-divider">';


  mysqli_close($con);

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