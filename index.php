<?php

// https://mansfeld.pl/programowanie/kurs-pdo-bazy-danych-php/

// Error logging
function err($error)
{
	include('error.php');
	exit();	
}

// Class that stores one Note for easier data manipulation
class Note
{
	public $id;
	public $description;
	public $date;

	public function __construct($id, $des, $dat)
	{
		$this->id = $id;
		$this->description = $des;
		$this->date = $dat;
	}

	public function print()
	{
		$d = '<div class="note">';
		if ($this->date != NULL) 
		{
			$h = ($this->date != date("Y-m-d")) ? "noted hidden" : "noted";
			$d = '<div class="'.$h.'" data-time="'.$this->date.'">';
			//$d .= '<div>'.$this->date.'</div>';
		}

		echo '
			'.$d.'
				'.$this->description.'
			</div>
		';
	}
}

// Arrays that store sorted and unsorted notes
$notes = array();
$notes_with_dates = array_fill(0, 7, array()); //array(array());

// Database connection and fetching
try 
{
	include('database.php');
	$q = $db_conn->prepare('SELECT * FROM notes ORDER BY date'); 
	$q->execute();

	while($row = $q->fetch()) 
	{
		if ($row['date'] == NULL)
		{
			$notes[] = new Note($row['id'], $row['description'], $row['date']);
		}
		else 
		{
			//echo date('w', strtotime($row['date']));
			$notes_with_dates[date('w', strtotime($row['date']))][] = new Note($row['id'], $row['description'], $row['date']);
		}
	}
}
catch(PDOException $e)
{
	err('Database error: '.$e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<title>NoteS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>
<body>

	<header>
		<input type="date" id="calendar" />
	</header>

	<div>

		<div class="col-sm-5">
			<h2>Unsorted notes</h2>
		</div>

		<div class="masonry">
			<?php
				foreach($notes as $n) $n->print();
			?>
		</div>
		
		<div class="col-sm-5">
			<h2>Sorted notes</h2>
		</div>

		<div class="masonry sorted">
			<div class="monday"> <?php foreach($notes_with_dates[1] as $n) $n->print(); ?> </div>
			<div class="tuesday"> <?php foreach($notes_with_dates[2] as $n) $n->print(); ?> </div>
			<div class="wednesday"> <?php foreach($notes_with_dates[3] as $n) $n->print(); ?> </div>
			<div class="thursday"> <?php foreach($notes_with_dates[4] as $n) $n->print(); ?> </div>
			<div class="friday"> <?php foreach($notes_with_dates[5] as $n) $n->print(); ?> </div>
			<div class="saturday"> <?php foreach($notes_with_dates[6] as $n) $n->print(); ?> </div>
			<div class="sunday"> <?php foreach($notes_with_dates[0] as $n) $n->print(); ?> </div>
			
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="js/index.js"></script>

</body>
</html>