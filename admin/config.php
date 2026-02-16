<?php
// Compatibility layer: provide legacy mysql_* functions using mysqli
$DB_HOST = "db_malasngoding";
$DB_USER = "root";
$DB_PASS = "xxx";
$DB_NAME = "malasngoding_kios";

$__mysqli = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$__mysqli) {
	die('Database connection failed: ' . mysqli_connect_error());
}

function mysql_connect($host = null, $user = null, $pass = null)
{
	global $__mysqli, $DB_HOST, $DB_USER, $DB_PASS;
	return $__mysqli;
}

function mysql_select_db($db)
{
	global $__mysqli;
	return mysqli_select_db($__mysqli, $db);
}

function mysql_query($query)
{
	global $__mysqli;
	return mysqli_query($__mysqli, $query);
}

function mysql_fetch_array($result)
{
	return mysqli_fetch_array($result);
}

function mysql_fetch_assoc($result)
{
	return mysqli_fetch_assoc($result);
}

function mysql_num_rows($result)
{
	return mysqli_num_rows($result);
}

function mysql_real_escape_string($str)
{
	global $__mysqli;
	return mysqli_real_escape_string($__mysqli, $str);
}

function mysql_result($result, $row = 0, $field = 0)
{
	if (!mysqli_data_seek($result, $row)) return false;
	$data = mysqli_fetch_array($result);
	return isset($data[$field]) ? $data[$field] : false;
}

function mysql_error()
{
	global $__mysqli;
	return mysqli_error($__mysqli);
}

?>