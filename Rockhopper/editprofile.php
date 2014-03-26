<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle  | Edit Profile</title>
    
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
          	<h5 align="center"><a href="profile.php">&laquo; Go back</a>
          </div>
        </div>
      <div class="row">
        <div class="col-md-12">
          	<h1>Edit Profile</h1>
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

  if (isset($_SESSION["loggedin"])) {
    $memberid = $_SESSION["memberid"];
    $validform = TRUE;
    $changeavatar = FALSE;
    $formerrors = "";
    $username = "";
    $city = "";
    $state = "";
    $zip = "";
    $avatarpath = "";
    $deleteavatar = FALSE;
    $oldfile = "";
    $memberpath = 'C:\\wamp\\www\\bzk\\members\\';
    $sql = "select * from member where memberid=" . $memberid;
    $result = mysqli_query($con,$sql);
    foreach($result as $row) { 
      $username = $row['username']; 
      $city = $row["city"];
      $state = $row["state"];
      $zip = $row["zip"];
      $avatarpath = $row["avatarpath"];
    } // end loop to pull memberinformation
    if (preg_match('/members/',$avatarpath)) {
      $deleteavatar = TRUE;
      preg_match('/[0-9]+.[a-zA-Z]+/',$avatarpath,$matches);
      $oldfile = $matches[0];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $postusername = $_POST["username"];
      $postcity = $_POST["city"];
      $poststate = $_POST["state"];
      $postzip = $_POST["zip"];

      if (strlen($postusername) > 0) {
        if ((strlen($postusername) > 30) || (ctype_alnum($postusername) == FALSE)) {
          $validform = FALSE;
          $formerrors = $formerrors . "Username must be alpha numeric and less than thiry characters!<br>";
        } else {
          $username = $postusername;
        }
      } 

      if (strlen($postzip) > 0) {
        if (is_numeric($postzip) == FALSE) {
          $validform = FALSE;
          $formerrors = $formerrors . "Zip must be a numeric value!<br>";
        } else {
          $zip = $postzip;
        }
      }

      if (strlen($poststate) > 0) {
        if ((strlen($poststate) > 2) || (ctype_alpha($poststate) == FALSE)) {
          $validform = FALSE;
          $formerrors = $formerrors . "State must only be two letters!<br>";
        } else {
          $state = $poststate;
        }
      }   
  
      if (strlen($postcity) > 0) {
        if ((strlen($postcity) > 30) || (ctype_alpha($postcity) == FALSE)){
          $valiform = FALSE;
          $formerrors = $formerrors . "City contain only letters and be less than thirty letters!<br>";
        } else {
          $city = $postcity;
        }
      }        

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
          $changeavatar = TRUE;
        } else { // end if file is a supported type
          $validform = FALSE;
          $formerrors = $formerrors . "File must be gif jpg jpeg or png and 200kbytes maximum!<br>";
        } // end if-else is a supported type
      } // end if-else no file attached

      if ($validform == TRUE) {
        echo "Valid form!<br>";
        $sql = "update member set username='" . $username . "',city='" . $city . "',state='" . $state . "',zip='" . $zip . "' where memberid=" . $memberid;
        if ($changeavatar == TRUE) {
          echo "Change Avatar<br>";
          if ($deleteavatar == TRUE) {
            unlink(realpath($memberpath . $oldfile));

          } // end if deleting avatar


          move_uploaded_file($_FILES["file"]["tmp_name"],$memberpath . $memberid . "." . $extension);
          $avatarpath = "/bzk/members/" . $memberid . "." . $extension;
          $sql = "update member set username='" . $username . "',city='" . $city . "',state='" . $state . "',zip='" . $zip . "',avatarpath='" . $avatarpath. "' where memberid=" . $memberid;
          $_SESSION["avatarpath"] = $avatarpath;

        }
        mysqli_query($con,$sql);
        $_SESSION["username"] = $username;

      } else { // end if valid form
        echo "Form has the following Errors:<br>";
        echo $formerrors;
      } // end if-else form valid


    } // end if post message received
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<form action="editprofile.php" method="post" enctype="multipart/form-data" role="form">';
    echo '<div class="form-group">';
    echo '<label for="name">Username</label>';
    echo '<input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" value="' . $username . '">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="city">City</label>';
    echo '<input type="text" class="form-control" name="city" id="city" placeholder="City" value="' . $city . '">';
    echo '</div>';            
    echo '<div class="form-group">';
    echo '<label for="state">State</label>';
    echo '<input type="text" class="form-control" name="state" id="state" placeholder="State" value="' . $state . '">';
    echo '</div>';             
    echo '<div class="form-group">';
    echo '<label for="zip">Zip Code</label>';
    echo '<input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="' . $zip . '">';
    echo '</div>';             
    echo '<div class="form-group">';
    echo '<label for="file">Profile Picture</label>';
    echo '<input type="file" name="file" id="file">';
    echo '<p class="help-block">Submit only GIF JPG JPEG PNG, 200kbytes maximum.</p>';
    echo '</div>';              
    echo '<button type="submit" class="btn btn-default">Submit</button>';
    echo '</form>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<p>&nbsp;</p>';
    echo '<p>&nbsp;</p>';
    echo '<p>&nbsp;</p>';
    echo '<table align="center">';
    echo '<tr>';
    echo '<td>';
    echo '<img class="img-circle"  img src="' . $avatarpath .'" alt="Generic placeholder image">';
    echo '</td>';
    echo '</tr>';  
    echo '</table>';
    echo '</div>';
    echo '</div>';


  } else { // end if user is logged in
    echo "You must be registered and logged in to use this page!<br>";
  } // end if-else user is logged in

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
        <p>&copy; 2014 Circle, Inc. &middot; <a href="privacy.html">Privacy</a> &middot; <a href="terms.html">Terms</a> &middot; <a href="about.html">About</a></p>
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