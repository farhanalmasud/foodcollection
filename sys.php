<?php
$timeasas = date("M d, Y h:i A", time());
$current_timestamp = time();
$last24current_timestamp = $current_timestamp - 86400;

if (isset($_POST['api_key']) && isset($_POST['msg']) && isset($_POST['to'])) {
    $errormsg = json_encode(array(
        "error" => 401,
        "msg" => "invalid request!",
    ));

    $successmsg = json_encode(array(
        "error" => 0,
        "msg" => "Request successfully submitted!",
    ));

    $apiKey = $_POST['api_key'];
    $msg = $_POST['msg'];
    $to = $_POST['to'];
    
    if (substr($to, 0, 5) === "88001") {
        $to = "8801" . substr($to, 5);
    }
    
    $parts = explode(":", $apiKey);
    $apikeyyy = $parts[0];
    $secretkey = $parts[1];

    // Send API request
    $reveurl = "http://apismpp.revesms.com/sendtext?apikey=$apikeyyy&secretkey=$secretkey&callerID=kkk&toUser=$to&messageContent=" . urlencode($msg);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $reveurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    
    $errorcurl = curl_errno($ch) ? 'Error: ' . curl_error($ch) : "";
    curl_close($ch);
    
    $responsede = json_decode($response, true);
    header('Content-Type: application/json');

    if ($responsede['Status'] == "0") {
        echo $successmsg;
    } else {
        echo $errormsg;
    }
} else {
    echo json_encode(array("error" => 401, "msg" => "Invalid request!"));
}
?>
