<!-- DONE: 4/6/14 -->
<?php session_start(); ?>

<?php    
  
	$productname = "";
	$productdescription = "";
	$listedprice = "";
	$retailprice = "";
	$category = "";
	$newcategory = "";
	$picturedescription = "";
	$productpath = 'C:\\wamp\\www\\bzk\\product\\';
	$validform = TRUE;
	$formerrors = "";
	$extension = "";
        $filterlist = array();
        $filterfile = 'C:\\wamp\\www\bzk\\filter.txt';
        $file = fopen($filterfile,"r");
        $index = 0;
        while (!feof($file)) {
          $input = trim(fgets($file));
          if (strlen($input) > 0) { array_push($filterlist,$input); }
        }        
        $filtersize = count($filterlist);
	
	/*WILL NEED TO CHANGE*/
	$dbhost = "localhost:3306";
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




	//Connect to database
  	$con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  	if (mysqli_connect_errno()) {  
    	$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						There seems to be a problem, please try again later!
						</div>';
	
		include 'addproduct.html.php';
		exit(); 
  	} 

	//If user is logged in
  	if (isset($_SESSION["loggedin"])) {
		
		//If user is a 'seller'
		if ($_SESSION["role"] == "s") {
      		$button = '<button type="submit" class="btn btn-primary pull-right">Add Product</button>';
      		$memberid = $_SESSION["memberid"];
	  
	  		//If post message received
      		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$validform = TRUE;
				$postproductname = $_POST["productname"];
				$postproductdescription = $_POST["productdescription"];
				$postlistedprice = $_POST["listedprice"];
				$postretailprice = $_POST["retailprice"];
				$category = $_POST["category"];
				$postaddnew = $_POST["newcategory"];
				$postpicturedescription = $_POST["picturedescription"];

        if (strlen($postproductname) <= 3) {
          $validform = FALSE;
          $formerrors = $formerrors . "Product name must be more than three characters!<br>";
        } else {
          $valid = TRUE;
          if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postproductname) == TRUE) { 
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Invalid input, please try again!<br>';
          }
          if ($valid == TRUE) {
            $index = 0;
            $found = FALSE;
            while (($index < $filtersize) && ($valid == TRUE)) {
              $pattern = '/' . $filterlist[$index] . '/i';
              if (preg_match($pattern,$postproductname) == TRUE) {
                $valid = FALSE;
                $validform = FALSE;
                $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
              } // end if input matches filter word
              $index += 1;
            } // end while loop to loop through each filter word
          } // end if $valid == TRUE
        } // end if-else $productname is invalid

        if (strlen($postproductdescription) <= 5) {
          $validform = FALSE;
          $formerrors = $formerrors . "Product Description must be more than five characters!<br>";
        } else {
          $valid = TRUE;
          if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postproductdescription) == TRUE) { 
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Invalid input, please try again!<br>';
          }
          if ($valid == TRUE) {
            $index = 0;
            $found = FALSE;
            while (($index < $filtersize) && ($valid == TRUE)) {
              $pattern = '/' . $filterlist[$index] . '/i';
              if (preg_match($pattern,$postproductdescription) == TRUE) {
                $valid = FALSE;
                $validform = FALSE;
                $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
              } // end if input matches filter word
              $index += 1;
            } // end while loop to loop through each filter word
          } // end if $valid == TRUE
        } // end if $postproductdescription is invalid



				if (is_numeric($postretailprice) == FALSE) {
				  $validform = FALSE;
				  $formerrors = $formerrors . "Retail Price not a numeric value!<br/>";
				} else {
				  $retailprice = $postretailprice;
				}

				if (is_numeric($postlistedprice) == FALSE) {
				  $validform = FALSE;
				  $formerrors = $formerrors . "Listed Price not a numeric value!<br/>";
				} else {
				  $listedprice = $postlistedprice;
				}

        if (strlen($postpicturedescription) <= 5) {
          $validform = FALSE;
          $formerrors = $formerrors . "Picture description must be more than five characters!<br>";
        } else {
          $valid = TRUE;
          if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postpicturedescription) == TRUE) { 
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Invalid input, please try again!<br>';
          }
          if ($valid == TRUE) {
            $index = 0;
            $found = FALSE;
            while (($index < $filtersize) && ($valid == TRUE)) {
              $pattern = '/' . $filterlist[$index] . '/i';
              if (preg_match($pattern,$postpicturedescription) == TRUE) {
                $valid = FALSE;
                $validform = FALSE;
                $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
              } // end if input matches filter word
              $index += 1;
            } // end while loop to loop through each filter word
          } // end if $valid == TRUE
        } // end if-else $postpicturedescription is invalid


        if (($category == "addnew") and (strlen($postaddnew) < 3)) {
          $validform = FALSE;
          $formerrors = $formerrors . "Add new category must be atleast three characters!<br>";
        } else {
          $valid = TRUE;
          if (preg_match("/<(\/*)[a-zA-Z0-9]*(>|.)/i",$postaddnew) == TRUE) { 
            $valid = FALSE;
            $validform = FALSE;
            $formerrors = $formerrors . 'Invalid input, please try again!<br>';
          }
          if ($valid == TRUE) {
            $index = 0;
            $found = FALSE;
            while (($index < $filtersize) && ($valid == TRUE)) {
              $pattern = '/' . $filterlist[$index] . '/i';
              if (preg_match($pattern,$postaddnew) == TRUE) {
                $valid = FALSE;
                $validform = FALSE;
                $formerrors = $formerrors . 'Input contains innapropriate material, please be nice and try again!<br>';
              } // end if input matches filter word
              $index += 1;
            } // end while loop to loop through each filter word
          } // end if $valid == TRUE
        } // end if-else $addnewcategory is invalid

				if ($_FILES["file"]["error"] > 0) {
					//echo "Error: " . $_FILES["file"]["error"] . "<br>";
				  	$valdiform = FALSE;
				  	$formerrors = $formerrors . "Invalid picture file!<br/>";
				} else { // end if no file attached
				  	//echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				  	//echo "Type: " . $_FILES["file"]["type"] . "<br>";
				  	//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				  	//echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>";
				  	$allowedimagetype = array("gif","jpeg","jpg","png");
				  	$temp = explode(".", $_FILES["file"]["name"]);
				  	$extension = end($temp);
				  	//echo "Extension type = " . $extension . "<br>";

				if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/png"))
				&& ($_FILES["file"]["size"] < 204800)
				&& in_array($extension, $allowedimagetype)) {
          		} else { // end if file is a supported type
            		$validform = FALSE;
            		$formerrors = $formerrors . "File must be .gif, .jpg, .jpeg, or .png!<br>";
          		} // end if-else is a supported type
        	} // end if-else no file attached
        	
			if ($validform == FALSE) {

		  		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									' . $formerrors. '
								</div>';
				$button = '<button type="submit" class="btn btn-primary pull-right">Add Product</button>';
				
				include 'addproduct.html.php';
				exit();					
			
			} else { // end if $valiform == FALSE
          		$productid = 0;
          	        $productname = mysqli_real_escape_string($con,$postproductname);
                        $productdescription = mysqli_real_escape_string($con,$postproductdescription);
                        $picturedescription = mysqli_real_escape_string($con,$postpicturedescription);	
                        $postaddnew = mysqli_real_escape_string($con,$postaddnew);
				//Added a new category
				if ($category == "addnew") {
            		//echo "Attempting to add ( " . $postaddnew . " ) <br>";
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
                			//echo "Found! " . $pattern . " = " . $row['name'] . "<br>";
              			} 
            		} // end while loop
            	
				if ($found == 0) {
              		//echo "Adding new Category ( " . $postaddnew . " )<br>";
					$sql = "insert into category(name) values('" . $postaddnew . "')";
					mysqli_query($con,$sql);
					$sql = "select categoryid from category where name='" . $postaddnew . "'";        
					$result = mysqli_query($con,$sql);
              		while($row = mysqli_fetch_array($result)) { $category = $row['categoryid']; }
            	} else {
			  		//echo "Category Already exists at " . $foundid . "<br>";
            	}
			} //End new category 

			$sql="insert into product(ownerid,name,description,rating,retailprice,listedprice,category,numreviews) values ('$memberid','$productname','$productdescription','0','$retailprice','$listedprice','$category','0')";
          	mysqli_query($con,$sql);

          	$sql="select * from product where name='$productname'";

          	$result = mysqli_query($con,$sql);
			while($row = mysqli_fetch_array($result)) {
          		$productid = $row['productid'];
          	}

          	$productid=$productid . "";
          	$temppath = "new product path";
          	$sql="insert into productdetail(productid,type,path,description) values('$productid','1','$temppath','$picturedescription')";
          	mysqli_query($con,$sql);

          	$detailid = -1;

          	$sql="select detailid from productdetail where productid=" . $productid . " and path='" . $temppath . "'";
          	$result = mysqli_query($con,$sql);
          	while($row = mysqli_fetch_array($result)) {
            	$detailid = $row['detailid'];
            	//echo "<br> DetailID = " . $detailid . "<br>";
          	}

          	move_uploaded_file($_FILES["file"]["tmp_name"],$productpath . $detailid . "." . $extension);
          	$filepath = "/bzk/product/" . $detailid . "." . $extension;
          	$sql = "update productdetail set path='" . $filepath . "' where detailid=" . $detailid;
          	mysqli_query($con,$sql);

			$errorMessage = '<div class="alert alert-success alert-dismissable" align="center">
     							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Product added Successfully!
							</div>';
			include 'addproduct.html.php';
		} // end if-else $validform == FALSE
		exit();
	} // end if post message received
	include 'addproduct.html.php';
	} else {//end if user is a seller, double check
		$errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Account is not authorized to add a product!
						</div>';
		$button = '<button type="submit" class="btn btn-primary" disabled="disabled pull-right">Add Product</button>';
		include 'addproduct.html.php';
		exit();
	}// end if user is a not a sller
  	exit();
  } else { //end if user is logged in
	  $errorMessage = '<div class="alert alert-danger alert-dismissable" align="center">
     						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Need to sign in to add a product!
						</div>';
	$button = '<button type="submit" class="btn btn-primary pull-right" disabled="disabled">Add Product</button>';
	include 'addproduct.html.php';
	exit();  
  }// end if user is not logged in
  mysqli_close($con);
?>
