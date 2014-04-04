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

    <title>Circle | Community</title>
    
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
            	
                <!--USER IS LOGGED IN-->
                <!--<div class="navbar-right">
                	<a href="profile.php">
                  		<img src="images/userDefault.png" alt="Generic placeholder image" width="35" height="35" class="img-circle">
                  	</a>
				  	<a href="profile.php">[User Name]</a>
                </div>-->
                    
                <!--USER IS NOT LOGGED IN-->    
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
            
            
            <h5 align="center"><a href="community.php">Community</a> |  <a href="topic.php">Topic</a> | <a href="product.php">Product</a></h5>
          </div>
        </div>
        </div>
<?php
  if (isset($_SESSION["loggedin"])) {
    echo '<div class="col-md-6" align="center">';
    echo '<a href="addcommunity.php"><button type="button" class="btn btn-primary btn-lg">Add Community</button></a>';
    echo '</div>';
    echo '</div>';
  } // end if user is logged in

  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  $totalcommunities = 0;
  $sql = 'select count(communityid) from community';
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totalcommunities = $row["count(communityid)"]; }

  echo '<div class="row">';
  echo '<div class="col-md-6">';
  echo '<h1>Community</h1>';
  echo '</div>';
  echo '<div class="col-md-6" align="right">';
  echo '</div>';
  echo '</div>';

  if ($totalcommunities > 0) {

    $communityarray = array();
    $sql = 'select communityid from community';
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) { array_push($communityarray,$row["communityid"]); }

    $maxcommunity = count($communityarray);  

    $randomorder = array();
    $index = 0;
    while ($index < $maxcommunity) {
      $rand = rand(0,($maxcommunity-1));
      if (in_array($communityarray[$rand],$randomorder) == FALSE) {
        $index += 1;
        array_push($randomorder,$communityarray[$rand]);
      }
    } // end while loop to generate random order



    echo '<div class="row">';
    echo '<div class="col-md-12"><h3>Explore</h3></div>';
    $communityowners = array();
    $index = 0;
    while ($index < $maxcommunity) {
      $sql = 'select * from community where communityid=' . $randomorder[$index];
      $result = mysqli_query($con,$sql);
      $index += 1;
      foreach ($result as $row) {
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-3">';
        echo '<table align="center">';
        echo '<tr>';
        echo '<td align="center">';
        echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="Generic placeholder image"></a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td align="center">';
        echo $row["name"];
//        echo '<button type="button" class="btn btn-primary btn-xs" id="whenClicked"><span class="glyphicon glyphicon-plus" id="picClicked"></span></button>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
      } // end for loop to display communities
    
    } // end while loop to print community randomly

    echo '</div>';
    echo '</div>';

    echo '<p>&nbsp;</p>';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<hr class="featurette-divider" id="topCommunity">';
    echo '<p>&nbsp;</p>';
    echo '<h3 >Top Communities</h3>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';

    $count = 0;
    $sql = 'select * from community order by rating desc';
    $result = mysqli_query($con,$sql);
    foreach ($result as $row) {        
      $count += 1;

      echo '<div class="col-md-3">';
      echo '<table align="center">';
      echo '<tr>';
      echo '<td rowspan="3" valign="top"><h4>' . $count . '.</h4></td>';
      echo '<td align="center"><a href="viewcommunity.php?id= ' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="150" width="150" alt="Generic placeholder image"></a></td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">';
      echo $row["name"];
//      echo '<a href="php/join.php"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span></button></a>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center"> (' . $row["rating"] . ')</td>';// M=' . $row["nummembers"] . ',T=' . $row["numtopics"] . ',C=' . $row["numcontents"] . '.</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';

    } // end for loop to display top communties

    echo '</div>';


  } else { // end if $totalcommunities > 0
    echo 'There are currently no Communities! Consider creating one!<br>';
  
  } // end if-else $totalcommunities > 0
        


        

  mysqli_close($con);

?>
      
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
    
    <!-- Switches between follow buttons -->
    <script type='text/javascript'>
		$(document).ready(function(){
     		$('#whenClicked').click(function() {
		  		$('#whenClicked').toggleClass('btn-primary btn-success');
		  		$('#picClicked').toggleClass('glyphicon-plus glyphicon-ok');
    		});
		});
</script>
  </body>
</html>