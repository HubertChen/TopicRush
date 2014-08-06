<?php
        session_start();
        include('../models/Database.php');

        $database = new Database();
        $content_id  = $_GET['id'];

        $user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
        $user_id = $user_id_query[0]['memberid'];

	$content = $database->query("select * from content where contentid = $content_id");

	$article_id	= $content[0]['contentid'];
	$ownerid 	= $content[0]['ownerid'];
	$message 	= $content[0]['message'];
	$description 	= $content[0]['description'];
	$created 	= $content[0]['created'];
	$rating		= $content[0]['rating'];

	$author         = $database->query("SELECT username from member where memberid = '$user_id';");
	$author		= $author[0]['username'];

	echo 	"
		<div>
			<div class='contentheader'>
				<h1 id='title'>$message</h1>
				<p class='description'>$description</p>
				<p class='author'>By: $author</p>
				<button class='replyText btn btn-default btn-xs' data-toggle='modal' data-target='#myModal'>Reply</button>
			</div>
			
			<div class='contentcomments'>
				<h1 id='title2'>Comments</h1>
				<div id='replyResponse'></div>
		";

	$comments = $database->query("select * from comment where contentid=$content_id;");
	
	$total_reply ="";

	for($x = 0; $x < sizeOf($comments); $x++){
		$id             = $comments[$x]['commentid'];
		$response_id    = $comments[$x]['responseid'];
		$score          = $comments[$x]['score'];
		$user_id        = $comments[$x]['memberid'];
		$date           = $comments[$x]['date'];
		$message        = $comments[$x]['message'];

		if($response_id == -1){
			$total_reply .= "<div class='bigreply'>";
			$total_reply .=
				"<div class='reply' id='$id'>
					<p class='replymessage'>$message</p>
					<p class='username'><i class='glyphicon glyphicon-user'>$author</i></p>
					<button class='replyText btn btn-default btn-xs' data-toggle='modal' data-target='#myModal'>Reply</button>
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
		       $score          = $comments[$x]['score'];
		       $user_id        = $comments[$x]['memberid'];
		       $date           = $comments[$x]['date'];
		       $id             = $comments[$x]['commentid'];
		       $message        = $comments[$x]['message'];
		       $response_id    = $comments[$x]['responseid'];

		       $username_query = $database->query("SELECT username from member where memberid='$user_id'");
		       $username       = $username_query[0]['username'];

		       if($z == $response_id){
			       $index = $count * 40 . "px";
			       $total_reply .=
				       "<div id='$id' class='reply' style='margin-left: $index;'>
					       	<p class='replymessage'>$message</p>
						<p class='username'><i class='glyphicon glyphicon-user'>$username</i></p>
					        <button class='replyText btn btn-default btn-xs' data-toggle='modal' data-target='#myModal'>Reply</button>
				       </div>";

			       $total_reply .= recursive_reply($id, $comments, $total_reply, $database, $count + 1);
		       }
	       }

	       return $total_reply;
	}


	echo 	"
			</div>
		</div>
		";

?>

<script>
	$(document).ready(function(){
		$("#content2").show();
        	$(".replyText").click(function(){
                		$.ajax({
                        		type: "GET",
                        		url: "ajax/reply_ajax.php?content_id=" + <?php echo $article_id; ?> + "&response_id=" + $(this).closest("div").attr("id"),
                        		async: false,
                        		success: function(text){
                                		response = text;        
                        		}
                		}); 
                
			$(this).parent().after(response);
        	});
	});
</script>

