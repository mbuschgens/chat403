<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

// echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);

echo fetch_user_chat_history($_REQUEST['from_user_id'], $_REQUEST['to_user_id'], $connect);



?>
