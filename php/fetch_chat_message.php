
<?php
header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT * FROM chat_message
WHERE to_user_id = '".$from_user_id."'
AND from_user_id = '".$to_user_id."'
AND newStatus = '1'
LIMIT 1
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

// $rows=[];
foreach($result as $row)
{

if($row['from_user_id'] == $to_user_id){
  $type = 'received';
  $name = $row['name'];
} else {
  $type = 'sent';
  $name = 'Me';
}

$chat_message_id = $row['chat_message_id'];


    $rows = array(
    'chat_message_id'		=>	$row['chat_message_id'],
    'to_user_id'		=>	$row['to_user_id'],
    'from_user_id'		=>	$row['from_user_id'],
    'chat_message'		=>	$row['chat_message'],
    'timestamp'		=>	$row['timestamp'],
    'text'		=>	$row['text'],
    'header'		=>	$row['header'],
    'footer'		=>	$row['footer'],
    'name'		=>	$name,
    'avatar'		=>	$row['avatar'],
    'type'		=>	$type,
    'textHeader'		=>	$row['textHeader'],
    'textFooter'		=>	$row['textFooter'],
    'image'		=>	$row['image'],
    'imageSrc'		=>	$row['imageSrc'],
    'isTitle'		=>	$row['isTitle'],
    'cssClass'		=>	$row['cssClass'],
    'attrs'		=>	$row['attrs'],
    'status'			=>	$row['status']
    );

}

if(!$rows) {

  $query = "
  UPDATE chat_messages_log
  SET chat_message_status = '3',
  chat_message_timetoupdate = '1'
  WHERE (to_user_id = '".$from_user_id."'
  AND from_user_id = '".$to_user_id."')
  ";


  $statement = $connect->prepare($query);
  $statement->execute();

  }
   else
   {
     $query = "
     UPDATE chat_messages_log
     SET chat_message_status = '3',
     chat_message_timetoupdate = '1'
     WHERE (to_user_id = '".$from_user_id."'
     AND from_user_id = '".$to_user_id."'
     AND chat_message_id = '".$chat_message_id."' )
     ";
     $statement = $connect->prepare($query);
     $statement->execute();

     $query = "
     DELETE FROM chat_message
     WHERE chat_message_id = '".$chat_message_id."'
     ";

     $statement = $connect->prepare($query);
     $statement->execute();

    //fetch_user_chat_history($_REQUEST['from_user_id'], $_REQUEST['to_user_id'], $connect);
    echo json_encode($rows);


   }




?>
