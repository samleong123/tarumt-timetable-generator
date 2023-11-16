<?php
error_reporting(E_ERROR | E_PARSE);
// Require config.php to get variable defined
require('./config.php');

// Get auth token
if (empty($token)){
    $messagearray = array("Title"=>"Invalid request","Message"=>"Invalid Request. Please relogin with valid username and password.","Requested_Time"=>$date_MST);
    $json = array("Status"=>"Fail","Data"=>$messagearray);
    http_response_code(401);
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($json));
    exit();
}

// Get API Response
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $icsurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-Auth: '.$token
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// JSON Decode
$resp = json_decode($response, true);

// If failed , return error
$status = $resp["msg"];
if ($status == "failed"){
    $messagearray = array("Title"=>"Expired token","Message"=>"Token expired. Please relogin with valid username and password.","Requested_Time"=>$date_MST);
    $json = array("Status"=>"Fail","Data"=>$messagearray);
    http_response_code(401);
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($json));
    exit();
}

// Count how many weeks
$weeks = $resp["weeks"];

// Remove all from weeks
$weeksarray = array_slice($weeks, 1);

// Set header to download 
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$studentname.'-'.$timestamp.'.ics"');
header('Access-Control-Allow-Origin: *');

// Begin VCalendar
echo "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//tarumt-calendar.samsam123.name.my//Tunku Abdul Rahman University of Management and Technology (TARUMT) Calendar Generator
CALSCALE:GREGORIAN
BEGIN:VTIMEZONE
TZID:Asia/Kuala_Lumpur
LAST-MODIFIED:".$timestamp."
X-LIC-LOCATION:Asia/Kuala_Lumpur
BEGIN:STANDARD
TZNAME:+08
TZOFFSETFROM:+0800
TZOFFSETTO:+0800
DTSTART:19700101T000000
END:STANDARD
END:VTIMEZONE";

// Loop for all weeks 
foreach ($weeksarray as $week){

    // Get API Response
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $icsurl.$week,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-Auth: '.$token
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// Get into the array day of the week
$resp = json_decode($response, true);
$dayofweek = $resp["rec"];

// Loop all day inside the week
foreach($dayofweek as $day){
    $date = $day["date"];
$class = $day["class"];

// Loop into all class
foreach ($class as $classdata){

    // Define variable
    $classtimestart = $date." ".$classdata["fstart"];
    $classtimeend = $date." ".$classdata["fend"];
    $classcode = $classdata["funits"];
    $classname = $classdata["fdesc"];
    $classlecturer = $classdata["fstaffname"];
    $classtype = $classdata["fclasstype"];
    $classlocation = $classdata["froom"];
    $replacementclass = $classdata["replace"];

    // Add replacement class into class name
    if ($replacementclass == "Y"){
        $classname = '[REPLACEMENT] '.$classname;
    }

    // Convert Class Time to valid ICS format

    // Start
    $dateTimeStart = DateTime::createFromFormat('d/m/Y h:i A', $classtimestart);
    $icsstart = $dateTimeStart->format('Ymd\THis');

    //End
    $dateTimeEnd = DateTime::createFromFormat('d/m/Y h:i A', $classtimeend);
    $icsend = $dateTimeEnd->format('Ymd\THis');

 
  
  
    // Generate 16 random UID
    $uid = substr(md5(rand()),0,16);

    // ICS VEVENT
    echo "
BEGIN:VEVENT";
    echo "
DTSTART;TZID=Asia/Kuala_Lumpur:".$icsstart;
    echo "
DTEND;TZID=Asia/Kuala_Lumpur:".$icsend;
    echo "
DTSTAMP:".$icsstart;
    echo "
UID:".$uid;
    echo "
SUMMARY:".$classname." (".$classtype.") (".$classcode.") ";
    echo "
DESCRIPTION:Lecturer : ".$classlecturer;
    echo "
LOCATION:".$classlocation;
    echo "
BEGIN:VALARM
ACTION:DISPLAY
TRIGGER:-P0DT0H10M0S
DESCRIPTION:This is an event reminder
END:VALARM
BEGIN:VALARM
ACTION:DISPLAY
TRIGGER:-P0DT1H0M0S
DESCRIPTION:This is an event reminder
END:VALARM
BEGIN:VALARM
ACTION:DISPLAY
TRIGGER:-P0DT2H0M0S
DESCRIPTION:This is an event reminder
END:VALARM";
    echo "
END:VEVENT";
}

}


}

// END VCALENDAR
echo "
END:VCALENDAR";
?>
