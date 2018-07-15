# EN old API emulator

**This script emulates the old EN API and stores petition signups in a Google Big Query table, instead of EN.** 

If you use it, you’ll need to manually export the signups from BigQuery to Engaging Networks. It's useful if you have **legacy petitions** and need to have them running in 2019 **without changing the code** to the new API.  With this script, in your old petitions, you might just need to change the receiving URL from `https://e-activist.com/ea-action/action` to the receiving URL your PHP server. 

Please note this script was developed for the Spanish office, so it will need small adjustments before it can be used by other NROs.

## Install

**Important**: To adapt this script to your field names, modify `index.php` in this repository.

For more information on sending data to BQ please visit the pages on [Google BigQuery Libraries](https://cloud.google.com/bigquery/docs/reference/libraries).

### Configure Google Cloud and Big Query

1. Create a json [Google Cloud service account key](https://console.cloud.google.com/apis/credentials/serviceaccountkey) with the role *BigQuery User* and download the json access file. Later you'll need to link to it from the `config.php` file.
2. Create a Big Query dataset and share it with the service account. *(for example: `gpes_en_old_api`)*
3. Create an empty Big Query table inside that dataset, *(for example: `signups`)* with the following table schema:

```text
signed_date:DATE,signed_time:FLOAT,ea_campaign_id:STRING,page_url:STRING,utm_medium:STRING,utm_source:STRING,utm_campaign:STRING,utm_content:STRING,utm_term:STRING,gclid:STRING,ip:STRING,user_agent:STRING,first_name:STRING,last_name:STRING,id_number:STRING,email:STRING,phone_number:STRING,postcode:STRING,email_ok:STRING,privacy:STRING
```

### Install and configure this php script

Now you'll need to configure the php script with the service account info (the .json file), and project, dataset and table info.

1. Upload the .json service account file to your server. Please put the json file in a folder that doesn't expose it to outsiders, as if anyone obtains this file it can access your data.
2. Download this repository with Git: `git clone https://github.com/greenpeace/gpes-old-en-petitions-api-emulator.git`
3. Open `config.php.dist` and save it as `config.php`.
4. In `config.php`:
  * Modify in the path to the .json service account file in your server.
  * Configure your project id, dataset and table.
  * Configure the URL for the common thank you page. Currently this script requires a unique thank you page for all your petitions. If needed we'll allow mutiple thank you pages in the future.
5. Save the `config.php` file.

### Install the libraries

In your PHP server, install Composer and the required libraries with the command:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar require google/cloud-bigquery
```

### Upload this repo files

* `index.php`
* `config.php`
* `input.php`
* `bigquery.php`
* `testing-html.html`
* `testing-js.html`

The `vendor` folder, obtained with composer, should be here as well. 

## Test it!

Visit `testing-js.html` in your API server with your browser. Then confirm there's data in BigQuery with:

```sql
#standardSQL
SELECT * FROM `gpes_en_old_api.signups` ORDER BY signed_time;
```

At this point you should see the example data in BigQuery.

Then do the same for `testing-html.html`.

## Point your forms to your new API

In your forms, change the receiving URL from `https://e-activist.com/ea-action/action` to the receiving URL your PHP server. It should be the `index.php` file or it's parent folder.

Normally you should do this twice: in the html and in the javascript.