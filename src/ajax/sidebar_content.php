<?php
/* 
 * load_sidebar_content
 * 
 * Loads the navigation window of different Categories and Articles
 */
	session_start();

	include("/vagrant/src/models/User.php");
	$user = User::with_username($_SESSION['username']);
	$categories = $user->get_categories();
	$articles = $user->get_articles();

	$append = "";
	for($x = 0; $x < sizeOf($categories); $x++){
		$category_name 	= $categories[$x]['categoryname'];
		$category_id 	= $categories[$x]['categoryid'];

		$append .= 	"
				<span class='insideCat'>
					<button type=button' class='btn btn-default' data-toggle='collapse' data-target='#$category_name'>
						<span class='glyphicon glyphicon-plus'></span>
					</button>
					<a href='#$category_id'>
						$category_name
					</a>
				</span>
				";
		$append .= "<div id='$category_name' class='collapse'>";
		
		for($y = 0; $y < sizeOf($articles); $y++){
			if($articles[$y]['categoryname'] === $category_name){
				$article_id = $articles[$y]['articleid'];
				$append .= "	<div class='article'><a href='#$category_id#$article_id'>" .
							$articles[$y]['articlename']
						. "</a></div>";
			}
		}

		$append .= "</div>";
	}

	echo $append;
?>
