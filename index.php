<?php

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
		$d = '<div id="N'.$this->id.'" ';
		if ($this->date != NULL) 
		{
			$h = ($this->date != date("Y-m-d")) ? "note noted hidden" : "note noted";
			$d .= 'class="'.$h.'" data-time="'.$this->date.'">';
		}
		else $d .= 'class="note">';

		echo '
			'.$d.'
				'.$this->description.'
			</div>
		';
	}
}

// Arrays that store sorted and unsorted notes
// where sorted array is 2d and first dimension represent weekday (0 - 6 where 0 is sunday)
$notes = array();
$notes_with_dates = array_fill(0, 7, array());

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
			$notes_with_dates[date('w', strtotime($row['date']))][] = new Note($row['id'], $row['description'], $row['date']);
		}
	}
}
catch(PDOException $e)
{
	$error = 'Database error: '.$e->getMessage();
	include('error.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<title>NoteS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>
<body>

	<header>
		<h1>NoteS</h1>
	</header>

	<div>

		<div class="row">
			<div class="col-sm-6">
				<h2>Unsorted notes</h2>
			</div>
			<div class="col-sm-6 align-right">
				<input type="button" id="add-note" value="+&nbsp;&nbsp;Add note"/>
			</div>
		</div>

		<div class="masonry">
			<?php
				foreach($notes as $n) $n->print();
			?>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<h2>Sorted notes</h2>
			</div>
			<div class="col-sm-6 align-right">
				<input type="button" id="prev-date" value="&lt;"/>
				<input type="date" id="calendar" />
				<input type="button" id="next-date" value="&gt;"/>
			</div>
		</div>

		<div class="overflow">
			<div class="sorted">
				<div class="day"> 
					<div>Monday <div></div></div>
					<?php foreach($notes_with_dates[1] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Tuesday <div></div></div>
					<?php foreach($notes_with_dates[2] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Wednesday <div></div></div>
					<?php foreach($notes_with_dates[3] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Thursday <div></div></div>
					<?php foreach($notes_with_dates[4] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Friday <div></div></div>
					<?php foreach($notes_with_dates[5] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Saturday <div></div></div>
					<?php foreach($notes_with_dates[6] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Sunday <div></div></div>
					<?php foreach($notes_with_dates[0] as $n) $n->print(); ?> 
				</div>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="js/index.js"></script>
	<script src="js/dragging.js"></script>

</body>
</html>