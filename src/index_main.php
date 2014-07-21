<section>
	<h3>DISPLAYING ARTICLES FROM COMMUNITIES ABOVE</h3> 	
</section>

<div id="articles">
		<?php
			include('models/Database.php');
			$database = new Database();
			
			$articles = $database->query("SELECT * FROM content LIMIT 6;");

			for($count = 0; $count < 6; $count++){
				$title 		= $articles[$count]['message'];
				$owner_id 	= $articles[$count]['ownerid'];
				$article_id 	= $articles[$count]['articleid'];


				$author 	= $database->query("SELECT username from member where memberid = '$owner_id';");
				$community 	= $database->query("SELECT name from article where articleid = $article_id;"); 

				if($count % 3 == 0)
					echo "<br>";
				echo "<article> 
				<a href='#article.php?id=$article_id'><img src='img/photo.png' alt='temp' class='articleImages'></a>
				<h4 id='titleOverlay' class='overlay'> <span>". $title ."</span> </h4>
				<h4 id='authorOverlay' class='overlay'> <span>". $author[0]['username'] ."</span> </h4>
				<h4 id='communityOverlay' class='overlay'> <span>". $community[0]['name'] ."</span> </h4>
				</article>";
			}

			echo "<br>";
		?>
</div>

<div id='load'>
	<a class="btn1" id="loadmore">LOAD MORE</a>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		var count = 6;
		$("#loadmore").click(function(){
			$.ajax({
				type: "GET",
				url: "index_ajax.php?count=" + count,
				async: false,
				success: function(text){
					response = text;	
				}
			});
			$("#articles").append(response);
			count += 3;
		});
	});
</script>
