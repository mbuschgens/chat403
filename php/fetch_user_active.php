<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

foreach($result as $row)
				{


										$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
										$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
										$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);


										if($user_last_activity > $current_timestamp)
										{
$active = "1";

										}
										else
										{
$active = "0";

										}


$rows[] = array(
'active'		=>	$active
);





		}

    echo json_encode($rows);



?>
