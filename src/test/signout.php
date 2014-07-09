<?php
/* 
 * Handles the user login process
 */ 
session_start();

if($_SESSION['loggedin'])
	session_destroy();

header('location:index.php');
?>
