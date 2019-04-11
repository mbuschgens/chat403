<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];


										$query = "
										SELECT * FROM chat_message
										WHERE from_user_id = '$to_user_id'
										AND to_user_id = '$from_user_id'
										AND status = '1'
										";
										$statement = $connect->prepare($query);
										$statement->execute();
										$count = $statement->rowCount();





										if($count > 0)
										{
$waitingmessages =  $count;
										}
										else {
$waitingmessages = "0";
										}


$rows[] = array(
'waitingmessages'		=>	$waitingmessages
);




    echo json_encode($rows);



?>
