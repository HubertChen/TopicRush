<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<form action="addnew_product.php" method="post" enctype="multipart/form-data">
Product Name: <input type="text" name="productname"><br>
Description: <input type="text" name="description"><br>
Category:
<select name="category">
<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'delos2';
   $loggedon = FALSE;

   $con=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
   if (mysqli_connect_errno()) {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

   $result = mysqli_query($con,"select categoryid,name  from category");
   foreach($result as $row) {
      echo '<option value="'.$row['categoryid'].'"';
      echo '>'. $row['name'] . '</option>'."\n";
   }
   mysqli_close($con);  
?>
<option value="addnew">Add new</option>
</select>
<br>
New Category: <input type="text" name="newcategory"><br>
Retail Price: <input type="text" name="retailprice"><br>
Listed Price: <input type="text" name="listedprice"><br>
<label for="file">Picture:</label>
<input type="file" name="file" id="file"><br>
Description: <input type="text" name="picdesc"><br>
<?php
     if (isset($_SESSION['loggedin'])) {
        $userrole = $_SESSION['role'];
        if (($userrole == 's') || ($userrole == 'a')) { 
          echo '<input type="submit" value="Create">'; 
        } else {
          echo "You must be registered as a Seller!<br>";
        }
     } else {
        echo "You must be Logged in to perform this function!<br";
     }
?>


<br>
<a href="http://localhost/index.php">Back to Home Page</a> 

</form>
</body>
</html>
