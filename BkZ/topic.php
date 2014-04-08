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

    <title>Circle | Topic</title>
    
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
      <div class="row">
        <div class="col-md-6">
          	<h1>Topic</h1>
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

  $totaltopics = 0;
  $sql = 'select count(topicid) from topic';
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totaltopics = $row["count(topicid)"]; }

  if ($totaltopics > 0) {

    $topicarray = array();
    $sql = 'select topicid from topic';
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) { array_push($topicarray,$row["topicid"]); }


    $maxtopics = count($topicarray);  

    $randomorder = array();
    $index = 0;
    while ($index < $maxtopics) {
      $rand = rand(0,($maxtopics-1));
      if (in_array($topicarray[$rand],$randomorder) == FALSE) {
        $index += 1;
        array_push($randomorder,$topicarray[$rand]);
      }
    } // end while loop to generate random order

    echo '<div class="col-md-6" align="right">';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-12"><h3>Explore</h3></div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    $maxdisplay = 0;
    if ($totaltopics > 5) {
      $maxdisplay = 5;
    } else {
      $maxdisplay = $totaltopics;
    }
    $index = 0;
    while ($index < $maxdisplay) {
      $sql = 'select * from topic where topicid=' . $randomorder[$index];
      $result = mysqli_query($con,$sql);
      $index += 1;
      $topicownerid = 0;
      $topicownername = '';
      foreach ($result as $row) {
        $topicownerid = $row["ownerid"];
        $topicavatarpath = '';
        $sql2 = 'select username,avatarpath from member where memberid=' . $topicownerid;
        $result2 = mysqli_query($con,$sql2);
        foreach ($result2 as $row2) { 
          $topicownername = $row2["username"]; 
          $topicavatarpath = $row2["avatarpath"];
        }
        echo '&nbsp;';
        echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo '<div class="media">';
        echo '<a class="pull-left" href="viewtopic.php?id=' . $row["topicid"] . '">';
        echo '<img class="img-circle" img src="' . $topicavatarpath . '" width="64" height="64" alt="Generic placeholder image">';
        echo '</a>';
        echo '<div class="media-body">';
        echo '<h4 class="media-heading">' . $row["name"] . '</h4>';
        echo '<p>Created:' . $row["created"] . ' by ' . $topicownername . '</p><br>';
        echo '</div>';
        echo '</div>';      
        echo '</div>';
        echo '</div>';
        echo '</div>';
      } // end for loop to individual topic
    } // end while loop to dispay top topics
    echo '</div>';
    echo '</div>';



    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<hr class="featurette-divider" id="topTopic">';
    echo '<h3 >Top Topics</h3>';
    echo '</div>';
    echo '</div>';

    $sql = 'select topicid from topic';
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) { 
      $sql2 = 'select count(contentid) from content where topicid=' . $row["topicid"];
      $result2 = mysqli_query($con,$sql2);
      foreach ($result2 as $row2) { $data[] = array("topic" => $row["topicid"], "content" => $row2["count(contentid)"]); }
    }

    foreach ($data as $key => $row) {
      $topic[$key] = $row['topic'];
      $content[$key] = $row['content'];
    }

    array_multisort($content,SORT_DESC,$data);

    $toptopics = array();

    foreach ($data as $row) {
      array_push($toptopics,$row['topic']);
    }

    echo '&nbsp;';
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<table>';

    $index = 0;
    while ($index < $maxdisplay) {
      $sql = 'select * from topic where topicid=' . $toptopics[$index];
      $result = mysqli_query($con,$sql);
      $index += 1;
      foreach ($result as $row) {
        $topicownerid = $row["ownerid"];
        $topicownervatarpath = '';
        $sql2 = 'select username,avatarpath from member where memberid=' . $topicownerid;
        $result2 = mysqli_query($con,$sql2);
        foreach ($result2 as $row2) { 
          $topicownername = $row2["username"]; 
          $topicowneravatarpath = $row2["avatarpath"];
        }
        echo '<tr>';
        echo '<td valign="top"><h4>' . $index . '.</h4></td>';
        echo '<td>';
        echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo '<div class="media">';
        echo '<a class="pull-left" href="viewtopic.php?id=' . $row["topicid"] . '">';
        echo '<img class="img-circle" img src="' . $topicowneravatarpath . '" width="64" height="64" alt="Generic placeholder image">';
        echo '</a>';
        echo '<div class="media-body">';
        echo '<h4 class="media-heading">' . $row["name"] . '</h4>';
        echo '<p>Created:' . $row["created"] . ' by ' . $topicownername . '</p><br>';
        echo '</div>';
        echo '</div>';     
        echo '</div>';
        echo '</div>';
        echo '&nbsp;';
        echo '</td>';
        echo '</tr>';
      } // end for loop to display individual top topic
    } // end while loop to display top topics

    echo '</table>';
    echo '</div>';
    echo '</div><!-- /END THE FEATURETTES -->';

  } // end if $totaltopics > 0

  mysqli_close($con);

?>

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
        <p class="pull-right"><a href="#top">Back to top</a></p>
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