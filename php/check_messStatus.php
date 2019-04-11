<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 

include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT * FROM chat_messages_log
WHERE (to_user_id = '".$to_user_id."'
AND from_user_id = '".$from_user_id."'
AND chat_message_timetoupdate = '1')
ORDER BY chat_message_id DESC
LIMIT 1
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();


		foreach($result as $row)
		{
			$chat_message_log = $row['chat_message_log'];
			$chat_message_id = $row['chat_message_id'];
			$chat_message_status = $row['chat_message_status'];

				$rows = array(
				'chat_message_log'		=>	$row['chat_message_log'],
				'chat_message_id'		=>	$row['chat_message_id'],
			  'to_user_id'		=>	$row['to_user_id'],
			  'from_user_id'		=>	$row['from_user_id'],
			  'chat_message_status'		=>	$row['chat_message_status'],
				'timestamp' => $row["timestamp"]
				);

		}


if(!$rows){



}
else
{

	// $query = "
	// UPDATE chat_messages_log
	// SET chat_message_status = '3'
	// WHERE (chat_message_id = '".$chat_message_id."')
	// ";

// if( $chat_message_status == '2'){
// 	$query = "
// 	UPDATE chat_messages_log
// 	SET chat_message_status = '3'
// 	WHERE (chat_message_id = '".$chat_message_id."')
// 	";
// }

// if( $chat_message_status == '3'){
// 	$query = "
// 	UPDATE chat_messages_log
// 	SET chat_message_status = '4'
// 	WHERE (chat_message_id = '".$chat_message_id."')
// 	";
// }


	// $statement = $connect->prepare($query);
	// $statement->execute();

	echo json_encode($rows);

}





		//echo $row['chat_message_id']
?>
