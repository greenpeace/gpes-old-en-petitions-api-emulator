<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;

require_once('config.php');

/**
 * Sends data to Google Big QUERY
 * @param array $data              The data to send
 * @param [[Type]] [$insertId = null] An optional Insert ID
 */
function stream_row($data, $insertId = null) {

    $bigQuery = new BigQueryClient([
        'projectId' => BIGQUERY_PROJECT_ID,
    ]);
    
    $dataset = $bigQuery->dataset(BIGQUERY_DATASET);
    $table = $dataset->table(BIGQUERY_TABLE);

    $insertResponse = $table->insertRows([
        ['insertId' => $insertId, 'data' => $data],
        // additional rows can go here
    ]);
    if ($insertResponse->isSuccessful()) {
        syslog(LOG_INFO, 'Data streamed into BigQuery successfully' . PHP_EOL);
    } else {
        foreach ($insertResponse->failedRows() as $row) {
            foreach ($row['errors'] as $error) {
                error_log('%s: %s' . PHP_EOL, $error['reason'], $error['message']);
            }
        }
    }
};

/**
 * Sends data to SQLlite, MySQL and other
 * @param array $data     The data to send
 * @param [[Type]] $database [[Description]]
 */
function insert_row( $data, $database ) {

    $database->insert("signups", $data );
    
}

?>