<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$regId = $_REQUEST['regId'];

$servername = "localhost";
$database = "jtbusuo122_rsm";
$username = "jtbusuo122_rsm";
$password = "Marcel7410";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

//Check connection was successful
  if ($conn->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 3 rows from actor table
  $result = $conn->query("SELECT * FROM People");

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	$dbdata[]=$row;
  }

  $row = $result->fetch_assoc();

//Print array in JSON format
 echo json_encode($dbdata);
//  echo json_encode($row);
  //echo $row;

?>
