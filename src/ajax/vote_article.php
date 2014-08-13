<?php
	session_start();
        include('../models/Database.php');

        $database = new Database();
        $content_id  = $_GET['id'];
	$vote = $_GET['vote'];
	$current_rating = $_GET['currentRating'];

        $user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
        $user_id = $user_id_query[0]['memberid'];

	$user_voted_query = $database->query("select * from contentvote where memberid=$user_id and contentid= $content_id;");
	
	if(isset($user_voted_query)){
		$user_current_vote = $user_voted_query[0]['vote'];

		//User hits upvote content
		if($vote == 1){
			// User's already voted no
			if($user_current_vote == 0){
				$current_rating += 2;
				$database->insert("update contentvote set vote = 1 where memberid = $user_id and contentid = $content_id");
				$user_current_vote = 1;
				$database->insert("update content set rating = $current_rating where contentid = $content_id");
			}
		} else{
			// User's already voted yes
			if($user_current_vote == 1){
				$current_rating -= 2;
				$database->insert("update contentvote set vote = 0 where memberid = $user_id and contentid = $content_id");
				$user_current_vote = 0;
				$database->insert("update content set rating = $current_rating where contentid = $content_id");
			}
		}

		echo $current_rating;
	} else{
		$database->insert("insert into contentvote(memberid, contentid, vote) values($user_id, $content_id, $vote);");
		
		if($vote == 0)
			$current_rating -= 1;
		else
			$current_rating += 1;

		$database->insert("update content set rating = $current_rating where contentid = $content_id");

		echo $current_rating;
	}
?>
