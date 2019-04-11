<?php
// header("Acces-Control-Allow-Origin: *");
// Header("Content-Type: application/x-javascript; charset=UTF-8");

include('database_connection.php');

session_start();

$AUTHORIZATION_KEY = 'AAAAeS83lqY:APA91bFo95JPe2CF7RSLhyBhumfpkamhZi5qoeRnS3lQvM9iI1nqeCn3yDtSavwXUNshKUL6rlkh9NFyOIxXFmLEzTct5KbV0eH5ibV7ocTiQ5gCpS8vhezz7626EewowVFaIRD0xI8K';

$from_user_id = $_REQUEST['from_user_id'];
$to_user_id = $_REQUEST['to_user_id'];

$query = "
SELECT * FROM login
WHERE user_id = '".$from_user_id."'
LIMIT 1
";

$statement = $connect->prepare($query);
$statement->execute();
$result2 = $statement->fetchAll();

// $rows=[];
foreach($result2 as $row)
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
      //'openApp' => true,
      'priority' => 'high',
      'headsUp' => true,
    ),
    "setBadge" => true
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


?>
