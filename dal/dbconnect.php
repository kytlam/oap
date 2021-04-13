<?php
include_once dirname(dirname(__FILE__)).'/env.php';
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"


$hostname = $DB_SETTINGS['host'];
$database = $DB_SETTINGS['database_name'];
$username = $DB_SETTINGS['user'];
$password = $DB_SETTINGS['password'];

$db_conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function get_hash($key) {
    return hash ( "sha256" , APPKEY.$key  );
}
?>

