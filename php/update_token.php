<?php
// header("Acces-Control-Allow-Origin: *");
// Header("Content-Type: application/x-javascript; charset=UTF-8");
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$tokenId = $_REQUEST['tokenId'];

$query = "
UPDATE login
SET tokenId = '".$tokenId."'
WHERE user_id = '".$from_user_id."'
";

$statement = $connect->prepare($query);
$statement->execute($data);

echo 'Token Updated. : ';
?>
