<?php
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
// header("Access-Control-Allow-Credentials" : true );


include('database_connection.php');

session_start();

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT
login_details.last_activity AS last_activity,
login_details.is_type AS is_type,
login_details.user_id
FROM login_details
WHERE login_details.user_id = '$to_user_id'
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
													$is_type = "Typing...";
												}
												else
												{
													$is_type = "no";
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

													$query2 = "
													SELECT * FROM login
													WHERE (user_id = '".$to_user_id."')
													";
													$statement2 = $connect->prepare($query2);
													$statement2->execute();
													$result2 = $statement2->fetchAll();

													foreach($result2 as $row2)
														{
															$publickey = $row2["publickey"];
														}


											$rows = array(
											'active'		=>	$active,
											'waitingmessages'		=>	$waitingmessages,
											'is_type'		=>	$is_type,
											'to_user_id'		=>	$to_user_id,
											'from_user_id'		=>	$from_user_id,
											'last_activity' => $last_activity,
											'publickey' => $publickey
											);







}

    echo json_encode($rows);
		//echo $from_user_id . ' : ' .$to_user_id;

?>
