<?php

// header("Acces-Control-Allow-Origin: *");
// Header("Content-Type: application/x-javascript; charset=UTF-8");
include('database_connection.php');

session_start();


$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];


$data = array(
':to_user_id'		=>	$_REQUEST['to_user_id'],
':from_user_id'		=>	$_REQUEST['from_user_id'],
':chat_message'		=>	$_REQUEST['chat_message'],
':timestamp'		=>	$_REQUEST['timestamp'],
':text'		=>	$_REQUEST['text'],
':header'		=>	$_REQUEST['header'],
':footer'		=>	$_REQUEST['footer'],
':name'		=>	$_REQUEST['name'],
':avatar'		=>	$_REQUEST['avatar'],
':type'		=>	$_REQUEST['type'],
':textHeader'		=>	$_REQUEST['textHeader'],
':textFooter'		=>	$_REQUEST['textFooter'],
':image'		=>	$_REQUEST['image'],
':imageSrc'		=>	$_REQUEST['imageSrc'],
':isTitle'		=>	$_REQUEST['isTitle'],
':cssClass'		=>	$_REQUEST['cssClass'],
':attrs'		=>	$_REQUEST['attrs'],
':status'			=>	'1',
':newStatus'			=>	'1'
);


// $query = "
// INSERT INTO chat_message
// (to_user_id, from_user_id, chat_message, timestamp, text, header, footer, name, avatar, type, textHeader, textFooter, image, imageSrc, isTitle, cssClass, attrs, newStatus, status)
// VALUES (:to_user_id, :from_user_id, :chat_message, :timestamp, :text, :header, :footer, :name, :avatar, :type, :textHeader, :textFooter, :image, :imageSrc, :isTitle, :cssClass, :attrs, :newStatus, :status)
// ";

$query = "
INSERT INTO chat_message
(to_user_id, from_user_id, chat_message, timestamp, text, header, footer, name, avatar, type, textHeader, textFooter, image, imageSrc, isTitle, cssClass, attrs, newStatus, status)
VALUES (:to_user_id, :from_user_id, :chat_message, :timestamp, :text, :header, :footer, :name, :avatar, :type, :textHeader, :textFooter, :image, :imageSrc, :isTitle, :cssClass, :attrs, :newStatus, :status)
";

$statement = $connect->prepare($query);
if($statement->execute($data))

$chat_message_id = $connect->lastInsertId();

$query = "
INSERT INTO chat_messages_log
(from_user_id, to_user_id, chat_message_id, chat_message_status, chat_message_timetoupdate)
VALUES ('$from_user_id', '$to_user_id', $chat_message_id, '1', '1')
";

$statement = $connect->prepare($query);
if($statement->execute($data))

$message_to_send = '';

{

//echo fetch_user_chat_history($_REQUEST['from_user_id'], $_REQUEST['to_user_id'], $connect);

 //sent_notification($_REQUEST['from_user_id'], $_REQUEST['to_user_id'], $message_to_send, $connect);

echo $chat_message_id;
// echo $query;
//echo $_REQUEST['from_user_id'] . " : " .$_REQUEST['to_user_id'] . " : " .$_REQUEST['timestamp'];

}

?>
