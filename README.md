# Flip - disbursement
## Installation

Update database configuration on config.php.
> Note: Make sure you already create database
```sh
define('DBHOST',<Database Host>);
define('DBUSER',<Database Username>);
define('DBPWD',<Database Password>);
define('DBNAME',<Database Name>;
```

Run migration..
```sh
php migration.php
```

### How to Run
Create Disbursement
```sh
php disbursement.php <bank_code> <account_number> <amount> <remark>
php disbursement.php bri 34282583 1000000 'testing create'
```
Update Disbursement Manually (single)
```sh
php disbursement.php <id_disbursment>
php disbursement.php bri 8007474052
```
> Note: If You Want Update Disbursement Automatically
```sh
php disbursement_periodic.php
```

**Enjoy !**

