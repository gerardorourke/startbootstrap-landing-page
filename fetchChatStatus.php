<?php
header('Content-Type: application/javascript');
header('Access-Control-Allow-Origin: http://purplepi.ie');
//header('X-Frame-Options: SAMEORIGIN');
//header("Content-Security-Policy: frame-ancestors 'self'");

$myBusinessHoursId = htmlspecialchars($_GET["businessHoursId"]);
$myChatEntryId = htmlspecialchars($_GET["chatEntryId"]);
$ecehostname = 'ucce-ece-web.lab2.purplepi.ie';
$site_url = 'http://' . $ecehostname . '/system/templates/chat/businessHours/chatStatus.asp?businessHoursId=' . $myBusinessHoursId.'&chatEntryId=' . $myChatEntryId;

try {
    $ch = curl_init();
    $timeout = 4;

    curl_setopt($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //supress error from been printed - i.e. to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
    curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$str = curl_exec($ch);
    curl_close($ch);
	
    if (curl_errno($ch) OR $httpcode!='200'){
        echo "\nconsole.log('fetchChatStatus curl error: '" . curl_error($ch) . "';";
        echo "\nconsole.log('fetchChatStatus http response code: '" . $httpcode . "';";
        echo "\nvar chatStatus = 'closed';";
        echo "\nvar chatStatusReason = 'out of service';";
        echo "\nvar chatTimer = '0';";
    } else {
        echo $str;
    }
	
} catch (exception $e) {
    echo "\nvar chatStatus = 'closed';";
    echo "\nvar chatStatusReason = 'out of service';";
    echo "\nvar chatTimer = '0';";
} 
?>