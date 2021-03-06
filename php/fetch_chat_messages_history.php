
<?php
// header("Acces-Control-Allow-Origin: *");
// Header("Content-Type: application/x-javascript; charset=UTF-8");
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT * FROM chat_message
WHERE (from_user_id = '".$to_user_id."'
AND to_user_id = '".$from_user_id."')
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$rows=[];
foreach($result as $row)
{
if($row['from_user_id'] == $to_user_id){
  $type = 'received';
} else {
  $type = 'sent';
}

$query1 = "
SELECT * FROM chat_message
WHERE from_user_id = '$to_user_id'
AND to_user_id = '$from_user_id'
AND newStatus = '1'
";
$statement1 = $connect->prepare($query1);
$statement1->execute();
$count = $statement1->rowCount();


if($count > 0)
{
$waitingmessages =  $count;
}
else {
$waitingmessages = "0";
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
    'name'		=>	$row['name'],
    'avatar'		=>	$row['avatar'],
    'type'		=>	$type,
    'textHeader'		=>	$row['textHeader'],
    'textFooter'		=>	$row['textFooter'],
    'image'		=>	$row['image'],
    'imageSrc'		=>	$row['imageSrc'],
    'isTitle'		=>	$row['isTitle'],
    'cssClass'		=>	$row['cssClass'],
    'attrs'		=>	$row['attrs'],
    'status'			=>	$row['status'],
    'waitingmessages'			=>	$waitingmessages
    );

}

if(!$rows) {
echo 'empty';
}
   else
   { // 3 = delivered
     $query = "
     UPDATE chat_messages_log
     SET chat_message_status = '2',
     chat_message_timetoupdate = '1'
     WHERE (chat_message_id = '".$chat_message_id."')
     ";
     $statement = $connect->prepare($query);
     $statement->execute();

     $query = "
     DELETE FROM chat_message
     WHERE to_user_id = '".$from_user_id."'
     ";

     $statement = $connect->prepare($query);
     $statement->execute();

    echo json_encode($rows);
   }

?>
