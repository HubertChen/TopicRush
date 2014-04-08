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

    <title>Circle</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">    
  
  </head>  
  
<!-- NAVBAR	
================================================== -->
  <body >
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
            	
                <!--USER IS LOGGED IN-->
                <div class="navbar-right">

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
                   
                <!--USER IS NOT LOGGED IN-->    
            	<!--<a href="signin.php"><button type="button" class="btn btn-signin navbar-btn-right">Sign In</button></a>
            	<a href="signup.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Up</button></a>-->

          </form>  
        </div>
      </div>
    </div>


    <!-- Carousel
    Need to:
    		-Change slides with common color and theme (adds bubbles as necessary)
            -add links where neccessary
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol> 
      <div class="carousel-inner">
      
      	<!--SLIDE 1 - CIRCLE-->
        <div class="item active">
          <img data-src="holder.js/900x500/auto/#7aadd9:#7a7a7a/text: " alt="Circle">
          <div class="container">
            <div class="carousel-caption">
              <a href="objective.php"><img src="images/logoWhite.png" alt="Circle" width="165" height="165" vspace="5"></a><br/>
              <a href="objective.php"><img src="images/logotextWhite.png" alt="Circle" width="117" height="37" vspace="20"></a><br/>
              <img src="images/carousel-circleInfo-01.png" alt="Circle" vspace="30">&nbsp;&nbsp;&nbsp;&nbsp;
              <img src="images/carousel-circleInfo-02.png" alt="Circle">
            </div>
          </div>
        </div>
        
        <!-- SLIDE 2 - COMMUNITY -->
        <div class="item">
        <img data-src="holder.js/900x500/auto/#67a2d4:#6a6a6a/text: " alt="Topic">
          <div class="container">
            <div class="carousel-caption">
            	<div class="row" align="left">
                	<div class="col-md-12">
                    	<a href="objective.php#obj-community"><img src="images/whitecircle.png" alt="circle" width="165" height="165"></a>&nbsp;&nbsp;
                    	<a href="objective.php#obj-community"><img src="images/communitytxt-00.png" alt="community" height="37"></a>
                    </div>
                </div> 
                <br/>
                <div class="row" align="right">
                	<div class="col-md-12">
                    	<img src="images/carousel-comInfo-01.png" alt="Community">&nbsp;&nbsp;
                        <img src="images/carousel-comInfo-02.png" alt="Community">
                    </div>
                </div>
				<br/>
                <div class="row" align="right">
                	<div class="col-md-12">
                    	<a class="btn btn-lg btn-signin" href="objective.php#obj-community" role="button">Learn more</a>
                    </div>
                </div>
       			<br/>
            </div>
          </div>
        </div>
        
        <!-- SLIDE 3 - TOPIC -->
        <div class="item">
          <img data-src="holder.js/900x500/auto/#5496cf:#6a6a6a/text: " alt="Topic">
          <div class="container">
            <div class="carousel-caption">
              <div class="row" align="right">
                	<div class="col-md-12">
                    	<a href="objective.php#obj-topic"><img src="images/topictxt-00.png" alt="community" height="37"></a>&nbsp;&nbsp;
                    	<a href="objective.php#obj-topic"><img src="images/whitecircle.png" alt="circle" width="130" height="130"></a>
                    </div>
                </div> 
                <br/>
                <br/>
                <div class="row" align="left">
                	<div class="col-md-12">
                    	<img src="images/topicInfo.png">
                    </div>
                </div>
				<br/>
                <div class="row" align="left">
                	<div class="col-md-12">
                    	<a class="btn btn-lg btn-signin" href="objective.php#obj-topic" role="button">Learn more</a>
                    </div>
                </div>
       			<br/>
            </div>
          </div>
        </div>
        
        <!-- SLIDE 4 - PRODUCTS-->
        <div class="item">
          <img data-src="holder.js/900x500/auto/#428bca:#5a5a5a/text: " alt="Product">
          <div class="container">
            <div class="carousel-caption">
              <div class="row" align="left">
                	<div class="col-md-12">
                    	<a href="objective.php#obj-product"><img src="images/whitecircle.png" alt="circle" width="95" height="95"></a>&nbsp;&nbsp;
                    	<a href="objective.php#obj-product"><img src="images/producttxt-00.png" alt="community" height="37"></a>
                    </div>
                </div> 
                <br/>
                <br/>
                <div class="row" align="right">
                	<div class="col-md-12">
                    	<img src="images/productInfo.png">
                    </div>
                </div>
				<br/>
                <div class="row" align="right">
                	<div class="col-md-12">
                    	<a class="btn btn-lg btn-signin" href="objective.php#obj-product" role="button">Learn more</a>
                    </div>
                </div>
                <br/>
            </div>
          </div>
        </div>
      </div>
      
      <!--Left and Right links to rotates  between carousels -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->






    <!-- Promotions Pages: Community, Topic, Product
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        
        <!--Community Head -->
        <div class="col-lg-4">
          <a href="community.php"> <img class="img-circle" src="images/communityLogo-04.png" alt="Community" height="140" width="140" vspace="5"></a>
          <div class="row">
          	<div class="col-md-12">
                    <a href="community.php"><img src="images/communitytxt-01.png" alt="Community" width="203" height="38"></a>
          	</div>
          </div>
          <p>Join a community that share a common interest on topics and ideas.</p>
          <p><a class="btn btn-default" href="community.php" role="button">Join &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        
        <!--Topic Head -->
        <div class="col-lg-4">
          <a href="topic.php"> <img class="img-circle" src="images/topicLogo-04.png" alt="Topic" height="140" width="140" vspace="5"></a>
          <div class="row">
          	<div class="col-md-12">
                    <a href="topic.php"><img src="images/topictxt-01.png" alt="Community" height="38"></a>
          	</div>
          </div>
          <p>Follow topics to discover new ideas and to help others follow their ideas.</p>
          <p><a class="btn btn-default" href="#" role="button">Follow &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        
        <!--Product Head -->
        <div class="col-lg-4">
          <a href="product.php"><img class="img-circle" src="images/productLogo-04.png" alt="Product" height="140" width="140" vspace="5"></a>
          <div class="row">
          	<div class="col-md-12">
                    <a href="product.php"><img src="images/producttxt-01.png" alt="Community" height="38"></a>
          	</div>
          </div>
          <p>Review a product that has made life easier or made life worse.</p>
          <p><a class="btn btn-default" href="reviewproduct.php" role="button">Review &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

    <!-- Top Section
    Need to do:
    		-Add the necessary links
            -Fix for CSS
            -Someone needs to figure the functionality of how the stars show up (I rather to full stars now instead of halfs
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
      <hr class="featurette-divider">
      <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        
        <!--Community Head -->
        <div class="col-lg-4">
          <h3>Top Community</h3>

<?php
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  $totalcommunity = 0;
  $totaltopic = 0;
  $totalproduct = 0;
  $maxcommunity = 0;
  $maxtopic = 0;
  $maxproduct = 0;

  $sql = 'select count(communityid) from community';
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totalcommunity = $row["count(communityid)"]; }
  if ($totalcommunity > 2) {
    $maxcommunity = 3;
  } else {
    $maxcommunity = $totalcommunity;
  }

  $sql = 'select count(topicid) from topic';
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totaltopic = $row["count(topicid)"]; }
  if ($totaltopic > 2) {
    $maxtopic = 3;
  } else {
    $maxtopic = $totaltopic;
  }

  $sql = 'select count(productid) from product';
  $result = mysqli_query($con,$sql);
  foreach ($result as $row) { $totalproduct = $row["count(productid)"]; }
  if ($totalproduct > 2) {
    $maxproduct = 3;
  } else {
    $maxproduct = $totalproduct;
  }  

  echo '<table align="center">';
  if ($maxcommunity > 0) {
    $count = 0;
    $sql = 'select * from community order by rating desc';
    $result = mysqli_query($con,$sql);

    while(($row = mysqli_fetch_array($result)) && ($count < $maxcommunity)) {
      $count += 1;
      echo '<tr>';
      echo '<td class="table-top-product-padding" rowspan="2">' . $count . '.</td>';
      echo '<td class="text-left table-top-product-padding" rowspan="2">';
      echo '<a href="viewcommunity.php?id=' . $row["communityid"] . '"><img class="img-circle"  img src="' . $row["path"] . '" height="90" width="90" alt="Generic placeholder image"></a>';
      echo '</td>';
      echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >';
      echo $row["name"];
// NEED TO DO CHECKING TO DISPLAY THE CORRECT BUTTON
//      echo '<a href="php/join.php"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span></button></a>';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td class="table-top-product-stars" align="left" valign="top">';
      echo '<td align="center"> (' . $row["rating"] . ') M=' . $row["nummembers"] . ',T=' . $row["numtopics"] . ',C=' . $row["numcontents"] . '.</td>';
      echo '</td>';
      echo '</tr>';
          
    } // end while loop to display top community
  } else { // end if $maxcommunity > 0

  } // end if-else $maxcommunity > 0
  echo '</table>'; 
  echo '<p><a class="btn btn-default" href="community.php#topCommunity" role="button">more &raquo;</a></p>';
  echo '</div><!-- /.col-lg-4 -->';   

 
  echo '<!--Topic Head -->';
  echo '<div class="col-lg-4">';
  echo '<h3>Top Topic</h3>';       
  echo '<table class="table-top" align="center">';
  
  if ($maxtopic > 0) {

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

    $count = 0;

    while($count < $maxtopic) {
      $sql = 'select * from topic where topicid=' . $toptopics[$count];
      $result = mysqli_query($con,$sql);

      foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . ($count+1) . '.</td>';
        echo '<td class="text-left"> <a href="viewtopic.php?id=' . $row["topicid"] . '">' . $row["name"] . '</a></td>';
        echo '</tr>';
      } // end for loop to print Topic Information.
      $count += 1;
    } // end while loop to print top topics

  } else { // end if $maxtopic > 0

  } // end if-else $maxtopic > 0

  echo '</table>';   
  echo '<p><a class="btn btn-default" href="topic.php#topTopic" role="button">more &raquo;</a></p>';
  echo '</div><!-- /.col-lg-4 -->';  

  
  echo '<!--Product Head -->';
  echo '<div class="col-lg-4">';
  echo '<h3>Top Product</h3>';
  echo '<table align="center">';

  if ($maxproduct > 0) {
    $count = 0;
    $sql = 'select * from product order by (rating/numreviews) desc';
    $result = mysqli_query($con,$sql);
    while(($row = mysqli_fetch_array($result)) && ($count < $maxproduct)) {
      $count += 1;

      $rating = 0;
      if ($row["numreviews"] != 0) {
        $rating = $row["rating"] / $row["numreviews"];
      }

      $numrecords = 0;
      $imagepath = "";
      $sql2 = 'select path from productdetail where productid=' . $row["productid"];
      $result2 = mysqli_query($con,$sql2);
      while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
        $numrecords += 1;
        $imagepath = $imagepath . $row2["path"];
      }


      echo '<tr>';
      echo '<td class="table-top-product-padding" rowspan="2">' . $count . '.</td>';
      echo '<td class="text-left table-top-product-padding" rowspan="2">';
      echo '<a href="viewproduct.php?id=' . $row["productid"] . '"><img class="img-circle"  img src="' . $imagepath . '" width="90" height="90" alt="Generic placeholder image"></a>';
      echo '</td>';
      echo '<td class="table-top-product-name" height="65" align="left" valign="bottom" >' . $row["name"] . '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td class="table-top-product-stars" align="left" valign="top">';
      $stars = 0;
      $rating = round($rating,1);
      while ($stars < round($rating,0,PHP_ROUND_HALF_EVEN)) {        
        echo '<span class="glyphicon glyphicon-star"></span>';
        $stars += 1;
      }
      echo '(' . $rating . ')';
      echo '</tr>';
    } // end while loop to print top proucts
  } else { // end if $maxproduct > 0

  } // end if-else $maxproduct > 0


  echo '</table>';
  echo '<p><a class="btn btn-default" href="product.php#topProduct" role="button">more &raquo;</a></p>';
  echo '</div><!-- /.col-lg-4 -->';
  echo '</div><!-- /.row -->';


  mysqli_close($con);

?>
      <hr class="featurette-divider">
      <!-- /END THE FEATURETTES -->


      <!-- Footer
          Need to do:
    		-Add color to the bottom
            -May want to add bread crumb for navigation purposes
    ================================================== -->
      <!--<ol class="breadcrumb">
      	<li><a href="index.php">Home</a></li>
      </ol>-->
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
    <script src="js/actions.js"></script>
    
	<!-- Used for follow button -->
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