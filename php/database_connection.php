<?php
//database_connection.php

$connect = new PDO("mysql:dbname=jtbusuo122_403;host=127.0.0.1;charset=utf8mb4", "jtbusuo122_403", "askl7410");

//date_default_timezone_set('Asia/Kolkata');

function fetch_user_last_activity($user_id, $connect)
{
	$query = "
	SELECT * FROM login_details
	WHERE user_id = '$user_id'
	ORDER BY last_activity DESC
	LIMIT 1
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['last_activity'];
	}
}



function sent_notification($from_user_id, $to_user_id, $message_to_send, $connect)
{

	$AUTHORIZATION_KEY = 'AAAAeS83lqY:APA91bFo95JPe2CF7RSLhyBhumfpkamhZi5qoeRnS3lQvM9iI1nqeCn3yDtSavwXUNshKUL6rlkh9NFyOIxXFmLEzTct5KbV0eH5ibV7ocTiQ5gCpS8vhezz7626EewowVFaIRD0xI8K';

	// $from_user_id = $_REQUEST['from_user_id'];
	// $to_user_id = $_REQUEST['to_user_id'];

	$query = "
	SELECT * FROM login
	WHERE to_user_id = '".$from_user_id."'
	LIMIT 1
	";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	// $rows=[];
	foreach($result as $row)
	{
	  $tokenId = $row['tokenId'];
	}



	$fields = array(
	  'to' => $tokenId,
	  'data' => array(
	    'notificationOptions' => array(
	      'text' => 'New message',
	      // 'summary' => "4 messages",
	      // 'textLines' => array("Message 1", "Message 2", "Message 3", "Message 4"),
	      'title' => 'Title test',
	      'smallIcon' => 'mipmap/icon',
	      // 'largeIcon' => 'https://avatars2.githubusercontent.com/u/1174345?v=3&s=96',
	      // 'bigPicture' => "https://cloud.githubusercontent.com/assets/7321362/24875178/1e58d2ec-1ddc-11e7-96ed-ed8bf011146c.png",
	      'vibrate' => [100,500,100,500],
	      // 'sound' => true,
	      // 'sound' => 'http://asg.angkasapura1.co.id/mysound.mp3',
	      // 'sound' => "http://tindeck.com/download/pro/yjuow/Not_That_Guy.mp3",
	      'sound' => "res://raw/lost_european_the_beginning_of_the_end_mp3", // Downloaded from http://www.freemusicpublicdomain.com
	      // 'color' => '000000ff',
	      // 'color' => '0000ff',
	      'color' => 0x000000ff,
	      'autoCancel' => true,
	      // 'openApp' => true,
	      'priority' => 'high'
	    )
	  )
	);

	$headers = array(
	  'Authorization:key='.$AUTHORIZATION_KEY,
	  'Content-Type:application/json'
	);

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($result, true);

	echo '<pre>fields:';
	print_r($fields);
	echo "\n\nheaders:";
	print_r($headers);
	echo "\n\nresult:";
	print_r($result);



}






//
//
// function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
// {
//  $query = "
//  SELECT * FROM chat_message
//  WHERE (from_user_id = '".$from_user_id."'
//  AND to_user_id = '".$to_user_id."')
//  OR (from_user_id = '".$to_user_id."'
//  AND to_user_id = '".$from_user_id."')
//  ORDER BY timestamp DESC
//  ";
//  $statement = $connect->prepare($query);
//  $statement->execute();
//  $result = $statement->fetchAll();
//
//
//
//  $output = '<ul class="list-unstyled">';
//  foreach($result as $row)
//  {
//   $user_name = '';
//   $dynamic_background = '';
//   $chat_message = '';
//   if($row["from_user_id"] == $from_user_id)
//   {
//    if($row["status"] == '2')
//    {
//     $chat_message = '<em>This message has been removed</em>';
//     $user_name = '<b class="text-success">You</b>';
//    }
//    else
//    {
//     $chat_message = $row['chat_message'];
//     $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
//    }
//
//
//    $dynamic_background = 'background-color:#ffe6e6;';
//   }
//   else
//   {
//    if($row["status"] == '2')
//    {
//     $chat_message = '<em>This message has been removed</em>';
//    }
//    else
//    {
//     $chat_message = $row["chat_message"];
//    }
//    $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
//    $dynamic_background = 'background-color:#ffffe6;';
//   }
//   $output .= '
//   <li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
//    <p>'.$user_name.' - '.$chat_message.'
//     <div align="right">
//      - <small><em>'.$row['timestamp'].'</em></small>
//     </div>
//    </p>
//   </li>
//   ';
//  }
//  $output .= '</ul>';
//
//
//
//
//
//  // status 0 betekend ontvangen
//
//  $query = "
//  UPDATE chat_message
//  SET status = '0'
//  WHERE from_user_id = '".$to_user_id."'
//  AND to_user_id = '".$from_user_id."'
//  AND status = '1'
//  ";
//  $statement = $connect->prepare($query);
//  $statement->execute();
//
//
//  return $result; // aangepadt
// }
//
//







