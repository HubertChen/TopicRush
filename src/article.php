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
			
		<div class='bigreply'><a class="replyText">Reply</a></div>


		<div class="comments">
			<?php
				$comments = $database->query("SELECT * FROM comment where contentid='$article_id'");

				if(empty($comments))
					$comment_count = 0;
				else
					$comment_count = count($comments);
			?>
			<h1><?php echo $comment_count ?> Comments</h1>

			<?php
				$total_reply ="";

				for($x = 0; $x < $comment_count; $x++){
					$id		= $comments[$x]['commentid'];
					$response_id	= $comments[$x]['responseid'];
					$score          = $comments[$x]['score'];
                                        $user_id        = $comments[$x]['memberid'];
                                        $date           = $comments[$x]['date'];
                                        $message        = $comments[$x]['message'];
        
                                        $username_query = $database->query("SELECT username from member where memberid='$user_id'");
                                        $username       = $username_query[0]['username'];
			
					if($response_id == -1){
						$total_reply .= "<div class='bigreply'>";
                                       		$total_reply .=
                                                	"<div class='reply' id='$id'>
                                                        	<span><i class='fa fa-child'> </i> $username ($score) $date</span>
	                                                        <p class='replymessage'>$message</p>
								<a class='replyText'>Reply</a>
        	                                        </div>
							";

						$total_reply .= recursive_reply($id, $comments, "", $database, 1);
						$total_reply .= "</div>";	
					}
				}
				
				echo $total_reply;

				function recursive_reply($z, $comments, $total_reply, $database, $count){
					$total_reply = "";

					for($x = 0; $x < count($comments); $x++){
						$score 		= $comments[$x]['score'];
						$user_id 	= $comments[$x]['memberid'];
						$date 		= $comments[$x]['date'];
						$id		= $comments[$x]['commentid'];
						$message	= $comments[$x]['message'];
						$response_id	= $comments[$x]['responseid'];
	
						$username_query = $database->query("SELECT username from member where memberid='$user_id'");
						$username 	= $username_query[0]['username'];

						if($z == $response_id){
							$index = $count * 40 . "px";
							$total_reply .=
						       		"<div id='$id' class='reply' style='margin-left: $index;'>
						       			<span><i class='fa fa-child'></i> $username ($score) $date</span>
						       			<p class='replymessage'>$message</p>
									<a class='replyText'>Reply</a>
						       		</div>";
			
							$total_reply .= recursive_reply($id, $comments, $total_reply, $database, $count + 1);
						}
					}

					return $total_reply;
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
						url: "reply_ajax.php?content_id=" + <?php echo $article_id; ?> + "&response_id=" + $(this).closest("div").attr("id"),
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
