<?php
        session_start();

        include("../models/Database.php");

        $database = new Database();
        $article_id = $_GET['id'];
        $user_id_query = $database->query("select memberid from member where username ='" . $_SESSION['username'] . "';");
        $user_id = $user_id_query[0]['memberid'];

        $database->insert("delete from followarticle where memberid =$user_id and articleid=$article_id;");
?>

