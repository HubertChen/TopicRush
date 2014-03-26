<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<?php
  $productid= $_GET["id"];
  $action = '<form action="addnew_detail.php?id=' . $productid . '" method="post" enctype="multipart/form-data">';
  echo $action;
?>
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
