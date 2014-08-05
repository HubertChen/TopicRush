<?php 
	session_start(); 

	if($_SESSION['loggedin'] != TRUE)
		header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>TopicRush - Home Page</title>
		
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet" media="screen">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	</head>

	<body id="indexBody">
		<div class="container-fluid">
			<div class="row" id="base">
				<!-- Navbar -->
				<nav class="navbar navbar-inverse" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        								<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								</button>
							<a class="navbar-brand" href="index.php" id="brand">TopicRush</a>
    						</div>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#">News Feed</a></li>
								<li><a href="#">Subscriptions</a></li>
							</ul>

							<form class="navbar-form navbar-left" role="search">
								<div class="input-group" id="search">
									<input class="form-control" type="text" name="search" placeholder="Search"></input>
									<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
								</div>
							</form>

							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" id="user" data-toggle="dropdown">
										<i class="glyphicon glyphicon-user"></i>
										<?php echo $_SESSION['username']; ?>
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Profile</a></li>
										<li><a href="login.php">Sign out</a></li>
										<li class="divider"></li>
										<li><a href="#">Settings</a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			
				<div class="col-xs-1 side">
					<div class="fixed" id="sidebar">
							<h1 id="subscription">SUBSCRIPTIONS</h1>
							<span> 
								<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#all">
									<span class="glyphicon glyphicon-minus"></span>
								</button>
								<a href="#">
  									All
								</a>
							</span>
							<div id="all" class="collapse in"></div>
				
					</div>
				</div>
			
				<div class="col-xs-5" id="content">
					<?php
						echo "<h1 id='title'>All</h1>";
			                        include('models/Database.php');
                			        $database = new Database();
						
						$user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
						$user_id = $user_id_query[0]['memberid'];

                       				$articles = $database->query(
								"select content.* from followarticle inner join content on 
								followarticle.articleid = content.articleid and 
								followarticle.memberid = " . $user_id . " limit 30;								
						");
						
						

                        			for($count = 0; $count < sizeOf($articles); $count++){
		                                	$title          = $articles[$count]['message'];
        			                        $owner_id       = $articles[$count]['ownerid'];
               	     			      		$article_id     = $articles[$count]['articleid'];
			                                $content_id     = $articles[$count]['contentid'];
							$rating		= $articles[$count]['rating'];

                                			$author         = $database->query("SELECT username from member where memberid = '$owner_id';");
                                			$community      = $database->query("SELECT name from article where articleid = $article_id;");

							if($count % 2 == 0)
								$class  = "even";
							else
								$class  = "odd";

                                			echo 	"<div class='content $class'> 
									<div id='articleRating' class='btn-group-vertical'>
										<button class='btn btn-success btn-xs' id='articleUpvote'>
                                                                                        <span class='glyphicon glyphicon-chevron-up'></span>
                                                                                </button>
										
										<button class='btn btn-danger btn-xs' id='articleDownvote'>
                                                                                        <span class='glyphicon glyphicon-chevron-down'></span>
                                                                                </button>
									</div>
									
									<div id='articleInformation'>										
										<p class='title'>$title</p>
										<p class='author'>By: " . $author[0]['username'] . "</p>
										<p class='points'>$rating points</p>
										<button class='btn btn-default btn-lg' id='commentButton'>
											<span class='glyphicon glyphicon-comment'></span>
										</button>
									</div>
 			                                	</div>";
                        			}

					?>
			
					<a href="#">LOAD MORE</a>		
				</div>
			</div>
		</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
			
	<script>
		$(document).ready(function(){
			/*
			 * Loads the user sidebar content
			 */
			$.ajax({
				type: "GET",
				url: 'ajax/sidebar_content.php',
				async: false,
				success: function(text){
					response = text;
				}
			});			
			$("#all").append(response);

			$(".side a").click(function(){
				var id = $(this).attr("href");
				var catID;
				var articleID;
				var lastHash = id.lastIndexOf("#");
				
				if(id.length == 1){
					catID = 0;
					articleID = 0;
				}else if(lastHash == 0){
					catID = id.substring(lastHash + 1);
					articleID =  0;
				}else{
					catID = id.substring(1, lastHash);
					articleID = id.substring(lastHash + 1);
				}

				$.ajax({
					type:"GET",
					url: "ajax/load_main_content.php?catid=" + catID + "&articleid=" + articleID,
					async: false,
					success: function(text){
						response = text;
					}		
				});
				$("#content").empty();
				$("#content").append(response);
			});
	
			$(".glyphicon").click(function(){
				if($(this).parent().parent().next().attr("class") == "collapse"){
					$(this).removeClass("glyphicon-plus");
                                        $(this).addClass("glyphicon-minus");
				}else if($(this).parent().parent().next().attr("class") == "collapse in"){
					$(this).removeClass("glyphicon-minus");
                                        $(this).addClass("glyphicon-plus");
				}
			});

			
		});
	</script>
	</body>
</html>
