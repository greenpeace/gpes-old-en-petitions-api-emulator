<?php

use Google\Cloud\BigQuery\BigQueryClient;

class Insert {

    /**
     * Sends data to Google Big QUERY
     * @param array $data              The data to send
     * @param [[Type]] [$insertId = null] An optional Insert ID
     */
    static function stream_row_bigquery($data, $insertId = null) {

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
    }

    /**
     * Sends data to SQLlite, MySQL and other
     * @param array $data     The data to send
     * @param [[Type]] $database [[Description]]
     */
    static function insert_row( $data, $database ) {

        $database->insert("signups", $data );

    }

}






?>
