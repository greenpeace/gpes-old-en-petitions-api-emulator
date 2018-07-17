# SQLite

## Configure SQLite

We need an SQLlite file with the database in the server. You can upload the `gp_es_old_api.db` file OR create a SQLite table with this structure:

```sql
BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS `signups` (
	`signed_date`	TEXT,
	`signed_time`	REAL,
	`ea_campaign_id`	TEXT,
	`page_url`	TEXT,
	`utm_medium`	TEXT,
	`utm_source`	TEXT,
	`utm_campaign`	TEXT,
	`utm_content`	TEXT,
	`utm_term`	TEXT,
	`gclid`	TEXT,
	`ip`	TEXT,
	`user_agent`	TEXT,
	`first_name`	TEXT,
	`last_name`	TEXT,
	`id_number`	TEXT,
	`email`	TEXT,
	`phone_number`	TEXT,
	`postcode`	TEXT,
	`email_ok`	TEXT,
	`privacy`	TEXT,
	PRIMARY KEY(`signed_time`)
);
COMMIT;
```

Please make sure that users can't download the database file from the server, as this would be a major security breach. Put your .db file in a folder outside the server root.

## Configure this php script

Open `config.php.dist` and save it as `config.php`. Then at the end of `config.php` uncomment the lines:

```php
use Medoo\Medoo;
$database = new Medoo([
	'database_type' => 'sqlite',
	'database_file' => '/home/your-user/your-database/gp_es_old_api.db'
]);
```

Now configure the `database_file` option above with the path to your database file.

Save the `config.php` file.
