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

    <title>Circle  | Add Product</title>
    
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
            	
                <!--USER IS LOGGED IN-->
                <!--<div class="navbar-right">
                	<a href="profile.php">
                  		<img src="images/userDefault.png" alt="Generic placeholder image" width="35" height="35" class="img-circle">
                  	</a>
				  	<a href="profile.php">[User Name]</a>
                </div>-->
                    
                <!--USER IS NOT LOGGED IN-->    

<?php               
  if (isset($_SESSION["loggedin"])) {
    echo '<a href="signout.php"><button type="button" class="btn btn-primary navbar-btn-right" >Sign Out</button></a>';
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
          	<h1>Add Product</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          	<form action="addproduct.php" method="post" enctype="multipart/form-data" role="form">
<?php
  $productname = "";
  $productdescription = "";
  $listedprice = "";
  $retailprice = "";
  $category = "";
  $newcategory = "";
  $picturedescription = "";
  $productpath = 'C:\\wamp\\www\\bzk\\products\\';
  $validform = TRUE;
  $formerrors = "";
  $extension = "";

  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "Circle";

  $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
  }

  echo '<div class="form-group">';
  echo '<label for="productname">Name</label>';
  echo '<input type="text" class="form-control" name="productname" id="productname" placeholder="Enter name" value="' . $productname . '" required>';
  echo '</div>';

  echo '<div class="form-group">';
  echo '<label for="Product Description">Product Description</label>';
  echo '<textarea class="form-control" rows="3" name="productdescription" id="prodctdescription" placeholder="Product Description" value="' . $productdescription . '" required></textarea>';
  echo '</div>';

  echo '<div class="form-group">';
  echo '<label for="listedprice">Listed Price</label>';
  echo '<input type="text" class="form-control" name="listedprice" id="listedprice" placeholder="Enter Price" value="' . $listedprice . '" required>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label for="retailprice">Retail Price</label>';
  echo '<input type="text" class="form-control" name="retailprice" id="retailprice" placeholder="Enter Price" value="' . $retailprice . '" required>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label for="Category">Category</label>';
  echo '<select name="category" class="form-control">';

  $result = mysqli_query($con,"select categoryid,name  from category");
  foreach($result as $row) {
    echo '<option value="'.$row['categoryid'].'"';
    echo '>'. $row['name'] . '</option>'."\n";
  } // end for loop to print Category

  echo '<option value="addnew">Add New</option>';
  echo '</select>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label for="retailprice">New Category</label>';
  echo '<input type="text" class="form-control" name="newcategory" id="newcategory" placeholder="Enter Category">';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label for="file">Picture</label>';
  echo '<input type="file" name="file" id="file">';
  echo '<p class="help-block">Must be .gif .jpg .jpeg or .png and less than 200kbytes.</p>';
  echo '</div>';
  echo '<div class="form-group">';
  echo '<label for="retailprice">Picture Description</label>';
  echo '<textarea class="form-control" rows="3" name="picturedescription" id="picturedescription" placeholder="Picture Description" value="' . $picturedescription . '" required></textarea>';
  echo '</div>';


  if (isset($_SESSION["loggedin"])) {
    if ($_SESSION["role"] == "s") {
      echo '<button type="submit" class="btn btn-default">Add</button>';
      $memberid = $_SESSION["memberid"];
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $validform = TRUE;
        $postproductname = $_POST["productname"];
        $postproductdescription = $_POST["productdescription"];
        $postlistedprice = $_POST["listedprice"];
        $postretailprice = $_POST["retailprice"];
        $category = $_POST["category"];
        $postaddnew = $_POST["newcategory"];
        $postpicturedescription = $_POST["picturedescription"];
 
        echo "<br>" . $postproductname . "<br>";  
        echo $postproductdescription . "<br>";
        echo $postlistedprice . "<br>";
        echo $postretailprice . "<br>";
        echo $category . "<br>";
        echo $postaddnew . "<br>";
        echo $postpicturedescription . "<br>";

        if (strlen($postproductname) <= 3) {
          $validform = FALSE;
          $formerrors = $formerrors . "Product name must be more than three characters!<br>";
        } else {
          $productname = $postproductname;
        }

        if (strlen($postproductdescription) <= 5) {
          $validform = FALSE;
          $formerrors = $formerrors . "Product Description must be more than five characters!<br>";
        } else {
          $productdescription = $postproductdescription;
        }

        if (is_numeric($postretailprice) == FALSE) {
          $validform = FALSE;
          $formerrors = $formerrors . "Retail Price was not a numeric value!<br>";
        } else {
          $retailprice = $postretailprice;
        }

        if (is_numeric($postlistedprice) == FALSE) {
          $validform = FALSE;
          $formerrors = $formerrors . "Listed Price was not a numeric value!<br>";
        } else {
          $listedprice = $postlistedprice;
        }

        if (strlen($postpicturedescription) <= 5) {
          $validform = FALSE;
          $formerrors = $formerrors . "Picture description must be more than five characters!<br>";
        } else {
          $picturedescription = $postpicturedescription;
        }

        if (($category == "addnew") and (strlen($postaddnew) < 3)) {
          $validform = FALSE;
          $formerrors = $formerrors . "Add new category must be atleast three characters!<br>";
        }


        if ($_FILES["file"]["error"] > 0) {
          echo "Error: " . $_FILES["file"]["error"] . "<br>";
          $valdiform = FALSE;
          $formerrors = $formerrors . "No file provided or invalid type!<br>";
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
          
          } else { // end if file is a supported type
            $validform = FALSE;
            $formerrors = $formerrors . "File must be gif jpg jpeg or png!<br>";
          } // end if-else is a supported type

        } // end if-else no file attached
        if ($validform == FALSE) {
          echo "The form has the following errors<br>";
          echo $formerrors;
        } else { // end if $valiform == FALSE
// BEGIN HERE
          $productid = 0;
          if ($category == "addnew") {
            echo "Attempting to add ( " . $postaddnew . " ) <br>";
            $sql = "select * from category";
            $result = mysqli_query($con,$sql);
            $found = 0;
            $foundid = -1;
            while(($row = mysqli_fetch_array($result)) and ($found == 0)){
              $pattern = "/" . strtolower($postaddnew) . "/";
              if (preg_match($pattern,strtolower($row['name']))) { 
                $found += 1; 
                $foundid = $row['categoryid'];
                $category = $foundid;
                echo "Found! " . $pattern . " = " . $row['name'] . "<br>";
              } 
            } // end while loop
            if ($found == 0) {
              echo "Adding new Category ( " . $postaddnew . " )<br>";
              $sql = "insert into category(name) values('" . $postaddnew . "')";
              mysqli_query($con,$sql);
              $sql = "select categoryid from category where name='" . $postaddnew . "'";        
              $result = mysqli_query($con,$sql);
              foreach($result as $row) { $category = $row['categoryid']; }
            } else {
              echo "Category Already exists at " . $foundid . "<br>";
            }

          } // new category 



          $sql="insert into product(ownerid,name,description,rating,retailprice,listedprice,category,numreviews) values ('$memberid','$productname','$productdescription','0','$retailprice','$listedprice','$category','0')";
          mysqli_query($con,$sql);


          $sql="select * from product where name='$productname'";

          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_array($result)) {
           $productid = $row['productid'];
          }

          $productid=$productid . "";
          $productpath=$productpath . $productid;
          mkdir($productpath,0777);
          $temppath = "new product path";
          $sql="insert into productdetail(productid,type,path,description) values('$productid','1','$temppath','$picturedescription')";
          mysqli_query($con,$sql);

          $detailid = -1;

          $sql="select detailid from productdetail where productid=" . $productid . " and path='" . $temppath . "'";
          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_array($result)) {
            $detailid = $row['detailid'];
            echo "<br> DetailID = " . $detailid . "<br>";
          }

          move_uploaded_file($_FILES["file"]["tmp_name"],$productpath . "\\" . $detailid . "." . $extension);
          $filepath = "/products/" . $productid . "/" . $detailid . "." . $extension;
          $sql = "update productdetail set path='" . $filepath . "' where detailid=" . $detailid;
          mysqli_query($con,$sql);

          echo "Product added successfully!<br>";


// END HERE
        } // end if-else $validform == FALSE

      } // end if post message received
    } // end if user is a seller, double check
  } // end if user is logged in

  mysqli_close($con);
?>
            </form>
        </div>
        <div class="col-md-6">
          	<p>&nbsp;</p>
          	<p>&nbsp;</p>
          	<p>&nbsp;</p>
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