<?php

error_reporting(0);
ini_set('display_errors', 0);

// Replace with your MailerLite API key
$apiKey = '';
$groupId = ''; // Group ID where the subscriber should be added
$apiUrl = '';

$query_string = trim(fgets(STDIN));
parse_str($query_string, $post);

$email = isset($post['O-Email']) ? $post['O-Email'] : null;
$fname = isset($post['O-First']) ? $post['O-First'] : '';
$lname = isset($post['O-Last']) ? $post['O-Last'] : '';
$optin = isset($post['O-EmailList']) ? $post['O-EmailList'] : null;

if ($optin != null && $email != null) {
    // Prepare subscriber data
    $subscriberData = array(
        'email' => $email,
        'fields' => array(
            'name' => $fname,
            'last_name' => $lname,
        ),
        'groups' => [$groupId] // Add subscriber to the group
    );

    $data = json_encode($subscriberData);

    // Initialize cURL
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ),
        CURLOPT_POSTFIELDS => $data,
    ));

    $result = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        echo 'Request Error:' . curl_error($curl);
    } else {
        echo 'Response: ' . $result;
    }

    curl_close($curl);
}