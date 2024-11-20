#!/usr/bin/php
<?php

error_reporting(0);
ini_set('display_errors', 0);

$apiKey = '';
$groupId = ''; 
$apiUrl = '';

$query_string = trim(fgets(STDIN));
parse_str($query_string, $post);

$email = isset($post['O-Email']) ? $post['O-Email'] : null;
$fname = isset($post['O-First']) ? $post['O-First'] : '';
$lname = isset($post['O-Last']) ? $post['O-Last'] : '';
$optin = isset($post['O-EmailList']) ? $post['O-EmailList'] : null;

if ($optin != null && $email != null) {
    $subscriberData = array(
        'email' => $email,
        'fields' => array(
            'name' => $fname,
            'last_name' => $lname
        ),
        'groups' => [$groupId] 
    );

    $data = json_encode($subscriberData);

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

    if (curl_errno($curl)) {
        echo 'Request Error:' . curl_error($curl);
    } else {
        echo 'Response: ' . $result;
    }

    curl_close($curl);
}