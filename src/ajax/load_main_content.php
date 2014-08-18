<?php
/*
 * load_main_content : AJAX call to update main panel
 * 
 * Lists different articles that the user is subscribed to
 */
	session_start();
	include('../models/Database.php');
	
	$database = new Database();
	$category_id = $_GET['catid'];
	$article_id  = $_GET['articleid'];
	$search	     = $_GET['search'];

	$user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
	$user_id = $user_id_query[0]['memberid'];

	if($search){
		$title = "Search";
		
		$articles = $database->query("
			select * from content where message like '%$search%' order by rating desc limit 30;
		");
	} else if($category_id == 0 && $article_id == 0){
		$title = "All";

		$articles = $database->query("
        	   	select content.* from followarticle inner join content on 
               		followarticle.articleid = content.articleid and 
                	followarticle.memberid = " . $user_id . " order by content.rating desc limit 30;                                                             
		");
	} else if($article_id != 0){
		$title = $database->query("
			select name from article where articleid = $article_id;
		");
		$title = $title[0]['name'];

		$articles = $database->query("
			select * from content where articleid = $article_id order by rating desc limit 30;
		");
	} else{
		$title = $database->query("
			select name from category where categoryid = $category_id;
		");
		$title = $title[0]['name'];

		$articles = $database->query("
			select distinct content.* from content inner join article on article.articleid = content.articleid
                        inner join followarticle on content.articleid = followarticle.articleid and followarticle.memberid = '$user_id'
                        where article.categoryid = '$category_id' order by content.rating desc limit 30;
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

		$user_voted	= $database->query("SELECT * from contentvote where memberid=$user_id and contentid=$content_id");

		$points_style = "";
		if(isset($user_voted)){
			if($user_voted[0]['vote'] == 1){
				$points = $rating . " points (+1)";
				$points_style = "color: #5cb85c;";
			} else{
				$points = $rating . " points (-1)";
				$points_style = "color: #d9534f;";
			}
		} else{
			$points = $rating . " points";
		}

		if($count % 2 == 0)
			$class  = "even";
		else
			$class  = "odd";

		echo    "<div class='content $class'> 
				<div id='articleRating' class='btn-group-vertical'>
					<button class='btn btn-success btn-xs articleUpvote' data-id='$article_id' data-contentID= '$content_id'>
						<span class='glyphicon glyphicon-chevron-up'></span>
					</button>
					
					<button class='btn btn-danger btn-xs articleDownvote' data-id='$article_id' data-contentID='$content_id'>
						<span class='glyphicon glyphicon-chevron-down'></span>
					</button>
				</div>
				
				<div id='articleInformation'>                                                                           
					<p class='title'>$title</p>
					<p class='author'>By: " . $author[0]['username'] . "</p>
					<p class='points' data-rating='$rating' style = '$points_style'>$points</p>
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

	        $(".articleUpvote").click(function(){
			var pointsNode = $(this).parent().parent().find(".points");
			var currentRating = parseInt(pointsNode.attr("data-rating"));

			$.ajax({
                                type: "GET",
                                url: "ajax/vote_article.php?id=" + $(this).attr("data-contentid") + "&vote=1&currentRating=" + currentRating,
                                async: false,
                                success: function(text){        
                                        response = text;
                                }
                        });

			pointsNode.css("color", "#5cb85c");
			pointsNode.attr("data-rating", response);
			pointsNode.text(response + " points (+1)");
                });

		$(".articleDownvote").click(function(){
			var pointsNode = $(this).parent().parent().find(".points");
                        var currentRating = parseInt(pointsNode.attr("data-rating"));

			$.ajax({
                                type: "GET",
                                url: "ajax/vote_article.php?id=" + $(this).attr("data-contentid") + "&vote=0&currentRating=" + currentRating,
                                async: false,
                                success: function(text){        
                                        response = text;
                                }
                        });

                        pointsNode.css("color", "#d9534f");
                        pointsNode.attr("data-rating", response);
                        pointsNode.text(response + " points (-1)");
		});

	});
</script>
