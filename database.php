<?php

	$dbhost = "localhost"; // Host name
	$dbname = "notes"; // Database name
	$dbuser = "root"; // Database login
	$dbpassword = ""; // Database password
	$db_conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

?>