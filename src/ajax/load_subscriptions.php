<?php
	session_start();
	include('../models/Database.php');
	
	$database = new Database();

	$user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
	$user_id = $user_id_query[0]['memberid'];

	$cat = $database->query("Select * from category;");
	$current_sub = $database->query("select articleid from followarticle where memberid=$user_id");

	echo "<h1 id='title'>Subscriptions</h1>";	
	for($count = 0; $count < sizeOf($cat); $count++){
		$id		= $cat[$count]['categoryid'];
		$name		= $cat[$count]['name'];
		$created	= $cat[$count]['created'];
		$nummembers	= $cat[$count]['nummembers'];
		$numarticles	= $cat[$count]['numarticles'];
		$numcontent	= $cat[$count]['numcontents'];
		$description	= $cat[$count]['description'];

		if($count % 2 == 0)
			$class  = "even";
		else
			$class  = "odd";

		echo    "<div class='content $class'> 
				<div class='subcat'>                                                                           
					<p class='name'>$name</p>
					<p class='description'>Description: $description</p>
				</div>
			";
		$articles = $database->query("Select * from article where categoryid=$id");
		
		for($x = 0; $x < sizeOf($articles); $x++){
			$id 		= $articles[$x]['articleid'];
			$name 		= $articles[$x]['name'];
			$created 	= $articles[$x]['created'];
			$description 	= $articles[$x]['description'];
			
			$already_sub = false;
			for($z = 0; $z < sizeOf($current_sub); $z++){
				if($id == $current_sub[$z]['articleid']){
					$already_sub = true;
					break;
				}
			}
	
			if($already_sub){
				$button_class 	= "unsubButton";
				$icon		= "glyphicon-remove";
				$text		= " Unsubscribe";
			} else{	
				$button_class 	= "subButton";
				$icon		= "glyphicon-ok";
				$text		= " Subscribe";
			}	
	
			echo "
				<div class='subcat subart'>
					<p class='name'>$name</p>
					<p class='description'>Description: $description</p>

					<button class='btn btn-default btn-xs $button_class' data-id='$id'>
						<span class='glyphicon $icon'>$text</span>
					</button>
				</div>
			";
		}

		echo 	"</div>";
	}
?>

<script>
	$(document).ready(function(){
	        $(".subcat button").click(function(){
        		if($(this).children().attr("class") == "glyphicon glyphicon-ok"){
                		$(this).children().removeClass("glyphicon-ok");
                		$(this).children().addClass("glyphicon-remove");
				$(this).children().text(" Unsubscribe");
				$(this).removeClass("subButton");
				$(this).addClass("unsubButton");

				$.ajax({
					type: "GET",
					url: "ajax/add_sub.php?id=" + $(this).attr("data-id"),
					async: false,
					success: function(text){
						response = text;
					}
				});
        		}else if($(this).children().attr("class") == "glyphicon glyphicon-remove"){
                		$(this).children().removeClass("glyphicon-remove");
                		$(this).children().addClass("glyphicon-ok");
				$(this).children().text(" Subscribe");
				$(this).removeClass("unsubButton");
				$(this).addClass("subButton");

				$.ajax({
					type: "GET",
					url: "ajax/remove_sub?id=" + $(this).attr("data-id"),
					async: false,
					success: function(text){
						response = text;
					}
				});
        		}
		});
	});
</script>
