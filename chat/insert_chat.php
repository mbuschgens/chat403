<?php

//insert_chat.php

include('database_connection.php');

session_start();

$data = array(
	':to_user_id'		=>	$_POST['to_user_id'],
	':from_user_id'		=>	$_SESSION['user_id'],
	':chat_message'		=>	$_POST['chat_message'],
	':text'		=>	$_POST['chat_message'],
	':name'		=>	$_POST['to_user_id'],
	':type'		=>	'sent',
':attrs'			=>	'',
':avatar'			=>	'',
':cssClass'		=>	'',
':footer'			=>	'',
':header'			=>	'',
':image'			=>	'',
':imageSrc'			=>	'',
':isTitle'			=>	'',
':textFooter'			=>	'',
':textHeader'			=>	'',
	':status'			=>	'',
	':newStatus'			=>	'1'


);

$query = "
INSERT INTO chat_message
(to_user_id, from_user_id, chat_message, text, name, type, attrs, avatar, cssClass, footer, header, image, imageSrc, isTitle, textFooter, textHeader, newStatus, status)
VALUES (:to_user_id, :from_user_id, :chat_message, :text, :name, :type, :attrs, :avatar, :cssClass, :footer, :header, :image, :imageSrc, :isTitle, :textFooter, :textHeader, :newStatus, :status)
";



$statement = $connect->prepare($query);

if($statement->execute($data))
{
	echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
}

?>
