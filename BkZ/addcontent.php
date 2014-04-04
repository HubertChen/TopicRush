// DONE 04/04/14 10:50 AM
<?php session_start() ; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle  | Add Topic</title>
    
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
              <input type="text" class="form-control" placeholder="Seach for communities, topics, and products" size="70" maxlength="70">
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
          	<h5 align="center"><a href="#">Community</a> |  <a href="#">Topic</a> | <a href="#">Product</a>
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

  $loggedin = FALSE;
  $alreadyjoined = FALSE;
  $validtopicid = FALSE;
  $memberid = 0;
  $communityid = 0;
  $topicid = $_GET["id"];
  $formerrors = "";
  $extension = "";
  date_default_timezone_set('EST');
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');

  if (isset($_SESSION["loggedin"])) {
    $loggedin = TRUE;
    $memberid = $_SESSION["memberid"];
    $sql = 'select communityid from topic where topicid=' . $topicid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
      $validtopicid = TRUE;
      $communityid = $row["communityid"];
    } // end while loop to determine if topicid is valid
    $sql = "select memberid,communityid from joins where memberid='" . $memberid . "' and communityid='" . $communityid . "'";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { 
      $alreadyjoined = TRUE;
    } // end while loop to verify member has joined the community   
  } // 

  if (($alreadyjoined == TRUE) && ($validtopicid == TRUE)) {
    $message = '';
    $picturedescription = '';

    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h1>Add Content</h1>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<form action="addcontent.php?id=' . $topicid . '" method="post" enctype="multipart/form-data" role="form">';            
    echo '<div class="form-group">';
    echo '<label for="topicname">Message</label>';
    echo '<input type="text" class="form-control" name="message" id="message" value="' . $message . '" placeholder="Message" required>';
    echo '</div>';              
    echo '<div class="form-group">';
    echo '<label for="product">Link a Product</label>';
    echo '<select name="productid" class="form-control">'; 
    echo '<option value="0">None</option>';
    $sql = 'select productid,name from product';
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
      echo '<option value="'.$row['productid'].'"';
      echo '>'. $row['name'] . '</option>'."\n";
    } 
    echo '<select class="form-control">';
    echo '<option value="">Products</option>';
    echo '</select>';                
    echo '</div>';              
    echo '<div class="form-group">';
    echo '<label for="file">Picture</label>';
    echo '<input type="file" name="file" id="file">';
    echo '<p class="help-block">Must be .gif .jpg .jpeg or .png and less than 200kbytes.</p>';
    echo '</div>';              
    echo '<div class="form-group">';
    echo '<label for="retailprice">Picture Description</label>';
    echo '<textarea class="form-control" rows="3" name="description" id="description" value="' . $picturedescription . '" placeholder="Picture Description"></textarea>';
    echo '</div>';              
    echo '<button type="submit" class="btn btn-default">Add</button>';
    echo '</form>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<p>&nbsp;</p>';
    echo '<p>&nbsp;</p>';
    echo '<p>&nbsp;</p>';
    echo '<table align="center">';
    echo '<tr>';
    echo '<td>';
    $sql = 'select path from community where communityid=' . $communityid;
    $result = mysqli_query($con,$sql);
    $communitypath = '';
    foreach ($result as $row) { $communitypath = $row["path"]; }
    echo '<img class="img-circle" src="' . $communitypath , '" width="300" height="300" alt="Generic placeholder image">';
    echo '</td>';
    echo '</tr>'; 
    echo '</table>';
    echo '</div>';
    echo '</div>';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $validform = TRUE;
      $hasfile = FALSE;
      $extension = '';
      $postmessage = $_POST["message"];
      $postpicturedescription = $_POST["description"];
     
      if ((strlen($postmessage) <= 4) || (is_numeric($postmessage) == TRUE)){
        $validform = FALSE;
        $formerrors = $formerrors . 'Message but be atleast five characters and not numeric!<br>';
      } else {
        $message = $postmessage;
      }


      if ($_FILES["file"]["error"] > 0) {

      } else { // end if no file attached
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>";
        $allowedimagetype = array("gif","jpeg","jpg","png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        echo "Extension type = " . $extension . "<br>";
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 204800)
        && in_array($extension, $allowedimagetype)) {
          $hasfile = TRUE;
        } else { // end if file is a supported type
          $validform = FALSE;
          $formerrors = $formerrors . "File must be gif jpg jpeg or png!<br>";
        } // end if-else is a supported type
      } // end if-else no file attached

      if ($hasfile == TRUE) {
        if ((strlen($postpicturedescription) <= 4) || (is_numeric($postpicturedescription) == TRUE)) {
          $validform = FALSE;
          $formerrors = $formerrors . 'File description must be atleast five characters and not numeric!<br>';
        } else {
          $picturedescription = $postpicturedescription;
        }
      } // end if $hasfile == TRUE to validate picture description

      if ($validform == FALSE) {
        echo 'The form has the following errors<br>';
        echo $formerrors;
      } else { // end if $validform == FALSE
// PROCESS THE FORM HERE
        $postproductid = $_POST["productid"];
        $sql = '';
        if ($postproductid == 0) {
          $sql="insert into content(topicid,ownerid,message,created) values('" . $topicid . "','" . $memberid . "','" . $message . "','" . $tstamp . "')";
        } else {
          $sql="insert into content(topicid,ownerid,message,productid,created) values('" . $topicid . "','" . $memberid . "','" . $message . "','" . $postproductid . "','" . $tstamp . "')";
        }
        mysqli_query($con,$sql);

        if ($hasfile == TRUE) {
          echo 'Processing File<br>';
          $contentid = 0;
          $sql="select contentid from content where message='" . $message . "' and created='" . $tstamp . "'";
          $result = mysqli_query($con,$sql);
          foreach ($result as $row) { $contentid = $row["contentid"]; }
          $topicpath = "C:\\wamp\\www\\bzk\\topics\\";
          move_uploaded_file($_FILES["file"]["tmp_name"],$topicpath . "\\" . $contentid . "." . $extension);
          $filepath = "/bzk/topics/" . $contentid . "." . $extension;
          $sql = "update content set path='" . $filepath . "',type='1',description='" . $picturedescription . "' where contentid='" . $contentid . "'";
          mysqli_query($con,$sql);


        } // end if $hasfile == TRUE

      } // end if-else $validform == FALSE

    } // end if post message received


  } else { // end if validtopic and user is community member
    echo 'You have navigated to this page in error!<br>';
  } // end if else validtopic and user is community member

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
  </body>
</html>