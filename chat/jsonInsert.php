<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$array = $_REQUEST['json'];
//$array=json_decode($json,true);
// mysql_query("UPDATE uid SET `reactivatecode` = '$MD5pincode' WHERE `uid` = '$uid' ") or die(mysql_error());
//
// echo "JsonUpdatePincode.php UPDATE DONE";
//
// mysql_close();

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

// echo "Connected successfully<br><br>";
//
// $fo=fopen("json.json","r");
// $fr=fread($fo,filesize("json.json"));
//
// $array=json_decode($fr,true);

//print_r($array);

//To display all values from JSON file
//print_r($array);
//
// [regId] =>
// [available] => yes
// [recruiter] => Ana Castro
// [dataOfRegistration] => 1999-01-30
// [firstName] => Carel
// [sureName] => Buschgens
// [eMail] => marco.buschgens@gmail.com
// [phone] => 487945974
// [gender] => Male
// [birthDay] => 1972-06-29
// [placeOfBirth] => Rotterdam
// [nationality] => Hollandia
// [maritalStatus] => Divorced
// [address] => de Beuk
// [houseNumber] => 6
// [zipCode] => 2912 NA
// [city] => Nieuwerkerk aan den IJssel
// [country] => Portugal
// [englishSpeaking] => 4
// [englishWriting] => 4
// [dutchSpeaking] => 2
// [dutchWriting] => 4
// [dutchSocialNumber] => 123456
// [portugalSocialNumber] => 12345678
// [passportNumber] => 3245678
// [passportValidTill] => 2020-01-30
// [workResidenceNumber] => 234567897
// [workResidenceValidTill] => 2020-01-30
// [drivingLicenseNumber] => 324567897
// [drivinglicenseValidTill] => 2020-01-30
// [drivingLicenseB] => Array ( [0] => YES )
// [drivingLicenseC] => Array ( [0] => YES )
// [drivingLicenseCode95] => Array ( [0] => YES )
// [countryOfBank] => Portugal
// [nameOfBank] => 2436547
// [bankAccountNumber] => 345647
// [bankAccountOnNameOf] => 4563475
// [bankBIC] => 3564765
// [salaryIndication] => 1600.00
// [jobSelection] => Truckdriver
// [jobSelectionExperience] => daf
// [job1HistoryFrom] => 2014-04-30
// [job1HistoryTill] => 2019-01-30
// [job1Function] => truckdriver
// [job1CompanyProject] => option
// [job2HistoryFrom] => 2014-04-30
// [job2HistoryTill] => 2014-04-30
// [job2Function] => truckdriver
// [job2CompanyProject] => option
// [job3HistoryFrom] => 2014-04-30
// [job3HistoryTill] => 2014-04-30
// [job3Function] => truckdriver
// [job3CompanyProject] => option
// [job4HistoryFrom] => 2014-04-30
// [job4HistoryTill] => 2014-04-30
// [job4Function] => truckdriver
// [job4CompanyProject] => option
// [job5HistoryFrom] => 2014-04-30
// [job5HistoryTill] => 2014-04-30
// [job5Function] => truckdriver
// [job5CompanyProject] => option
// [internalScoreProfessional] => 5
// [internalScoreCommunication] => 5
// [internalScoreTheLook] => 5
// [internalScoreSerius] => 5
// [internalFirstImpression] => Good looking

//


$sql="INSERT INTO People VALUES('',
'$array[available]',
'$array[recruiter]',
'$array[dataOfRegistration]',
'$array[firstName]',
'$array[sureName]',
'$array[eMail]',
'$array[phone]',
'$array[gender]',
'$array[birthDay]',
'$array[placeOfBirth]',
'$array[nationality]',
'$array[maritalStatus]',
'$array[address]',
'$array[houseNumber]',
'$array[zipCode]',
'$array[city]',
'$array[country]',
'$array[englishSpeaking]',
'$array[englishWriting]',
'$array[dutchSpeaking]',
'$array[dutchWriting]',
'$array[dutchSocialNumber]',
'$array[portugalSocialNumber]',
'$array[passportNumber]',
'$array[passportValidTill]',
'$array[workResidenceNumber]',
'$array[workResidenceValidTill]',
'$array[drivingLicenseNumber]',
'$array[drivinglicenseValidTill]',
'$array[drivingLicenseB]',
'$array[drivingLicenseC]',
'$array[drivingLicenseCode95]',
'$array[countryOfBank]',
'$array[nameOfBank]',
'$array[bankAccountNumber]',
'$array[bankAccountOnNameOf]',
'$array[bankBIC]',
'$array[salaryIndication]',
'$array[jobSelection]',
'$array[jobSelectionExperience]',
'$array[job1HistoryFrom]',
'$array[job1HistoryTill]',
'$array[job1Function]',
'$array[job1CompanyProject]',
'$array[job2HistoryFrom]',
'$array[job2HistoryTill]',
'$array[job2Function]',
'$array[job2CompanyProject]',
'$array[job3HistoryFrom]',
'$array[job3HistoryTill]',
'$array[job3Function]',
'$array[job3CompanyProject]',
'$array[job4HistoryFrom]',
'$array[job4HistoryTill]',
'$array[job4Function]',
'$array[job4CompanyProject]',
'$array[job5HistoryFrom]',
'$array[job5HistoryTill]',
'$array[job5Function]',
'$array[job5CompanyProject]',
'$array[internalScoreProfessional]',
'$array[internalScoreCommunication]',
'$array[internalScoreTheLook]',
'$array[internalScoreSerius]',
'$array[internalFirstImpression]'
)";

if (mysqli_query($conn, $sql)) {
      //echo "New record created successfully";
      $last_id = $conn->insert_id;
      echo $last_id;

} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

?>
