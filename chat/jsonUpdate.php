<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$array = $_REQUEST['json'];

$regId = $array[regId];
$available = $array[available];
$dataOfRegistration = $array[dataOfRegistration];


$servername = "localhost";
$database = "jtbusuo122_rsm";
$username = "jtbusuo122_rsm";
$password = "Marcel7410";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE People SET

available='$array[available]',
-- recruiter='$array[recruiter]',
-- dataOfRegistration='$array[dataOfRegistration]',
firstName='$array[firstName]',
sureName='$array[sureName]',
eMail='$array[eMail]',
phone='$array[phone]',
gender='$array[gender]',
birthDay='$array[birthDay]',
placeOfBirth='$array[placeOfBirth]',
nationality='$array[nationality]',
maritalStatus='$array[maritalStatus]',
address='$array[address]',
houseNumber='$array[houseNumber]',
zipCode='$array[zipCode]',
city='$array[city]',
country='$array[country]',
englishSpeaking='$array[englishSpeaking]',
englishWriting='$array[englishWriting]',
dutchSpeaking='$array[dutchSpeaking]',
dutchWriting='$array[dutchWriting]',
dutchSocialNumber='$array[dutchSocialNumber]',
portugalSocialNumber='$array[portugalSocialNumber]',
passportNumber='$array[passportNumber]',
passportValidTill='$array[passportValidTill]',
workResidenceNumber='$array[workResidenceNumber]',
workResidenceValidTill='$array[workResidenceValidTill]',
drivingLicenseNumber='$array[drivingLicenseNumber]',
drivinglicenseValidTill='$array[drivinglicenseValidTill]',
drivingLicenseB='$array[drivingLicenseB]',
drivingLicenseC='$array[drivingLicenseC]',
drivingLicenseCode95='$array[drivingLicenseCode95]',
countryOfBank='$array[countryOfBank]',
nameOfBank='$array[nameOfBank]',
bankAccountNumber='$array[bankAccountNumber]',
bankAccountOnNameOf='$array[bankAccountOnNameOf]',
bankBIC='$array[bankBIC]',
salaryIndication='$array[salaryIndication]',
jobSelection='$array[jobSelection]',
jobSelectionExperience='$array[jobSelectionExperience]',
job1HistoryFrom='$array[job1HistoryFrom]',
job1HistoryTill='$array[job1HistoryTill]',
job1Function='$array[job1Function]',
job1CompanyProject='$array[job1CompanyProject]',
job2HistoryFrom='$array[job2HistoryFrom]',
job2HistoryTill='$array[job2HistoryTill]',
job2Function='$array[job2Function]',
job2CompanyProject='$array[job2CompanyProject]',
job3HistoryFrom='$array[job3HistoryFrom]',
job3HistoryTill='$array[job3HistoryTill]',
job3Function='$array[job3Function]',
job3CompanyProject='$array[job3CompanyProject]',
job4HistoryFrom='$array[job4HistoryFrom]',
job4HistoryTill='$array[job4HistoryTill]',
job4Function='$array[job4Function]',
job4CompanyProject='$array[job4CompanyProject]',
job5HistoryFrom='$array[job5HistoryFrom]',
job5HistoryTill='$array[job5HistoryTill]',
job5Function='$array[job5Function]',
job5CompanyProject='$array[job5CompanyProject]',
internalScoreProfessional='$array[internalScoreProfessional]',
internalScoreCommunication='$array[internalScoreCommunication]',
internalScoreTheLook='$array[internalScoreTheLook]',
internalScoreSerius='$array[internalScoreSerius]',
internalFirstImpression='$array[internalFirstImpression]'

WHERE regId='$array[regId]'";


if (mysqli_query($conn, $sql)) {
      //echo "New record created successfully";
      // $last_id = $conn->insert_id;
      // echo $last_id;

      echo $array[regId];


     //  $dbdata = '{"regId":'.$array[regId].',"available":'.$array[available].',"recruiter":'.$array[recruiter].',"dataOfRegistration":'.$array[dataOfRegistration].'}';
     //
     //
     // echo json_encode($dbdata);

      // $character = json_decode($data);
      // echo $character->name;

      // echo $array;


      // $data = array();
      // $data = '{
      //    "regId": '.$regId.',
      //    "available": '.$available.',
      //    "dataOfRegistration": '.$dataOfRegistration.'
      //  }';





} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

?>
