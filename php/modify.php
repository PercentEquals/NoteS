<?php

try 
{
	include('../database.php');

	$isDesc = isset($_POST['desc']);
	$isDate = isset($_POST['date']);
	$isID = isset($_POST['id']);
	if ($isDate && $_POST['date'] == 0) $_POST['date'] = null;

	// TODO: include validate

	// Query for modify
	$query = 'UPDATE notes SET ';
	if ($isDesc) $query .= 'description=:desc';
	if ($isDesc && $isDate) $query .= ', ';
	if ($isDate) $query .= 'date=:date';
	$query .= ' WHERE id=:id';

	// Query for adding
	if (!$isID)
	{
		$query = 'INSERT INTO notes (date, description) VALUE (:date, :desc)';	
	}

	$q = $db_conn->prepare($query); 
	if ($isDesc) $q->bindParam(':desc', $_POST['desc']);
	if ($isDate) $q->bindParam(':date', $_POST['date']);
	if ($isID)	 $q->bindParam(':id', $_POST['id']);
	$q->execute();
}
catch(PDOException $e)
{
	echo 'Database error: '.$e->getMessage();
}

?>