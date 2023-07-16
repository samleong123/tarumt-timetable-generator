<?php
// Require config.php to get variable defined
require('./config.php');

// Check whether username and password is empty 
if (empty($username) || empty($password)) {
    $messagearray = array("Title"=>"Empty username or password","Message"=>"We did not receive your username or password. Please relogin with valid username and password.","Requested_Time"=>$date_MST);
    $json = array("Status"=>"Fail","Data"=>$messagearray);
    http_response_code(400);
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($json));
    exit();
}

// Check whether is deviceid and device is exist
if (empty($deviceid) || empty($device)){
   // Generate a GUID like this for deviceid
    $deviceid = substr(md5(rand()),0,8)."-".substr(md5(rand()),0,4)."-".substr(md5(rand()),0,4)."-".substr(md5(rand()),0,4)."-".substr(md5(rand()),0,12);
    
   // Set Device as fixed 
    $device = "iPhone 19,2";


}

// Post response to TARUMT App API
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $loginurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'username='.$username.'&password='.$password.'&deviceid='.$deviceid.'&devicemodel='.$device.'&appversion='.$appversion,
  CURLOPT_HTTPHEADER => array(
    'User-Agent: '.$useragent,
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// Check whether response is success or not
$resp = json_decode($response, true);
$respstatus = $resp["msg"];

// If not success, return error message
if ($respstatus !== "success")
{
    $messagearray = array("Title"=>"Login Failed","Message"=>"Your username or password is incorrect. Please relogin with valid username and password.","Requested_Time"=>$date_MST);
    $json = array("Status"=>"Fail","Data"=>$messagearray);
    http_response_code(401);
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($json));
    exit();
}

// If success , return token , used device id , device model , student email and student name

// define variable
$token = $resp["token"];
$studentemail = $resp["email"];
$studentname = $resp["fullname"];
$studentid = $resp["userid"];

// JSON
$messagearray = array("Title"=>"Login Successfully","Message"=>"Welcome , ".$studentname,"Student_Email"=>$studentemail,"Student_Name"=>$studentname,"Student_ID"=>$studentid,"Auth_Token"=>$token,"Device_ID"=>$deviceid,"Device"=>$device,"Requested_Time"=>$date_MST);
$json = array("Status"=>"Success","Data"=>$messagearray);
header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
echo (json_encode($json));
exit();
?>