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
      <div class="row">
        <div class="col-md-12">
          	<h1>Add Topic</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">

<?php

  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";
  $date = new DateTime();
  $tstamp = $date->format('Y-m-d H:i:s');
  $communityid = $_GET["id"];

  $validform = TRUE;
  $topicname = '';
  $topicproduct = '';
  $formerrors = '';

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  if (isset($_SESSION["loggedin"])) {
    $memberid = $_SESSION["memberid"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $posttopicname = $_POST["topicname"];
      $postproductid = $_POST["productid"];

      if ((strlen($posttopicname) <= 5) || (is_numeric($posttopicname))) {
        $validform = FALSE;
        $formerrors = $formerrors . 'Topic name must be more than five characters and not numeric!<br>';
        echo 'Length = ' . strlen($posttopicname) . '<br>';
      } else { // end if $posttopicname is invalid
        $topicname = $posttopicname;
      } // end if-else $posttopicname is invalid

      echo $posttopicname . '<br>';
      echo $postproductid . '<br>';

      if ($validform == TRUE) {
        $sql = '';
        if ($postproductid == 0) {
          $sql = "insert into topic(communityid,ownerid,followid,name,created) values ('$communityid','$memberid','0','$topicname','$tstamp')";
        } else { 
          $sql = "insert into topic(communityid,ownerid,followid,productid,name,created) values ('$communityid','$memberid','0','$postproductid','$topicname','$tstamp')";
        }
        mysqli_query($con,$sql);

      } else { // end if $validform == TRUE
        echo 'Form has the following errors:<br>';
        echo $formerrors;
        $formerrors = '';
      } // end if-else $validform == TRUE


    } // end if post message received
  } // end if user is logged in
  echo '<form action="addtopic.php?id=' . $communityid . '" method="post" enctype="multipart/form-data" role="form">';        
  echo '<div class="form-group">'; 
  echo '<label for="topicname">Topic Name</label>'; 
  echo '<input type="text" class="form-control" name="topicname" id="topicname" placeholder="Enter Topic Name" value="' . $topicname . '" required>'; 
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
  echo '</select>';         
  echo '</div>';
// CONSIDER DOUBLE CHECKING THAT THE MEMBER IS PART OF THIS COMMUNITY
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
  echo '<img class="img-circle"  data-src="holder.js/300x300" alt="Generic placeholder image">'; 
  echo '</td>'; 
  echo '</tr>'; 
  echo '</table>'; 
  echo '</div>'; 
  echo '</div>'; 

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