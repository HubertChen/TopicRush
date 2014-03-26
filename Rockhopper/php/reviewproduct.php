<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>


<?php
  $productid= $_GET["id"];
  $memberid = $_SESSION["memberid"];
  echo "Product = " . $productid . "<br>";
  echo "Member = " . $memberid . "<br>";



  $action = '<form action="process_review.php?id=' . $productid . '" method="post" enctype="multipart/form-data">';
  echo $action;

?>
Review: <input type="text" name="review"><br>
Rating:
<select name="rating">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
<br>
<input type="submit" value="Submit">
<br>
<a href="http://localhost/index.php">Back to Home Page</a> 

</form>
</body>
</html>
