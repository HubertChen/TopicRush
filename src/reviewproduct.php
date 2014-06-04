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

    <title>Circle | Review</title>
    
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
  //navbar: user is logged in           
  	if (isset($_SESSION["loggedin"])) {
    	$navbar = '<a href="signout.php"><button type="button" class="btn btn-signin navbar-btn-right btn-sm" >Sign Out</button></a>
					<div class="navbar-right">
						<a href="profile.php">
							<img src="'. $_SESSION["avatarpath"] . '" alt="User Profile Image" width="35" height="35" class="img-circle">
						</a>
						<a href="profile.php">' . $_SESSION["username"] . '</a>
					</div>';
	
	} else { // end if user is logged in
    	$navbar ='<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
					<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>';
  	} // end if-else user is logged in

   /*         	

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
*/
  
  
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
	
		include 'reviewproduct.html.php';
		exit(); 
  	} 
  
	if (isset($_SESSION["loggedin"])) {
	
 		$memberid = $_SESSION["memberid"];
    	$productid = 0;
    	if (isset($_GET["id"])) { $productid = $_GET["id"]; }
    	$alreadyreviewed = FALSE; 
    	$productname = '';
    	$ownerid = '';
    	$ownername = '';
    	$description = '';
    	$ratingpoints = 0;
    	$numreviews = 0;
    	$rating = 0;
    	$listedprice = '';
    	$categoryid = 0;
    	$categoryname = '';
    	$imagepath = '';
    	date_default_timezone_set('EST');
    	$date = new DateTime();
    	$tstamp = $date->format('Y-m-d H:i:s');
    	$validproductid = FALSE;

        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';
        $file = fopen($filterfile,"r");
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) { array_push($filterlist,$input); }
        }
        $filtersize = count($filterlist);

    	$sql = 'select name from product where productid=' . $productid;
    	$result = mysqli_query($con,$sql);
    	while($row = mysqli_fetch_array($result)) { 
      		$validproductid = TRUE;
    	}

    	if ($validproductid == TRUE) {

    		$sql = 'select * from review where productid=' . $productid . ' and memberid=' . $memberid;
      		$result = mysqli_query($con,$sql);
      		$found = 0;
      		
			while($row = mysqli_fetch_array($result)) { 
        		$found += 1; 
      		}
      	
		if ($found > 0) { $alreadyreviewed = TRUE; } // else ( $alreadyreviewed = FALSE; }
      	$sql = 'select * from product where productid=' . $productid;
      	$result = mysqli_query($con,$sql);
      	while($row = mysqli_fetch_array($result)) {
      		$productname = $row["name"];
        	$ownerid = $row["ownerid"];
        	$description = $row["description"];
        	$ratingpoints = $row["rating"];
        	$numreviews = $row["numreviews"];
        	$listedprice = $row["listedprice"];
        	$categoryid = $row["category"];
      	} // end for loop to get product information

      	if ($numreviews > 0) { $rating = $ratingpoints / $numreviews; }

      	$sql = 'select name from category where categoryid=' . $categoryid;
      	$result = mysqli_query($con,$sql);
      	while($row = mysqli_fetch_array($result)) { $categoryname = $row["name"]; }

      	$sql = 'select username from member where memberid=' . $ownerid;
      	$result = mysqli_query($con,$sql);
      	while($row = mysqli_fetch_array($result)) { $ownername = $row["username"]; }

      	$numrecords = 0;
      	$sql2 = 'select path from productdetail where productid=' . $productid;
      	$result2 = mysqli_query($con,$sql2);
      	while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
        	$numrecords += 1;
        	$imagepath = $imagepath . $row2["path"];
      	}
