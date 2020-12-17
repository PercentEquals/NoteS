<?php

try 
{
	//TODO: Validate data and sanitize
	// good source for this: https://stackoverflow.com/questions/1314518/sanitizing-users-data-in-get-by-php

	include('../database.php');

	$isDesc = isset($_POST['desc']);
	$isDate = isset($_POST['date']);

	$query = 'UPDATE notes SET ';
	if ($isDesc) $query .= 'description=:desc';
	if ($isDesc && $isDate) $query .= ', ';
	if ($isDate) $query .= 'date=:date';
	$query .= ' WHERE id=:id';

	if ($_POST['date'] == 0) $_POST['date'] = null;

	$q = $db_conn->prepare($query); 
	if ($isDesc) $q->bindParam(':desc', $_POST['desc']);
	if ($isDate) $q->bindParam(':date', $_POST['date']);
	$q->bindParam(':id', $_POST['id']);
	$q->execute();
}
catch(PDOException $e)
{
	$error = 'Database error: '.$e->getMessage();
	include('../error.php');
}

?>