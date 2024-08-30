<?php
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

// Replace with your Line Notify token
$token = '67C36OvxEvOuS6ZVRo9mcCMyQFBFdrj9j0JPxbcaWCV';

// The message you want to send
$message = 'Hello from PHP!';

// Send the notification
$response = sendLineNotify($message, $token);
echo $response;
?>
