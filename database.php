<?php

	$dbhost = "localhost"; // Nazwa hosta
	$dbname = "notes"; // Nazwa bazy danych
	$dbuser = "root"; // Login do bazy danych
	$dbpassword = ""; // Hasło do bazy danych
	$db_conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpassword);

?>