<section>
	<h3>DISPLAYING ARTICLES FROM COMMUNITIES ABOVE</h3> 	
</section>

<div class="article">
		<?php
			include('models/Database.php');
			$database = new Database();
			
			$articles = $database->query("SELECT * FROM content LIMIT 6;");

			for($count = 0; $count < sizeof($articles); $count++){
				$title 		= $articles[$count]['message'];
				$owner_id 	= $articles[$count]['ownerid'];
				$article_id 	= $articles[$count]['articleid'];


				$author 	= $database->query("SELECT username from member where memberid = '$owner_id';");
				$community 	= $database->query("SELECT name from article where articleid = $article_id;"); 

				if($count % 3 == 0)
					echo "<br>";
				echo "<article> 
				<img src='img/photo.png' alt='temp' class='articleImages'>
				<h4 id='titleOverlay' class='overlay'> <span>". $title ."</span> </h4>
				<h4 id='authorOverlay' class='overlay'> <span>". $author[0]['username'] ."</span> </h4>
				<h4 id='communityOverlay' class='overlay'> <span>". $community[0]['name'] ."</span> </h4>
				</article>";
			}
		?>
		<div id='loadMore'>
			<a class="btn1" href="#hubert" >LOAD MORE</a>
		</div>
</div>

