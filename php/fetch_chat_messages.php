
<?php
header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];


$query = "
SELECT * FROM chat_message
WHERE from_user_id = '".$to_user_id."'
AND to_user_id = '".$from_user_id."'
AND status = '1'
LIMIT 1
";


//  $query = "
//  UPDATE chat_message
//  SET status = '0'
//  WHERE from_user_id = '".$to_user_id."'
//  AND to_user_id = '".$from_user_id."'
//  AND status = '1'
//  ";


 //  $query = "
 //  UPDATE chat_message
 //  SET status = '0'
 //  WHERE from_user_id = '".$to_user_id."'
 //  AND to_user_id = '".$from_user_id."'
 //  AND status = '1'
 //  ";

 //  $statement = $connect->prepare($query);
 //  $statement->execute();



// $query = "
// SELECT * FROM chat_message
// WHERE to_user_id = '".$from_user_id."'
// ORDER BY timestamp DESC
// ";





$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$rows=[];
foreach($result as $row)
{
    //$rows[]=$row;

// if($row['to_user_id'] == $from_user_id){
//   $type = 'received';
// }
if($row['from_user_id'] == $to_user_id){
  $type = 'received';
} else {
  $type = 'sent';
}

    $rows[] = array(
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
    'status'			=>	$row['status']
    );


}

echo json_encode($rows);
?>
