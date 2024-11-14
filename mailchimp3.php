#!/usr/local/bin/php
<?php

error_reporting(0);
ini_set('display_errors', 0);

$apikey = '';
$listId = '';
$apiUrl = '';

$query_string = trim(fgets(STDIN));
parse_str($query_string,$post);

$email = isset($post['O-Email']) ? $post['O-Email'] : null;
$fname = isset($post['O-First']) ? $post['O-First'] : '';
$lname = isset($post['O-Last']) ? $post['O-Last'] : '';
$optin = isset($post['O-EmailList']) ? $post['O-EmailList'] : null;

if($optin != null && $email != null){

        $merge_vars = array(
                  'FNAME'=>$fname,
                  'LNAME'=>$lname,
        );

        $post_data = array(email_address => $email,
                status => 'subscribed',
                merge_fields => $merge_vars
        );

        $data = json_encode($post_data);

        $curl = curl_init();

        $url = $apiUrl . $listId.'/members/';

        curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_USERPWD=>"anyname:$apikey",
        ));

        $result = curl_exec($curl);

}
