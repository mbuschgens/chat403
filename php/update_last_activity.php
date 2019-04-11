<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$login_details_id = $_REQUEST['login_details_id'];


// $query = "
// UPDATE login_details
// SET last_activity = now()
// WHERE login_details_id = '".$_SESSION["login_details_id"]."'
// ";

$query = "
UPDATE login_details
SET last_activity = now()
WHERE login_details_id = '".$login_details_id."'
";

$statement = $connect->prepare($query);

$statement->execute($data);

echo 'update_last_activity login_details_id UPDATED! : ' .$login_details_id;

?>