/*
      	echo '<div class="row">';
      	echo '<div class="col-md-3">';
      	echo '<table align="center">';
      	echo '<tr>';
      	echo '<td align="center"><img class="img-circle"  img src="' . $imagepath . '" width="300"  height="300" alt="Generic placeholder image"></td>';
      	echo '</tr>';
      	echo '<tr>';
      echo '<td align="center">';
      $stars = 0;
      $rating = round($rating,1);
      while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
        echo '<span class="glyphicon glyphicon-star"></span>';
        $stars += 1;
      }
      echo '(' . $rating . ')';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<h6>Listed Price: ' . $listedprice . '</h6>';
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '<div class="col-md-9">';
      echo '<table>';
      echo '<tr>';
      echo '<td>';
      echo '<h1>' . $productname . '</h1>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<h4><em>Owner : ' . $ownername . '</em></h4>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<h6>Category : ' . $categoryname . '</h6>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<p>Description : ' . $description . '</p>';
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '</div>';
      echo '<hr class="featurette-divider">';
  */   
		if ($alreadyreviewed == FALSE) {
		  /*
			echo '<div class="row">';
      		echo '<div class="col-md-12">';
        	echo '<h4>Write Review</h4>';
        	echo '</div>';
        	echo '</div>';
        	echo '<div class="row">';
        	echo '<div class="col-md-1">';
        	echo '<form action="reviewproduct.php?id=' . $productid . '" method="post" role="form">';
        	echo '<div class="form-group">';
        	echo '<label for="rating">Rating</label>';
        	echo '<select class="form-control" name="rating" id="rating">';
        	echo '<option value="0">0</option>';
        	echo '<option value="1">1</option>';
        	echo '<option value="2">2</option>';
        	echo '<option value="3">3</option>';
        	echo '<option value="4">4</option>';
        	echo '<option value="5">5</option>';
        	echo '</select>';
        	echo '</div>';
        	echo '</div>';
        	echo '<div class="col-md-7">';
        	echo '<div class="form-group">';
        	echo '<label for="ratedescript">Description</label>';
        	echo '<textarea class="form-control" rows="3" name="ratedescript" id="ratedescript" placeholder="Descriptions" required></textarea>';
        	echo '</div>';
        	echo '</div>';
        	echo '</div>';
        	echo '<div class="row">';
        	echo '<div class="col-md-8" align="right">';
			*/
        	if (($ownerid != $memberid) && ($alreadyreviewed == FALSE)) {
          		$button = '<button type="submit" class="btn btn-primary pull-right">Review</button>';
        	}
			
			
      	} else { // end if $alreadyreviewed == FALSE
        	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						You have already reviewed this product!
						</div>';
			$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Review</button>';			
	
			//include 'viewproduct.html.php';
      	}
      	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
        	$validform = TRUE;
        	$formerrors = '';
        	$postrating = $_POST["rating"];
        	$postdescription = $_POST["ratedescript"];
 			//echo $postrating . "<br>" . $postdescription . "<br>";
        	if ($postrating == 0) {
          		$validform = FALSE;
          		$formerrors = $formerrors . "Rating must be between 1 and 5!<br>";
        	}
        	if ((strlen($postdescription) < 20) || is_numeric($postdescription)) {
          		$validform = FALSE;
          		$formerrors = $formerrors . "Description must be twenty or more characters, please try again!<br>";
        	}

      $valid = TRUE;
      if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postdescription) == TRUE) {
        $valid = FALSE;
        $validform = FALSE;
        $formerrors = $formerrors . 'Invalid input, please try again!<br>';
      }
      if ($valid == TRUE) {
        $index = 0;
        $found = FALSE;
        while (($index < $filtersize) && ($valid == TRUE)) {
          $pattern = '/' . $filterlist[$index] . '/i';
          if (preg_match($pattern,$postdescription) == TRUE) {
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
          } // end if input matches filter word
          $index += 1;
        } // end while loop to loop through each filter word
      } // end if $valid == TRUE



        	if ($validform == TRUE) {
                        $postdescription = mysqli_real_escape_string($con,$postdescription);
          		$sql="insert into review(memberid,productid,reviewdetails,rating,reviewdate) values ('$memberid','$productid','$postdescription','$postrating','$tstamp')";
          mysqli_query($con,$sql);
          		$postdescription = '';
          		$postrating = 0;
        		
				$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Product successfully reviewed!
							</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Review</button>';
			
			} else { // end if $validform == TRUE
				$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									' . $formerrors. '
								</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right">Review</button>';
				        		
				
				$formerrors = '';
       	 	} // end if-else $valiform == TRUE
      	}
  	} else { // end if $validproductid == TRUE
   $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Invalid product, please try again!
						</div>';
			$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Review</button>';
  } // end if-else $validproductid == TRUE
      
  
	include 'reviewproduct.html.php';
	exit();
  } else { // end if user is logged in
    $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						You must be logged in to review this product!
						</div>';
	$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Review</button>';
	
	include 'reviewproduct.html.php';
  	exit();
  }
  mysqli_close($con);
?>
  
