<?php
function sendSMS($to, $message) {
    // Setup Semaphore API call here
    $apiKey = '6ce2d9ac9d5da878b0a9bb7b62aaddc5';
    $apiUrl = 'https://semaphore.co/api/v4/messages';

    $data = [
        'apikey' => $apiKey,
        'number' => $to,
        'message' => $message,
        'sendername' => 'Thesis'
        
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>
