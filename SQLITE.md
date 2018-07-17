#### Configure SQLite

First create a SQLlite file with a database. You can upload the gp_es_old_api.db file or create a SQLite table with the command:

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

Please ensure that users can't download the database file as this would be a major security breach. Put your .db file in a folder outside the server.

Then at the end of `config.php` uncomment the lines:

```php
use Medoo\Medoo;
$database = new Medoo([
	'database_type' => 'sqlite',
	'database_file' => '/home/your-user/your-database/gp_es_old_api.db'
]);
```

And configure the `database_file` option with the path to your database file.