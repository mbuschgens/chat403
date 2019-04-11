<?php
header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$publickey = $_REQUEST['publickey'];

$query = "
UPDATE login
SET publickey = '".$publickey."'
WHERE user_id = '".$from_user_id."'
";

$statement = $connect->prepare($query);
$statement->execute($data);

echo 'PublicKey Updated. : ';
?>
