<?php session_start(); ?>

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
  	} 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	
	<!-- Need to add necessary meta tags -->
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
  ================================================== -->
  <body style="background-color:#7aadd9">
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
			<?php echo $navbar; ?>

          </form>  
        </div>
      </div>
    </div>

    <div class="container" style="background-color:rgb(255, 255, 255)">
   		<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php if (isset($errorMessage)) { echo $errorMessage; } ?>

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


<?php

	if (isset($_SESSION["loggedin"])) {
    	$memberid = $_SESSION["memberid"];
    	$sql = 'select * from member where memberid=' . $memberid;
    	$result = mysqli_query($con,$sql);

    	while($row = mysqli_fetch_array($result)) {
      		$userrole = '';
      		if ($row["role"] == 'u') { $userrole = 'User'; } else
        	if ($row["role"] == 's') { $userrole = 'Seller'; } else 
          	if ($row["role"] == 'a') { $userrole = 'Admin';}
      


      		echo '<div class="row ">';
      			echo '<div class="col-md-3">';
      				echo '<table align="center" >';
      					echo '<tr>';
      						echo '<td align="center"><img class="img-circle"  src="' . $row["avatarpath"] . '" width="150" height="150" alt="' . $row["username"] . '"></td>';
      					echo '</tr>';
      					echo '<tr>';
      						echo '<td align="center">' . $userrole . '</td>';
      					echo '</tr>';
      					echo '<tr>';
     					 echo '<td align="center">';
      						echo $row["city"] . ', ' . $row["state"];
     	 				echo '</td>';
     				 echo '</tr>';
     		 echo '</table>';
     	 echo '</div>';
      	echo '<div class="col-md-9">';
      		echo '<table width="100%" >';
      			echo '<tr>';
      				echo '<td>';
      				echo '&nbsp;';
      				echo '<h1>';
      					echo $row["username"];
     	 				echo '&nbsp;<a href="editprofile.php"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit Profile</button></a>';
      				echo '</h1>';
      				echo '</td>';
      			echo '</tr>';
      			echo '<tr>';
      				echo '<td>';
      					echo '<h4><em>' . $row["email"] . '</em></h4>';
      				echo '</td>';
      			echo '</tr>';
      			echo '<tr>';
      				echo '<td>';
      					echo 'Joined : ' . $row["joindate"];
      				echo '</td>';
      			echo '</tr>';
      			echo '<tr>';
      				echo '<td>';
      					echo 'Last Login: ' . $row["lastlogin"];
      				echo '</td>';
      			echo '</tr>';
      		echo '</table>';
      	echo '</div>';
      echo '</div><!-- /row -->';
	  echo '<hr class="featurette-divider">';
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

    	echo '<div class="row ">';
    		echo '<div class="col-lg-4">';
    			echo '<h2>Communities&nbsp;<a href="community.php"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;Join</button></a></h2>';
				echo '<hr/>';
    				if ($totalcommunity > 0) {
      					echo '<table>';
      					$sql = 'select communityid from joins where memberid=' . $memberid;
      					$result = mysqli_query($con,$sql);
      					while($row = mysqli_fetch_array($result)) {
       	 					$sql2 = 'select name,path from community where communityid=' . $row["communityid"];
        					$result2 = mysqli_query($con,$sql2);
        				while($row2 = mysqli_fetch_array($result2)) {
          					echo '<tr>';
          						echo '<td align="center">';
          							echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  src="' . $row2["path"] . '" width="150" height="150" alt="' . $row2["name"] . '"></a>';
          						echo '</td>';
							echo '</tr>';
							echo '<tr>';
          						echo '<td align="center">';
         							echo $row2["name"];
          						echo '</td>';
          					echo '</tr>';
							echo '<tr>';
								echo '<td>&nbsp;</td>';
							echo '</tr>';

        				} // end per community loop
      				} // end loop to obtain communityid member has joined
      			echo '</table>';           
      
    		} else { // end if $totalcommunity > 0
     		 	echo 'You have not joined any communities yet!';
    		} // end if-else $totalcommunity > 0
		echo '</div><!-- /.col-lg-4 -->';

    	echo '<div class="col-lg-4">';
    echo '<h2>Topics&nbsp;<a href="topic.php"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;Follow</button></a></h2>';
	echo '<hr/>';
    if ($totaltopic > 0) {
    	echo '<table class="table-top">';
      	$sql = 'select topicid from follows where memberid=' . $memberid;
      	$result = mysqli_query($con,$sql);
      	
		while($row = mysqli_fetch_array($result)) {
        	$sql2 = 'select name from topic where topicid=' . $row["topicid"];
        	$result2 = mysqli_query($con,$sql2);
        	
			while($row2 = mysqli_fetch_array($result2)) {
          		$newcontent = FALSE;
          		$newmessage = '';
          		$sql3 = 'select created,message from content where topicid=' . $row["topicid"];
          		$result3 = mysqli_query($con,$sql3);
          		
				while($row3 = mysqli_fetch_array($result3)) {
            		if ($row3["created"] > $_SESSION["lastlogin"]) { 
              			$newcontent = TRUE;
              			$newmessage = $newmessage . $row3["message"] . '<br/>';
            	} // end if new message posted after lastlogin
          	}
          	echo '<tr>';
          		echo '<td class="text-left"><a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row2["name"] . '</a></td>';
          		if ($newcontent == TRUE) {
            		echo '<td>' . $newmessage . '&nbsp;<span class="glyphicon glyphicon-asterisk" style="color:red"></span>&nbsp;<font color="red"><strong>New Post</strong></font></td>';
          		}
          echo '</tr>';
        } // end for loop per individual topic
      } // end for loop to get topicid from follows
      echo '</table>';
      
    } else { // end it $totaltopic > 0
      echo 'You have not yet followed any topics!';
    } // end if-else $totaltopics > 0
	echo '</div><!-- /.col-lg-4 -->';
    if ($userrole == 'Seller') {

      echo '<!--Product Head -->';
      echo '<div class="col-lg-4">';
      echo '<h2>Products&nbsp;<a href="addproduct.php"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button></a></h2>';

      if ($totalproduct > 0) {
        echo '<table >';

        $sql = 'select * from product where ownerid=' . $memberid;
        $result = mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($result)) {
          $productimagepath = '';
          $found = 0;
          $sql2 = 'select path from productdetail where productid=' . $row["productid"];
          $result2 = mysqli_query($con,$sql2);
          while(($row2 = mysqli_fetch_array($result2)) && ($found == 0)) {
            $found += 1;
            $productimagepath = $row2["path"];
          }
          echo '<tr>';
          	echo '<td>';
          		echo '<a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  src="' . $productimagepath . '" width="150" height="150" alt="' . $row["name"] . '"></a>';
          	echo '</td>';
          echo '</tr>';
		  echo '<tr>';
			echo '<td align="center">' . $row["name"] . '</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td align="center">';

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
		  echo '<tr>';
		  	echo '<td>&nbsp;</td>';
		  echo '</tr>';
        } // end for loop to dispay products

      } else { // end if $totalproducts > 0
        echo 'You do not own any products!<br>';
      } // end if-else $totalproducts > 0
  
    } // end if userrole = 'Seller'
 
    echo '</table>';
    

  } else { // end if user is logged in
    echo 'You have navigated to this page in error and must be logged in!<br>';
  } // end if-else user is logged in
  echo '</div><!-- /.col-lg-4 -->';
  echo '</div>';
  mysqli_Close($con);

?>
     <br/>
        <br/>
        <br/>
      </div><!-- /end of container -->

	<!-- Footer
    ================================================== -->
      <div class="container">
          <footer>
              <br/>
              <br/>
              <br/>
              <div align="center">
                <img src="images/logoWhite.png" width="75" height="75" align="Circle">
              </div>
              <br/>
              <br/>
              <br/>
              <hr/>
              <p class="pull-right footer-color"><a href="#top" class="footer-color">Back to top</a></p>
              <p class="footer-color">&copy; 2014 Circle, Inc. &middot; <a href="privacy.php" class="footer-color">Privacy</a> &middot; <a href="terms.php" class="footer-color">Terms</a> &middot; <a href="about.php" class="footer-color">About</a></p>
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