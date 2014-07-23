<!DOCTYPE html>
<?php
	include('models/Database.php');
	$database = new Database();

	$content_id = $_GET['id'];
	$content = $database->query("Select * from content where contentid = $content_id;");

	$article_id 	= $content[0]['articleid']; 
	$owner_id 	= $content[0]['ownerid'];
	$message 	= $content[0]['message'];
	$description 	= $content[0]['description'];
	$created 	= $content[0]['created'];

	$article_query 	= $database->query("SELECT name from article where articleid = $article_id;");
	$article	= $article_query[0]['name'];
	$owner_query 	= $database->query("SELECT username from member where memberid = '$owner_id';");
	$owner		= $owner_query[0]['username'];
?>
<html>
	<head>
		<title><?php echo $article . ": " . $message?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/reset.css" rel="stylesheet" media="screen">
		<link href="css/main.css" rel="stylesheet" media="screen">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	</head>

	<!-- body classes are important to css -->
	<body class="bodypage">		
		<?php include 'header.php' ?>

		<article class='content'>
			<img src='img/photo.png' alt='temp' class='articleImages' align='left'>

			<h1><?php echo $message ?></h1>
			<h2><?php echo $created . " | by " . $owner?></h2>
			
			<br>
			
			<p><?php echo $description ?></p>
			
		</article>
			
		<p class="replyText">Reply</p>


		<div class="comments">
			<?php
				if(empty($comments))
					$comment_count = 0;
				else
					$comment_count = count($comments);
			?>
			<h1><?php echo $comment_count ?> Comments</h1>

			<?php
				for($x = 0; $x < $comment_count; $x++){
					$score 		= $comments[$x]['score'];
					$username 	= $comments[$x]['username'];
					$date 		= $comments[$x]['date'];
					echo "<p><i class='fa fa-child'></i>($score)$username$date</p>";
						
				}
			?>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$(".replyText").click(function(){
				if($(this).next().attr("class") != "replydiv"){
				$.ajax({
					type: "GET",
					url: "reply_ajax.php",
					async: false,
					success: function(text){
						response = text;        
					}
				});
				$(this).after(response);
				}
			});
        	});
		</script>

		<?php include 'footer.php'?>
	</body>
</html>
