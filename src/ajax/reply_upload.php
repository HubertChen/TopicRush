<?php
/*
 * reply_upload 
 * 
 * Saves a comment to the database for the given article
 */
	session_start();
	include('../models/Database.php');

	$text = htmlspecialchars($_GET['text']);
	$content = $_GET['id'];
	$reply_id = $_GET['replyid'];
	$username = $_SESSION['username'];
	$database = new Database();

	$username_query = $database->query("SELECT memberid from member where username='$username';");
	$user_id = $username_query[0]['memberid'];

	if($database->insert("INSERT INTO comment(memberid, contentid, responseid, score, message) VALUES($user_id, $content, $reply_id, 0, '$text');"))
		echo "Comment success!";
	else
		echo "Comment failed!";
?>
