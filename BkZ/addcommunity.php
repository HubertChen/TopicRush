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

    <title>Circle  | Add Community</title>
    
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
          	<h5 align="center"><a href="community.php">Community</a> |  <a href="topic.php">Topic</a> | <a href="product.php">Product</a>
          </div>
        </div>
      <div class="row">
        <div class="col-md-12">
          	<h1>Add Community</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
        <p>&nbsp;</p>

<?php
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  if (isset($_SESSION["loggedin"])) {
    $memberid = $_SESSION["memberid"];
    $validform = TRUE;
    $formerrors = '';
    $postcommunityname = '';
    $communityname = '';
    $communityid = 0;
    $communitypath = 'C:\\wamp\\www\\bzk\\community\\';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $postcommunityname = $_POST["communityname"];
      if ((strlen($postcommunityname) < 3) || (strlen($postcommunityname) > 30)) {
        $validform = FALSE;
        $formerrors = $formerrors . "Community name must be between three and thirty characters!<br>";
      } else { // if post community name is invalid
        $found = FALSE;
        $sql = "select communityid from community where name='" . $postcommunityname . "'";
        $result = mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($result)) { $found = TRUE; }
        if ($found == TRUE) {
          $validform = FALSE;
          $formerrors = $formerrors . $postcommunityname . " community already exists!<br>";
        } else { // end if community already exists
          $communityname = $postcommunityname;
        } // end if-else community already exists
      } // end if-else post community name is invalid       

      if ($_FILES["file"]["error"] > 0) {
        $valdiform = FALSE;
        $formerrors = $formerrors . "No file provided or invalid type!<br>";
      } else { // end if no file attached
        $allowedimagetype = array("gif","jpeg","jpg","png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 204800)
        && in_array($extension, $allowedimagetype)) {

        } else { // end if file is a supported type
          $validform = FALSE;
          $formerrors = $formerrors . "File must be gif jpg jpeg or png and 200kbytes maximum!<br>";
        } // end if-else is a supported type
      } // end if-else no file attached

      if ($validform == TRUE) {
        echo "Valid form!<br>";
        $sql="insert into community(ownerid,name,created,nummembers,numtopics,numcontents,rating) values ('$memberid','$communityname','$tstamp','0','0','0','0')";
        mysqli_query($con,$sql);
        $sql = "select communityid from community where name='" . $communityname . "'";
        $result = mysqli_query($con,$sql);
        foreach ($result as $row) { $communityid = $row["communityid"]; }
        $imagepath = '/bzk/community/' . $communityid . '.' . $extension;
        move_uploaded_file($_FILES["file"]["tmp_name"],$communitypath . $communityid . "." . $extension);
        $sql = 'update community set path=' . $imagepath . ' where communityid=' . $communityid;
        $result = mysqli_query($con,$sql);
      } else { // end if valid form
        echo "Form has the following Errors:<br>";
        echo $formerrors;
      } // end if-else form valid

    } // end if post message received



    echo '<form action="addcommunity.php" method="post" enctype="multipart/form-data" role="form">';
    echo '<div class="form-group">';
    echo '<label for="communityname">Name</label>';
    echo '<input type="text" class="form-control" name="communityname" id="communityname" placeholder="Enter name" value="' . $communityname . '" required>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="file">Picture</label>';
    echo '<input type="file" name="file" id="file" required>';
    echo '<p class="help-block">Submit only GIF JPG JPEG PNG, 200kbytes maximum.</p>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-default">Create Community</button>';
  } else { // end if user is logged in
    echo 'You must be registered and logged in to use this page!<br>';
  } // end if-else user is logged in

  mysqli_close($con);

?>


            </form>
        </div>
        <div class="col-md-6">

          	<table align="center">
            	<tr>
                	<td>
           			  <img class="img-circle"  data-src="holder.js/300x300" alt="Generic placeholder image">
            		</td>
              </tr>    
          </table>
        </div>
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