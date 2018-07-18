# MySQL

This script works also with a MySQL database. 

## Configure Google Cloud SQL

If you are a Google Cloud user, you can host your MySQL database with Google Cloud. Please check Google Cloud SQL documentation on how to create a user and SSL certificates to access the databases.

## Configure MySQL

Create a `gpes_en_old_api` database and user. To create the table `signups`, run this SQL:

```sql
CREATE TABLE `signups` (
  `signed_date` varchar(10) DEFAULT NULL,
  `signed_time` float unsigned NOT NULL,
  `ea_campaign_id` varchar(15) DEFAULT NULL,
  `page_url` varchar(200) DEFAULT NULL,
  `utm_medium` varchar(15) DEFAULT NULL,
  `utm_source` varchar(15) DEFAULT NULL,
  `utm_campaign` varchar(15) DEFAULT NULL,
  `utm_content` varchar(15) DEFAULT NULL,
  `utm_term` varchar(15) DEFAULT NULL,
  `gclid` varchar(100) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `user_agent` varchar(150) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `id_number` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `email_ok` varchar(1) DEFAULT NULL,
  `privacy` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`signed_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Configure this php script

Open `config.php.dist` and save it as `config.php`. Then at the end of `config.php` uncomment the lines:

```php
use Medoo\Medoo;
$database = new Medoo([
	'database_type' => 'mysql',
	'database_name' => 'gpes_en_old_api',
	'server' => 'YOUR-SERVER-IP',
	'username' => 'YOUR-MYSQL-USERNAME',
	'password' => 'YOUR-USER-MYSQL-PASSWORD',
	'charset' => 'utf8',
	'port' => 3306,
	'logging' => true,
	'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::MYSQL_ATTR_SSL_KEY  => '/home/your-user/user-keys/client-key.pem',
        PDO::MYSQL_ATTR_SSL_CERT => '/home/your-user/user-keys/client-cert.pem',
        PDO::MYSQL_ATTR_SSL_CA   => '/home/your-user/user-keys/server-ca.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
	],
	'command' => [
		'SET SQL_MODE=ANSI_QUOTES'
	]
]);
```

Now configure the options above with the path to your SSL keys and other MySQL settings.

Save the `config.php` file.
