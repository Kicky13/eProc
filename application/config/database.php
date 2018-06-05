<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/



$active_group = 'default';
$active_record = TRUE;

/* Koneksi oracle dev semen */
$db['default']['hostname'] = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = dev-sggdata3.semenindonesia.com)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = devsgg)))';
$db['default']['username'] = 'eproc';
$db['default']['password'] = 'Semengres1k';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/* koneksi lokal */
// $db['default']['hostname'] = "localhost";
// $db['default']['username'] = 'eproc';
// $db['default']['password'] = 'eproc';
// $db['default']['database'] = '';
// $db['default']['dbdriver'] = 'oci8';
// $db['default']['dbprefix'] = '';
// $db['default']['pconnect'] = FALSE;
// $db['default']['db_debug'] = TRUE;
// $db['default']['cache_on'] = FALSE;
// $db['default']['cachedir'] = '';
// $db['default']['char_set'] = 'utf8';
// $db['default']['dbcollat'] = 'utf8_general_ci';
// $db['default']['swap_pre'] = '';
// $db['default']['autoinit'] = TRUE;
// $db['default']['stricton'] = FALSE;

/* koneksi default2 */
$db['default2']['hostname'] = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = dev-sggdata3.semenindonesia.com)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = devsgg)))';
$db['default2']['username'] = 'devkonsultan';
$db['default2']['password'] = 'basiskaya';
$db['default2']['database'] = '';
$db['default2']['dbdriver'] = 'oci8';
$db['default2']['dbprefix'] = '';
$db['default2']['pconnect'] = FALSE;
$db['default2']['db_debug'] = TRUE;
$db['default2']['cache_on'] = FALSE;
$db['default2']['cachedir'] = '';
$db['default2']['char_set'] = 'utf8';
$db['default2']['dbcollat'] = 'utf8_general_ci';
$db['default2']['swap_pre'] = '';
$db['default2']['autoinit'] = TRUE;
$db['default2']['stricton'] = FALSE;

/* koneksi hris prod */
$db['hris_prod']['hostname'] = '10.15.3.67';
$db['hris_prod']['username'] = 'user_hmr';
$db['hris_prod']['password'] = '_R34+ch.Th:ePe4k';
$db['hris_prod']['database'] = 'hris';
$db['hris_prod']['dbdriver'] = 'mysql';
$db['hris_prod']['dbprefix'] = '';
$db['hris_prod']['pconnect'] = TRUE;
$db['hris_prod']['db_debug'] = TRUE;
$db['hris_prod']['cache_on'] = FALSE;
$db['hris_prod']['cachedir'] = '';
$db['hris_prod']['char_set'] = 'utf8';
$db['hris_prod']['dbcollat'] = 'utf8_general_ci';
$db['hris_prod']['swap_pre'] = '';
$db['hris_prod']['autoinit'] = TRUE;
$db['hris_prod']['stricton'] = FALSE;

/* koneksi hris dev */
$db['hris_dev'] = $db['hris_prod'];
$db['hris_dev']['database'] = 'hris_dev';

/* koneksi hris tapi eror */
$db['hris']['hostname'] = 'intranet.sggrp.com';
$db['hris']['username'] = 'user_hmr';
$db['hris']['password'] = '_R34+ch.Th:ePe4k';
$db['hris']['database'] = 'hris';
$db['hris']['dbdriver'] = 'mysql';
$db['hris']['dbprefix'] = '';
$db['hris']['pconnect'] = TRUE;
$db['hris']['db_debug'] = TRUE;
$db['hris']['cache_on'] = FALSE;
$db['hris']['cachedir'] = '';
$db['hris']['char_set'] = 'utf8';
$db['hris']['dbcollat'] = 'utf8_general_ci';
$db['hris']['swap_pre'] = '';
$db['hris']['autoinit'] = TRUE;
$db['hris']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */