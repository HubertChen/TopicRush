<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<body>

<?php
  $communityid= $_GET["community"];
  $topicid = $_GET["topic"];
  echo "Community,Topic = " . $communityid . "," . $topicid . "<br>";
  $action = '<form action="addnew_content.php?community=' . $communityid . '&topic=' . $topicid . '" method="post" enctype="multipart/form-data">';
  echo $action;
?>
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
