<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<?php
  $communityid= $_GET["id"];
  echo "Community = " . $communityid . "<br>";
  $action = '<form action="addnew_topic.php?id=' . $communityid . '" method="post" enctype="multipart/form-data">';
  echo $action;
?>
Topic Name: <input type="text" name="topicname"><br>
Product:
<select name="product">
<option value="none">None</option>
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

   $result = mysqli_query($con,"select productid,name  from product");
   foreach($result as $row) {
      echo '<option value="'.$row['productid'].'"';
      echo '>'. $row['name'] . '</option>'."\n";
   }
   mysqli_close($con);  
?>
</select><br>
Add Content:
<input type="radio" name="content" value="Yes" checked>Yes
<input type="radio" name="content" value="No">No<br>
Message: <input type="text" name="message"><br>
Add File:
<input type="radio" name="addfile" value="No" checked>No
<input type="radio" name="addfile" value="Yes">Yes<br>
<label for="file">Picture:</label>
<input type="file" name="file" id="file"><br>
Description: <input type="text" name="picdesc"><br>
<input type="submit" value="Create"><br>
<a href="http://localhost/index.php">Back to Home Page</a> 

</form>
</body>
</html>
