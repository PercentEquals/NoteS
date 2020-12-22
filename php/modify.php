<?php

try 
{
	include('../database.php');

	$isDesc = isset($_POST['desc']);
	$isDate = isset($_POST['date']);
	$isID = isset($_POST['id']);
	if ($isDate && $_POST['date'] == 0) $_POST['date'] = null;

	// Check for id
	if ($isID)
	{
		$q = $db_conn->prepare('SELECT id FROM notes WHERE id=:id');
		$q->bindParam(':id', $_POST['id']);
		$q->execute();
		if (!$q->rowCount()) throw new PDOException('Wrong id');
	}

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

	// Query for removing
	if ($isID && !$isDesc && !$isDate)
	{
		$query = 'DELETE FROM notes WHERE id=:id';
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