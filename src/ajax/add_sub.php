<?php
/*
 * add_sub : Saves Subscription
 * 
 * Script is caled when a user clicks the "Subscribe" button to follow an article
 */
	session_start();

	include("../models/Database.php");
		
	$database = new Database();
	$article_id = $_GET['id'];
        $user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
        $user_id = $user_id_query[0]['memberid'];

	$database->insert("insert ignore into followarticle(memberid, articleid) values ($user_id, $article_id);");
?>
