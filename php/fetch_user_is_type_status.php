<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];


										$query = "
										SELECT * FROM login_details
										WHERE user_id = '".$to_user_id."'
										ORDER BY last_activity DESC
										LIMIT 1
										";
										$statement = $connect->prepare($query);
										$statement->execute();
										$result = $statement->fetchAll();


										foreach($result as $row)
														{


															$rows[] = array(

															'is_type'		=>	$row["is_type"];
															);

										}




    echo json_encode($rows);



?>
