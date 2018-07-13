<?php

require('config.php');

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;


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

?>