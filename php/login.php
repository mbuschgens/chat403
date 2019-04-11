<?php
header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];

				$sub_query = "
				INSERT INTO login_details
	     		(user_id)
	     		VALUES ('$from_user_id')
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute();


				$login_details_id = $connect->lastInsertId();


//json_encode(array("apples" => true, "bananas" => null));
echo $login_details_id ;


?>
