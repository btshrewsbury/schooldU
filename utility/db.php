<?php

define('DB_NAME', 'schooldu');
define('DB_USERNAME', 'charlie_brown');
define('DB_PASSWORD', '22@@EEckerle');
define('DB_SERVER', '556f6803e65e63748f36b43ca797318ee4d1eb23.rackspaceclouddb.com');
$db = NULL;

function db_connect() {
	global $db;
	$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	if (!$db) 
	{
		die('cannot connect to server - ' . mysqli_error($db));
		$db = NULL;
	}
	$select = mysqli_select_db($db, DB_NAME);
	if (!$db)
	{	
		die('cannot connect to database - ' . mysqli_error($db));
		$db = NULL;
	}
	return $db;
}

function db_execute($query) {
	global $db;
	if($db == NULL)
	{
		db_connect();
	}
	$results = @mysqli_query($db, $query);
	if(!$results) die('problem with the query - ' . $query . "<br />problem here - " . mysqli_error($db));
	
	return $results;
}

function db_disconnect() {
	global $db;
	try {
		mysqli_close($db);
		$db == NULL;
	}
	catch (Exception $e) {}
}

function escape_string($string) {
	global $db;
	if($db == NULL)
	{
		db_connect();
	}
	return mysqli_real_escape_string($db, $string);
	
}

function getLastId()
{
	global $db;
	return mysqli_insert_id($db);
}



?>