function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
 $query = "
 SELECT * FROM chat_message
 WHERE (from_user_id = '".$from_user_id."'
 AND to_user_id = '".$to_user_id."')
 OR (from_user_id = '".$to_user_id."'
 AND to_user_id = '".$from_user_id."')
 ORDER BY timestamp DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  $dynamic_background = '';
  $chat_message = '';
  if($row["from_user_id"] == $from_user_id)
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been removed</em>';
    $user_name = '<b class="text-success">You</b>';
   }
   else
   {
    $chat_message = $row['chat_message'];
    $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
   }


   $dynamic_background = 'background-color:#ffe6e6;';
  }
  else
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been removed</em>';
   }
   else
   {
    $chat_message = $row["chat_message"];
   }
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
   $dynamic_background = 'background-color:#ffffe6;';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
   <p>'.$user_name.' - '.$chat_message.'
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>
  ';
 }
 $output .= '</ul>';

 // status 0 betekend ontvangen

 $query = "
 UPDATE chat_message
 SET status = '0'
 WHERE from_user_id = '".$to_user_id."'
 AND to_user_id = '".$from_user_id."'
 AND status = '1'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $output;
}











function get_user_name($user_id, $connect)
{
	$query = "SELECT username FROM login WHERE user_id = '$user_id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['username'];
	}
}

function count_unseen_message($to_user_id, $from_user_id, $connect)
{
	$query = "
	SELECT * FROM chat_message
	WHERE from_user_id = '$to_user_id'
	AND to_user_id = '$from_user_id'
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';

	if($count > 0)
	{
		$output = 'YES:'.$count;
	}
	else {
			$output = 'NON:' . $to_user_id . ' : ' . $from_user_id;
	}

	return $output;
}





function fetch_is_type_status($to_user_id, $connect)
{
	$query = "
	SELECT is_type FROM login_details
	WHERE user_id = '".$to_user_id."'
	ORDER BY last_activity DESC
	LIMIT 1
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["is_type"] == 'yes')
		{
			$output = 'YES Typing..';
		}
		else {
			$output = 'NO Typing...';
		}
	}
	return $output;
}





function fetch_group_chat_history($connect)
{
 $query = "
 SELECT * FROM chat_message
 WHERE to_user_id = '0'
 ORDER BY timestamp DESC
 ";


 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();

 $output = '<ul class="list-unstyled">';


 foreach($result as $row)
 {
  $user_name = '';
  $chat_message = '';
  $dynamic_background = '';

  if($row['from_user_id'] == $_SESSION['user_id'])
  {

   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been removed</em>';
    $user_name = '<b class="text-success">You</b>';
   }
   else
   {
    $chat_message = $row['chat_message'];
    $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
   }
   $dynamic_background = 'background-color:#ffe6e6;';
  }

  else
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been removed</em>';
   }
   else
   {
    $chat_message = $row['chat_message'];
   }
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
   $dynamic_background = 'background-color:#ffffe6;';
  }



  $output .= '
  <li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
   <p>'.$user_name.' - '.$chat_message.'
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>

  </li>
  ';
 }


 $output .= '</ul>';
 return $output;
}



?>
