<?php
	session_start();
	include('../models/Database.php');
	
	$database = new Database();
	$category_id = $_GET['catid'];
	$article_id  = $_GET['articleid'];

	$user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
	$user_id = $user_id_query[0]['memberid'];

	if($category_id == 0 && $article_id == 0){
		$title = "All";

		$articles = $database->query("
        	   	select content.* from followarticle inner join content on 
               		followarticle.articleid = content.articleid and 
                	followarticle.memberid = " . $user_id . " limit 30;                                                             
		");
	} else if($article_id != 0){
		$title = $database->query("
			select name from article where articleid = $article_id;
		");
		$title = $title[0]['name'];

		$articles = $database->query("
			select * from content where articleid = $article_id limit 30;
		");
	} else{
		$title = $database->query("
			select name from category where categoryid = $category_id;
		");
		$title = $title[0]['name'];

		$articles = $database->query("
			select content.* from content inner join article on article.articleid = content.articleid
			inner join followarticle on followarticle.memberid = content.ownerid 
			where content.ownerid = $user_id and
			article.categoryid = $category_id
			limit 30;
		");
	}

	echo "<h1 id='title'>$title</h1>";	
	for($count = 0; $count < sizeOf($articles); $count++){
		$title          = $articles[$count]['message'];
		$owner_id       = $articles[$count]['ownerid'];
		$article_id     = $articles[$count]['articleid'];
		$content_id     = $articles[$count]['contentid'];
		$rating         = $articles[$count]['rating'];

		$author         = $database->query("SELECT username from member where memberid = '$owner_id';");
		$community      = $database->query("SELECT name from article where articleid = $article_id;");

		if($count % 2 == 0)
			$class  = "even";
		else
			$class  = "odd";

		echo    "<div class='content $class'> 
				<div id='articleRating' class='btn-group-vertical'>
					<button class='btn btn-success btn-xs' class='articleUpvote' data-id='$article_id'>
						<span class='glyphicon glyphicon-chevron-up'></span>
					</button>
					
					<button class='btn btn-danger btn-xs' class='articleDownvote' data-id='$article_id'>
						<span class='glyphicon glyphicon-chevron-down'></span>
					</button>
				</div>
				
				<div id='articleInformation'>                                                                           
					<p class='title'>$title</p>
					<p class='author'>By: " . $author[0]['username'] . "</p>
					<p class='points'>$rating points</p>
					<button class='btn btn-default btn-lg commentButton' data-id='$content_id'>
						<span class='glyphicon glyphicon-comment'></span>
					</button>
				</div>
			</div>";
	}
?>

<script>
	$(document).ready(function(){
		$(".commentButton").click(function(){
			$.ajax({
				type: "GET",
				url: "ajax/load_article.php?id=" + $(this).attr("data-id"),
				async: false,
				success: function(text){	
					response = text;
				}
			});
			$("#content2").empty();
			$("#content2").append(response);	
		});
	});
</script>
