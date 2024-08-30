<?php
$a = $_POST["username"]; 
$b = $_POST["password"];

// SOAP client for authentication
$client = new SoapClient('http://webservices.egat.co.th/authentication/au_provi.php?wsdl');
$para = array("a" => $a, "b" => $b);
$result = $client->__soapCall("validate_user", $para);

// Function to send Line Notify message
function sendLineNotify($message, $token) {
    $url = 'https://notify-api.line.me/api/notify';
    
    $data = [
        'message' => $message,
    ];
    
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $token,
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => http_build_query($data),
        ],
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    return $result;
}

// Line Notify token
$lineToken = 'c4AZwKIpJMnubi9UOZWoVo30PqGcsLUxFpCtNOMYkUS';

// Check API result and handle redirection
if ($result) {
    // Send Line Notify on successful login
    $message = "User: $a เข้าสู่ระบบสําเร็จ";
    sendLineNotify($message, $lineToken);
    
    header("Location: home.php");
    exit();
} else {
    // Optionally, send a Line Notify on failed login
    $message = "User: $a พยายามเข้าสู่ระบบ แต่ล้มเหลว.";
    sendLineNotify($message, $lineToken);

    header("Location: login-user.php");
    exit();
}
?>
