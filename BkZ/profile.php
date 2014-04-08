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

    <title>Circle | User Profile</title>
    
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
    


<?php
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  if (isset($_SESSION["loggedin"])) {
    $memberid = $_SESSION["memberid"];
    $sql = 'select * from member where memberid=' . $memberid;
    $result = mysqli_query($con,$sql);

    foreach ($result as $row) {
      $userrole = '';
      if ($row["role"] == 'u') { $userrole = 'User'; } else
        if ($row["role"] == 's') { $userrole = 'Seller'; } else 
          if ($row["role"] == 'a') { $userrole = 'Admin';}
      

      echo '<div class="container">';
      echo '<p>&nbsp;</p>';
      echo '<p>&nbsp;</p>';
      echo '<div class="row">';
      echo '<div class="col-md-12">';
      echo '&nbsp;';
      echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-md-3">';
      echo '<table align="center">';
      echo '<tr>';
      echo '<td align="center"><img class="img-circle"  src="' . $row["avatarpath"] . '" width="150" height="150" alt="Generic placeholder image"></td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">' . $userrole . '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center">';
      echo $row["city"] . ',' . $row["state"];
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '<div class="col-md-9">';
      echo '<table width="100%">';
      echo '<tr>';
      echo '<td colspan="2">';
      echo '&nbsp;';
      echo '<h1>';
      echo $row["username"];
      echo '<a href="editprofile.php"><button type="button" class="btn btn-primary btn-sm">Edit Profile</button></a>';
      echo '</h1>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<h3><em>' . $row["email"] . '</em></h3>';
      echo '</td>';
      echo '<td>';
      echo '<h3></h3>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo 'Joined : ' . $row["joindate"];
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo 'Last Login : ' . $row["lastlogin"];
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '</div><!-- /row -->';
      echo '</div>';
    } // end for loop to print user information
   
    $totalcommunity = 0;
    $totaltopic = 0;
    $totalproduct = 0;

    $sql = 'select count(memberid) from joins where memberid=' . $memberid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $totalcommunity = $row["count(memberid)"]; }

    $sql = 'select count(memberid) from follows where memberid=' . $memberid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $totaltopic = $row["count(memberid)"]; }

    $sql = 'select count(ownerid) from product where ownerid=' . $memberid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { $totalproduct = $row["count(ownerid)"]; }


    echo '&nbsp;';
    echo '<div class="row">';
    echo '<div class="container marketing">';
    echo '<div class="row">';
    echo '<div class="col-lg-4">';
    echo '<h3>Joined Communities</h3>';
    if ($totalcommunity > 0) {
      echo '<table align="center">';
      $sql = 'select communityid from joins where memberid=' . $memberid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) {
        $sql2 = 'select name,path from community where communityid=' . $row["communityid"];
        $result2 = mysqli_query($con,$sql2);
        foreach ($result2 as $row2) {
          echo '<tr>';
          echo '<td class="table-top-product-padding" rowspan="2"></td>';
          echo '<td class="text-left table-top-product-padding" rowspan="2">';
          echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  src="' . $row2["path"] . '" width="90" height="90" alt="Generic placeholder image"></a>';
          echo '</td>';
          echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >';
          echo $row2["name"];
          echo '</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td class="table-top-product-stars" align="left" valign="top">';
          echo '</td>';
          echo '</tr>';
        } // end per community loop
      } // end loop to obtain communityid member has joined
      echo '</table>';           
      echo '</div><!-- /.col-lg-4 -->';
//      echo '</div>';
    } else { // end if $totalcommunity > 0
      echo 'You have not joined any communities, get involved!<br>';
    } // end if-else $totalcommunity > 0
    echo '<!--Topic Head -->';
    echo '<div class="col-lg-4">';
    echo '<h3>Followed Topics</h3>';
    if ($totaltopic > 0) {
      echo '<table class="table-top" align="center">';
      $sql = 'select topicid from follows where memberid=' . $memberid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) {
        $sql2 = 'select name from topic where topicid=' . $row["topicid"];
        $result2 = mysqli_query($con,$sql2);
        foreach ($result2 as $row2) {
          $newcontent = FALSE;
          $newmessage = '';
          $sql3 = 'select created,message from content where topicid=' . $row["topicid"];
          $result3 = mysqli_query($con,$sql3);
          while($row3 = mysqli_fetch_array($result3)) {
            if ($row3["created"] > $_SESSION["lastlogin"]) { 
              $newcontent = TRUE;
              $newmessage = $newmessage . $row3["message"] . '<br>';
            } // end if new message posted after lastlogin
          }
          echo '<tr>';
          echo '<td class="text-left"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row2["name"] . '</a></td>';
          if ($newcontent == TRUE) {
            echo '<td><font color="red">New</font></td><td>' . $newmessage . '</td>';
          }
          echo '</tr>';
        } // end for loop per individual topic
      } // end for loop to get topicid from follows


      echo '</table>';
      echo '</div><!-- /.col-lg-4 -->';
    } else { // end it $totaltopic > 0
      echo 'You are not following any topics, get involved!<br>';
    } // end if-else $totaltopics > 0

    if ($userrole == 'Seller') {

      echo '<!--Product Head -->';
      echo '<div class="col-lg-4">';
      echo '<h3>Owned Products</h3>';

      if ($totalproduct > 0) {
        echo '<table align="center">';

        $sql = 'select * from product where ownerid=' . $memberid;
        $result = mysqli_query($con,$sql);
        foreach ($result as $row) {
          $productimagepath = '';
          $found = 0;
          $sql2 = 'select path from productdetail where productid=' . $row["productid"];
          $result2 = mysqli_query($con,$sql2);
          while(($row2 = mysqli_fetch_array($result2)) && ($found == 0)) {
            $found += 1;
            $productimagepath = $row2["path"];
          }
          echo '<tr>';
          echo '<td class="table-top-product-padding" rowspan="2"></td>';
          echo '<td class="text-left table-top-product-padding" rowspan="2">';
          echo '<a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  src="' . $productimagepath . '" width="90" height="90" alt="Generic placeholder image"></a>';
          echo '</td>';
          echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >' . $row["name"] . '</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td class="table-top-product-stars" align="left" valign="top">';

          $rating = 0;
          if ($row["numreviews"] != 0) {
            $rating = $row["rating"] / $row["numreviews"];
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
        } // end for loop to dispay products

      } else { // end if $totalproducts > 0
        echo 'You do not own any products!<br>';
      } // end if-else $totalproducts > 0
  
    } // end if userrole = 'Seller'
 
    echo '</table>';
    echo '</div><!-- /.col-lg-4 -->';
    echo '</div><!-- /.row -->';

  } else { // end if user is logged in
    echo 'You have navigated to this page in error and must be logged in!<br>';
  } // end if-else user is logged in

  mysqli_Close($con);

?>

                &nbsp;
            </div>
        </div>
    	<hr class="featurette-divider">


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