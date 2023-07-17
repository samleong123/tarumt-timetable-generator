<?php
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

// If success , return Success 
$messagearray = array("Title"=>"Valid token","Message"=>"Token is valid.","Token"=>$token,"Requested_Time"=>$date_MST);
$json = array("Status"=>"Success","Data"=>$messagearray);
header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
echo (json_encode($json));
exit();

?>