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
							<form class="navbar-form navbar-left" role="search" id="searchForm">
								<div class="input-group" id="search">
									<input class="form-control" type="text" name="search" placeholder="Search"></input>
									<span class="input-group-addon"><a href="#"><i class="glyphicon glyphicon-search"></i></a></span>
								</div>
							</form>

							<ul class="nav navbar-nav">
								<li class="active"><a href="#" id="newsfeedlink">News Feed</a></li>
								<li><a href="#" id="subscriptionslink">Subscriptions</a></li>
							</ul>



							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" id="user" data-toggle="dropdown">
										<i class="glyphicon glyphicon-user"></i>
										<?php echo $_SESSION['username']; ?>
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="login.php">Sign out</a></li>
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
				</div>

				<div class="col-xs-5" id="content2">
	
				</div>
			</div>
		</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
			
	<script>
		$(document).ready(function(){
			$("#content").load("ajax/load_main_content.php?catid=0&articleid=0");
			$("#content2").hide();
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

			$("#newsfeedlink").click(function(){
				$("#subscriptionslink").parent().removeClass("active");
				$(this).parent().addClass("active");
				
				$.ajax({
					type: "GET",
					url: "ajax/load_main_content.php?catid=0&articleid=0",
					async: false,
					success: function(text){
						response = text;
					}
				});
				$("#content").empty();
				$("#content").append(response);
			});

			$("#subscriptionslink").click(function(){
				$("#newsfeedlink").parent().removeClass("active");
				$(this).parent().addClass("active");

				$.ajax({
					type: "GET",
					url: "ajax/load_subscriptions.php",
					async: false,
					success: function(text){
						response = text;
					}
				});
				$("#content").empty();
				$("#content").append(response);
				$("#content2").hide();
			});

			$(".side .glyphicon").click(function(){
				if($(this).attr("class") == "glyphicon glyphicon-plus"){
					$(this).removeClass("glyphicon-plus");
                                        $(this).addClass("glyphicon-minus");
				}else {
					$(this).removeClass("glyphicon-minus");
                                        $(this).addClass("glyphicon-plus");
				}
			});

			$("#searchForm").submit(function(event){
				$.ajax({
					type: "GET",
					url: "ajax/load_main_content.php?search=" + $("input").val(),
					async: false,
					success: function(text){
						response = text;
					}
				});
				$("#content").empty();
				$("#content").append(response);

				event.preventDefault();
			});

			$(".glyphicon-search").click(function(){
				$("#searchForm").submit();
			});
		});
	</script>
	</body>
</html>
