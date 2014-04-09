<!-- DONE: 4/8/14 -->
<?php session_start(); ?>

<?php               
  /*WILL NEED TO CHANGE*/
  	$dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "Circle";
  
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
	
  	//connected to database
    $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {  
      $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            There seems to be a problem, please try again later!
            </div>';
  
    include 'reviewproduct.html.php';
    exit(); 
    }

  //If user is logged in
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

    $sql = 'select name from product where productid=' . $productid;
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) { 
    $validproductid = TRUE;
    }

    //If the product is valid
    if ($validproductid == TRUE) {

      $sql = 'select * from review where productid=' . $productid . ' and memberid=' . $memberid;
      $result = mysqli_query($con,$sql);
      $found = 0;
      
      while($row = mysqli_fetch_array($result)) { 
        $found += 1; 
      }
    
      if ($found > 0) { $alreadyreviewed = TRUE; }
      $sql = 'select * from product where productid=' . $productid;
      $result = mysqli_query($con,$sql);
      
      foreach ($result as $row) {
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
      foreach ($result as $row) { $categoryname = $row["name"]; }

      $sql = 'select username from member where memberid=' . $ownerid;
      $result = mysqli_query($con,$sql);
      foreach ($result as $row) { $ownername = $row["username"]; }

      $numrecords = 0;
      $sql2 = 'select path from productdetail where productid=' . $productid;
      $result2 = mysqli_query($con,$sql2);
      while(($row2 = mysqli_fetch_array($result2)) && ($numrecords == 0)) {
        $numrecords += 1;
        $imagepath = $imagepath . $row2["path"];
      }
      
      //if Product is not yet reviewed
      if ($alreadyreviewed == FALSE) {
        
        //Displays review button
        if (($ownerid != $memberid) && ($alreadyreviewed == FALSE)) {
                $button = '<button type="submit" class="btn btn-primary pull-right">Review</button>';
            }
        
        $reviewed = '
              <form action="reviewproduct.php?id=' . $productid . '" method="post" role="form">
                <div class="row">
                  <div class="col-md-1">
                    <div class="form-group">
                      <label for="rating">Rating</label>
                      <select class="form-control" name="rating" id="rating">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                      <label for="ratedescript">Description</label>
                        <textarea class="form-control" rows="3" name="ratedescript" id="ratedescript" placeholder="Descriptions" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">' . $button .'</div>
                </div>
              </form>';
        
        //add include here
      //If product has been already reviewed
      } else { 
        $reviewed = "You have already reviewed this product!<br/>";
        
        //maybe add disabled button here
        //add include here
      }
            
      //If post message received
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $validform = TRUE;
        $formerrors = '';
        $postrating = $_POST["rating"];
        $postdescription = $_POST["ratedescript"];
        //echo $postrating . "<br>" . $postdescription . "<br>";
        
        //Error messages
        if ($postrating == 0) {
          $validform = FALSE;
          $formerrors = $formerrors . "Rating must be between 1 and 5, please try again!<br/>";
        }
        if ((strlen($postdescription) < 20) || is_numeric($postdescription)) {
          $validform = FALSE;
          $formerrors = $formerrors . "Description must be twenty or more characters, please try again!<br/>";
        }
        
        //If the form is valid
        if ($validform == TRUE) {
          $sql="insert into review(memberid,productid,reviewdetails,rating,reviewdate) values ('$memberid','$productid','$postdescription','$postrating','$tstamp')";
          mysqli_query($con,$sql);
          $postdescription = '';
          $postrating = 0;
          
          $errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Product added Successfully!
              </div>';
        
        //Form has errors
        } else {
          
          //Add error messages here!
          //echo "Form has the following errors:<br>" . $formerrors;
          
          $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  ' . $formerrors. '
                </div>';
          
          $formerrors = '';
        } // end if-else $valiform == TRUE
      } //end if post message is received
    include 'reviewproduct.html.php';
    //Product is not valid
    } else { // end if $validproductid == TRUE
      echo 'Invalid Product specified please try again!<br>';
      
      $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Invalid product, please try again!
            </div>';
      include 'reviewproduct.html.php';
      exit();
    } // end if-else $validproductid == TRUE
    
    mysqli_close($con);
  
  //If user is not logged in
  } else {    
    $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Need to sign in to review a product!
            </div>';
    //$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Product</button>';
    include 'reviewproduct.html.php';
    exit(); 
  }
?>