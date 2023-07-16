<?php
// General Config
// timeconfig
date_default_timezone_set('Asia/Kuala_Lumpur');
$date_MST = date("d F Y, h:i:s A");
$timestamp = date('Ymd\THis\Z');


// Login
// Config to get user info and fixed variable
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];
$deviceid = $_REQUEST["deviceid"];
$device = $_REQUEST["device"];
$appversion = "2.0.14";
$loginurl = "https://app.tarc.edu.my/MobileService/login.jsp";
$useragent = "Mozilla/5.0 (iPhone; CPU iPhone OS 16_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148";

// Generate ICS 
// Config to get auth token from login.php and fixed variable
$token = $_REQUEST["token"];
$icsurl = "https://app.tarc.edu.my/MobileService/services/AJAXStudentTimetable.jsp?act=get&week=";
$studentname = $_REQUEST["studentname"];
?>