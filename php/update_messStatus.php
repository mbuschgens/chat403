<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];
$update_message_status = $_REQUEST['update_message_status'];
$chat_message_id = $_REQUEST['chat_message_id'];

$query = "
UPDATE chat_messages_log
SET chat_message_status = '".$update_message_status."',
chat_message_timetoupdate = '0'
WHERE chat_message_id = '".$chat_message_id."'
";

$statement = $connect->prepare($query);
$statement->execute($data);

if ($update_message_status === '4'){

	// delete row.
	$query = "
	DELETE FROM chat_messages_log
	WHERE chat_message_status = '4'
	";

	$statement = $connect->prepare($query);
	$statement->execute();


}




echo 'UPDATED to ! : ' .$update_message_status;

?>
