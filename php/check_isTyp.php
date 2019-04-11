<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 

include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT

login.user_avatar AS user_avatar,
login.active AS active,
login_details.last_activity AS last_activity,
login_details.is_type AS is_type,
login_details.user_id
FROM login, login_details

WHERE login_details.user_id = '$to_user_id'
AND login.user_id = '$to_user_id'
ORDER BY last_activity DESC
LIMIT 1

";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

										foreach($result as $row)
											{

											$last_activity = $row["last_activity"];
											$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
											$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);

											if($last_activity > $current_timestamp)
												{
$active = "1";
												}
												else
												{
$active = "0";
												}



												if($row["is_type"] === 'yes')
													{
	$is_type = "yes";
													}
													else
													{
	$is_type = "no";
													}

											$rows = array(
											'active'		=>	$active,
											'is_type'		=>	$is_type,
											'to_user_id'		=>	$to_user_id,
											'from_user_id'		=>	$from_user_id,
											'last_activity' => $last_activity,
											'user_avatar' => $row["user_avatar"],
											);

}
    echo json_encode($rows);
?>
