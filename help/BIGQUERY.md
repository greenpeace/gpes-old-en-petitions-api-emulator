# Google Cloud and Big Query

BigQuery is an excellent tool to store your data, specially if you already use BigQuery and/or Google Cloud.

## Configure BigQuery

1. Create a json [Google Cloud service account key](https://console.cloud.google.com/apis/credentials/serviceaccountkey) with the role *BigQuery User* and download the json access file. Later you'll need to link to it from the `config.php` file.
2. Create a Big Query dataset and share it with the service account. *(for example: `gpes_en_old_api`)*
3. Create an empty Big Query table inside that dataset, *(for example: `signups`)* with the following table schema:

```text
signed_date:DATE,signed_time:FLOAT,ea_campaign_id:STRING,page_url:STRING,utm_medium:STRING,utm_source:STRING,utm_campaign:STRING,utm_content:STRING,utm_term:STRING,gclid:STRING,ip:STRING,user_agent:STRING,first_name:STRING,last_name:STRING,id_number:STRING,email:STRING,phone_number:STRING,postcode:STRING,email_ok:STRING,privacy:STRING
```

## Configure this php script

Now you'll need to configure the php script with the service account info (the .json file), and project, dataset and table info.

1. Upload the .json service account file to your server. Please put the json file in a folder that doesn't expose it to outsiders, as if anyone obtains this file it can access your data.
3. Open `config.php.dist` and save it as `config.php`.
4. In `config.php`:
  * Modify in the path to the .json service account file in your server.
  * Configure your project id, dataset and table.
  * Configure the URL for the common thank you page. Currently this script requires a unique thank you page for all your petitions. If needed we'll allow mutiple thank you pages in the future.
5. Save the `config.php` file.

For more information on sending data to BQ please visit the pages on [Google BigQuery Libraries](https://cloud.google.com/bigquery/docs/reference/libraries).