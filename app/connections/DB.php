<?php

require_once __DIR__.'/../../config.php';

$host = DBHOST;
$username = DBUSER;
$password = DBPWD;
$database = DBNAME;
// Create connection
$conn = mysqli_connect($host, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully \n";
