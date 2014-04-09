<!-- DONE: 4/8/14 -->
<!DOCTYPE html>
<html lang="en">
  <head>
  
  	<!-- Need to add necessary meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Circle<?php 
	
						$communityid = 0;
  						if (isset($_GET["id"])) { $communityid = $_GET["id"]; }
  						$communityname = "";

  						$sql = 'select name from community where communityid=' . $communityid;
  						$result = mysqli_query($con,$sql);
  						while($row = mysqli_fetch_array($result)) {
    						$validcommunityid = TRUE;
    						$communityname = $row["name"]; 
  						}
  						echo ' | ' . $communityname; 
						//Might need to add back
  						//mysqli_close($con);	
				?>
 	</title>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
  </head>
              
            
  <!-- NAVBAR
  ================================================== -->
  <body style="background-color:#7aadd9">
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
          		<form class="navbar-form navbar-form-length"  role="search" action="search.php" method="post">
            		<div class="form-group">
              			<input type="text" name="search" class="form-control" placeholder="Search for communities, topics, and products" size="70" maxlength="70" required>
            		</div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            		<?php echo $navbar; ?>
  				</form>
  			</div>
  		</div>
  	</div>
    
    
    <!-- Look at grid layouts on Bootstrap: http://getbootstrap.com/css/#grid -->
  	<div class="container" style="background-color:rgb(255, 255, 255)">
   		<p>&nbsp;</p>
        <p>&nbsp;</p>
    	<?php echo $errorMessage; ?>
		
        <div class="row">
        	<div class="col-md-12">
            	<table align="center">
                	<tr>
                    	<td>
                        	<div>
                            	<ul class="nav masthead-nav">
                                	<li><a href="community.php">Community</a></li>
                                    <li><a href="topic.php">Topic</a></li>
                                    <li><a href="product.php">Product</a></li>
                                </ul>
                           	</div>
                  		</td>
               		</tr>
           		</table>
			</div> 
        </div>
        
        <div class="row">
        	<div class="col-md-3">
            	<table align="center">
                	<tr>
						<td align="center"><img class="img-circle"  img src="<?php echo $communityimage; ?>" width="150" height="150" alt="Generic placeholder image"></td>
					</tr>
					<tr>
						<td align="center">Members: <?php echo $nummembers; ?></td>
                    </tr>
				</table>
           	</div>
            <div class="col-md-9">
            	<table>
                	<tr>
                    	<td>&nbsp;<h1><?php echo $communityname; ?>&nbsp;<?php echo $btnState; ?></h1></td>
                    </tr>
					<tr>
						<td>
							<p>Created: <?php  echo $created; ?> by <?php echo $ownername; ?></p><br/> 
                        </td>'
					</tr>
				</table>
			</div>
		</div>
        <hr/>
		<div class="row">
			<div class="col-md-8"><h4>Topics &nbsp;<?php echo $createtopic ; ?>&nbsp;<?php echo $adminpage; ?></h4></div>
            <?php echo $notopic; ?>