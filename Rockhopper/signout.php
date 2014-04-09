<!-- DONE: 4/6/14 -->
<?php session_start(); ?>


<?php
	
	session_destroy();
   
    //Optional error message
	$errorMessage = '
					<p>&nbsp;</p>
      				<p>&nbsp;</p>
					<div class="alert alert-success alert-dismissable" align="center">
     				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					Successfully sign out, come back soon!
					</div>'
				;			
		
		
		//header("Location: http://localhost/rockhopper/index.php");
		include 'index.php';
		exit();
		
?>

