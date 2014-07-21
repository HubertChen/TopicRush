<?php
include('models/Database.php');
$database = new Database();
$count = $_GET['count'];

$articles = $database->query("SELECT * FROM content LIMIT " . $count . ", 6;");

for($count = 0; $count < 6; $count++){
        $title          = $articles[$count]['message'];
        $owner_id       = $articles[$count]['ownerid'];
        $article_id     = $articles[$count]['articleid'];
	$content_id	= $articles[$count]['contentid'];

        $author         = $database->query("SELECT username from member where memberid = '$owner_id';");
        $community      = $database->query("SELECT name from article where articleid = $article_id;");

	if(empty($title)){
		echo "<h4 style='color: #505050; margin-bottom:3px;'>Reached the end!</h4>";
		break;
	}

        if($count % 3 == 0)
                echo "<br>";

        echo "<article> 
        <a href='#article.php?id=$content_id'><img src='img/photo.png' alt='temp' class='articleImages'></a>
        <h4 id='titleOverlay' class='overlay'> <span>". $title ."</span> </h4>
        <h4 id='authorOverlay' class='overlay'> <span>". $author[0]['username'] ."</span> </h4>
        <h4 id='communityOverlay' class='overlay'> <span>". $community[0]['name'] ."</span> </h4>
        </article>";
}
?>
