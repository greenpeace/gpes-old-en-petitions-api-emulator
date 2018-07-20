<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require 'vendor/autoload.php';
require('src/input.php');
require_once('config.php');

use Insert\Insert;

// 1st - Get data from a POST or GET REQUEST

$data = [  

      "signed_date" => date("Y-m-d"), // Date
      "signed_time" => microtime(true), // Float
    
      "ea_campaign_id" => isset( $_REQUEST['ea_campaign_id'] ) ? inputSafe( $_REQUEST['ea_campaign_id'], 15): '0',
      "page_url" => isset( $_SERVER['HTTP_REFERER'] ) ? inputSafe( $_SERVER['HTTP_REFERER'], 200): '',
      
      "utm_medium" => isset( $_REQUEST['utm_medium'] ) ? inputSafe( $_REQUEST['utm_medium'], 15): '',
      "utm_source" => isset( $_REQUEST['utm_source'] ) ? inputSafe( $_REQUEST['utm_source'], 15): '',
      "utm_campaign" => isset( $_REQUEST['utm_campaign'] ) ? inputSafe( $_REQUEST['utm_campaign'], 15): '',
      "utm_content" => isset( $_REQUEST['utm_content'] ) ? inputSafe( $_REQUEST['utm_content'], 15): '',
      "utm_term" => isset( $_REQUEST['utm_term'] ) ? inputSafe( $_REQUEST['utm_term'], 15): '',
      "gclid" => isset( $_REQUEST['en_txn6'] ) ? inputSafe( $_REQUEST['en_txn6'], 100): '',
    
      "ip" => isset($_SERVER['REMOTE_ADDR']) ? inputSafe( $_SERVER['REMOTE_ADDR'], 30) : '',
      "user_agent" => isset( $_SERVER['HTTP_USER_AGENT'] ) ? inputSafe( $_SERVER['HTTP_USER_AGENT'], 150): '',
      
      "first_name" => isset( $_REQUEST['first_name'] ) ? inputSafe( $_REQUEST['first_name'], 100): '',
      "last_name" => isset( $_REQUEST['last_name'] ) ? inputSafe( $_REQUEST['last_name'], 100): '',
      "id_number" => isset( $_REQUEST['id_number'] ) ? inputSafe( $_REQUEST['id_number'], 10): '',
      "email" => isset( $_REQUEST['email'] ) ? trim(inputSafe( $_REQUEST['email'], 100)) : '',
      "phone_number" => isset( $_REQUEST['phone_number'] ) ? trim(inputSafe( $_REQUEST['phone_number'], 20)) : '',
      "postcode" => isset( $_REQUEST['postcode'] ) ? trim(inputSafe( $_REQUEST['postcode'], 10)) : '',

      "email_ok" => isset( $_REQUEST['email_ok'] ) ? inputSafe( $_REQUEST['email_ok'], 1): '',
      "privacy" => isset( $_REQUEST['privacy'] ) ? inputSafe( $_REQUEST['privacy'], 1): '',

];

// 2nd - Insert data

if ( filter_var( $data['email'], FILTER_VALIDATE_EMAIL) ) {
    
    // Big Query
    if ( defined('BIGQUERY_PROJECT_ID') && defined('BIGQUERY_DATASET') && defined('BIGQUERY_TABLE') && getenv("GOOGLE_APPLICATION_CREDENTIALS") !== false ) {
        Insert::stream_row_bigquery($data);
    }
    
    // Other
    if ( isset($database) ) {
        Insert::insert_row($data, $database);
    }
    
} else {
    error_log('Invalid email, not stored in BigQuery');
}

// 3rd - Return a response

$dataMode = isset( $_REQUEST['format'] ) ? inputSafe( $_REQUEST['format'], 30) : '';
$callback = isset( $_REQUEST['callback'] ) ?  inputSafe( $_REQUEST['callback'], 100) : '';

// 3.1 - The old API format was jSonP, bellow return a response to jSonP requests

if ( $dataMode == 'json' && $callback != '') {
    
    $response = array();
    $response['sessionId'] = '00a9921a-06ef-43de-a5d1-49f835664e15';
    $response['campaignId'] = $data['ea_campaign_id'];
    $response['name'] = 'EN old API Emulator';
    $response['campaignType'] = 'Data capture';
    $response['status'] = 'Live';
    $response['redirect'] = 'https://www.greenpeace.org/';
    $response['messages'] = array();
    $response['pages'] = array();
    $response = json_encode( $response );
    
    header('Content-Type: application/javascript; charset=utf8');
    echo $callback.'('.$response.');';   
    
} else { // To use in html without JavaScript
    
    header('Location: ' . COMMON_THANK_YOU_PAGE);

}

?>
