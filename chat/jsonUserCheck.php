<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$email = $_REQUEST['email'];
$password= $_REQUEST['password'];


$servername = "localhost";
$database = "jtbusuo122_rsm";
$username = "jtbusuo122_rsm";
$pass = "Marcel7410";

// Create connection

$conn = mysqli_connect($servername, $username, $pass, $database);

//Check connection was successful
  if ($conn->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 3 rows from actor table
  $result = $conn->query("SELECT * FROM Users WHERE email='$email' AND password='$password' ");

  //$count=$result->num_rows;

//Initialize array variable
  // $dbdata = array();
  //
  // while ( $row = $result->fetch_assoc())  {
	//    $dbdata[]=$row;
  // }

  $row = $result->fetch_assoc();

//Print array in JSON format
 //echo json_encode($dbdata);

 echo json_encode($row);
  //echo $count;
  //echo $row;
  //
  //echo $email . ' ' . $password . ' ' .$count . ' ' .$row;
  // echo $password;

  //echo $regId;

?>
