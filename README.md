# EN old API emulator

**This script emulates the old EN API but stores petition signups outside Engaging.** You can store petition data in BigQuery, SQlite or MySQL (For example Google Cloud SQL).

This script is useful if you have **legacy petitions** and need to have them running in 2019 **without changing the code** to the new API.  With this script, in your old petitions, you might just need to change the receiving URL from `https://e-activist.com/ea-action/action` to the receiving URL your PHP server. 

Please note this script was developed for the Spanish Office, so it will need small adjustments before it can be used by other NROs. If you use it, you’ll need to manually export the signups to your CRM or mailing app. 

## Install

**Important**: To adapt this script to your field names, modify `index.php` in this repository. Please note you'll need to adjust your database fields as well.

### 1 - Download this script and the required libraries

Get Composer and download the required libraries with the command:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar require google/cloud-bigquery
php composer.phar require catfan/Medoo
```

Download this script with Git:

`git clone https://github.com/greenpeace/gpes-old-en-petitions-api-emulator.git`

### 2 - Configure the database

To store the signups you can use **Bigquery**, **SQLite** or **MySQL**. See how to:

* Configure [Google Cloud and Big Query](BIGQUERY.md)
* Configure [SQLite](SQLITE.md)
* Configure [MySQL](MySQL.md) - For example for Google Cloud SQL

Follow the instructions in one of the the links above and then continue bellow.

### 3 - Upload the files to the server

Now that you have configured your script and your database you can upload the files: 

* `index.php`
* `config.php`
* `input.php`
* `insert.php`
* `testing-html.html`
* `testing-js.html`

The `vendor` folder, downloaded with composer, should be uploaded as well. 

## Test it!

1. With your browser, visit [testing-js.html](testing-js.html) in your server. 
2. Confirm there's data in your new petitions database. 
3. Test the html form redirection by submitting the form in [testing-html.html](testing-html.html).
4. Confirm again that your last form test is in the database.

If you use **BigQuery**, you can [check your database](https://bigquery.cloud.google.com/) with the query:

```sql
#standardSQL
SELECT * FROM `gpes_en_old_api.signups` ORDER BY signed_time;
```

If you use **SQLite** you can download your database file and open it in your computer with an [SQLite client](http://sqlitebrowser.org/). Or you can install [Adminer](https://www.adminer.org/en/) on your server.

And if you use **MySQL** you can use a client like for example [Sequel Pro](https://www.sequelpro.com/) to access your data or a server-side script like [Adminer](https://www.adminer.org/en/).

## Point your forms to your new API

In your forms change the URL that receives petition's data from `https://e-activist.com/ea-action/action` to equivalent URL in your PHP server. It should be the script's `index.php` file or it's parent folder.

Normally you should do this twice: in the html and in the javascript. For more information check [testing-html-html](testing-html-html) and [testing-js.html](testing-js.html).