<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$is_type = $_REQUEST['is_type'];
$login_details_id = $_REQUEST['login_details_id'];

// $query = "
// UPDATE login_details
// SET is_type = '".$_POST["is_type"]."'
// WHERE login_details_id = '".$_REQUEST["login_details_id"]."'
// ";
$query = "
UPDATE login_details
SET is_type = '".$is_type."'
WHERE login_details_id = '".$login_details_id."'
";

$statement = $connect->prepare($query);

$statement->execute();

echo 'update_is_type_status.php DONE! ' . $is_type . ' - ' . $login_details_id;

?>
