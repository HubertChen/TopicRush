<!-- DONE: 4/11/14 -->
<?php session_start(); ?>

<!--<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle | Follow</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <link href="css/styles.css" rel="stylesheet">
  </head>
  
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">   
      <div class="container">
        <div class="navbar-header">
        
        
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
        <div class="navbar-collapse collapse" align="center">  
          <form class="navbar-form navbar-form-length"  role="search" action="search.php" method="post">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70" required>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>-->

<?php               
  /*if (isset($_SESSION["loggedin"])) {
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
	*/
?>         	
<!--
          </form>  
        </div>
      </div>
    </div>

    
    
    
    <div class="container">
    	 <p>&nbsp;</p>
      	<p>&nbsp;</p>
      
		<div class="row">
          <div class="col-md-12">
          	&nbsp;
          </div>
        </div>
-->
<?php

	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "";
  	$dbname = "Circle";

  	//Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
		include 'viewtopic.php';
		exit();	
  	} 
  	
	$topicid = $_GET["id"];
  	$communityid = 0;
  	$memberid = 0;
  	$communitylogo = '';
  	$topicname = '';
  	$topiccommunityid = 0;

  	$loggedin = FALSE;
  	$communitymember = FALSE;
  	$memberjoined = FALSE;
  	$memberfollows = FALSE;
  	$validtopicid = FALSE;

  	if (isset($_SESSION["loggedin"])) { 
   		$loggedin = TRUE;
    	$memberid = $_SESSION["memberid"];
  	}

  	$sql = 'select * from topic where topicid=' . $topicid;
  	$result = mysqli_query($con,$sql);
  	while($row = mysqli_fetch_array($result)) { 
    	$topiccommunityid = $row["communityid"];
    	$topicname = $row["name"];
    	$validtopicid = TRUE;
  	}

  	if ($validtopicid == TRUE) {

    	$sql = 'select communityid from topic where topicid=' . $topicid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $communityid = $row["communityid"]; }
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
 
    	$communitylogo = '';
    	$sql = 'select path from community where communityid=' . $topiccommunityid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { $communitylogo = $row["path"]; }

    	if ($memberfollows == FALSE) {
      		/*echo '<div class="row">';
     	 	echo '<div class="col-md-3">';
      		echo '<table align="center">';
      		echo '<tr>';
      		echo '<td align="center">';
      		echo '<a href="viewcommunity.php?id=' . $topiccommunityid . '"><img class="img-circle"  img src="' . $communitylogo . '" height="150" width="150" alt="Generic placeholder image"></a>';
      echo '</td>';
      echo '</tr>';
      echo '</div>';
      echo '</div>';
      echo '<h1>';
      echo $topicname;
      echo '</h1>';
      echo 'You are now following this topic!<br>';*/
	  
	  $errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Successfully following topic!
							</div>';
      $sql = "insert into follows(memberid,topicid) values('" . $memberid . "','" . $topicid . "')";
      mysqli_query($con,$sql);
	  include 'viewtopic.php';
		exit();
    } else { // end if $memberfollows == FALSE
      $errorMessage = '<div class="alert alert-info alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							You are already following this topic!
							</div>';
			include 'viewtopic.php';
			exit();;
    }

  } else { // end if $validtopic == TRUE
    $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Community does not exist!
							</div>';
			include 'viewtopic.php';
			exit();		
  }

  mysqli_close($con);

?>
