<?php session_start(); ?>


<?php
   session_destroy();
   
$errorMessage = '
					<p>&nbsp;</p>
      				<p>&nbsp;</p>
					<div class="alert alert-success alert-dismissable" align="center">
     				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					Successfully sign out, come back soon!
					</div>'
				;			
		
		include 'index.php';
		exit();
		
?>

