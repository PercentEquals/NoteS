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
			//$h = ($this->date != date("Y-m-d")) ? "note noted hidden" : "note noted";
			$h = 'note noted hidden';
			$d .= 'class="'.$h.'" data-time="'.$this->date.'">';
		}
		else $d .= 'class="note">';

		echo $d.''.$this->description.'</div>';
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
	$q = $db_conn->prepare('SELECT * FROM notes ORDER BY date, id DESC'); 
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
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>
<body>

	<header>
		<h1>NoteS</h1>
	</header>

	<div id="main">

		<div class="row">
			<div class="col-sm-6">
				<h2>Unsorted notes</h2>
			</div>
			<div class="col-sm-6 align-right">
				<input type="button" id="add-note" value="+&nbsp;&nbsp;Add note"/>
			</div>
		</div>

		<div class="masonry">
			<div></div>
			<?php
				foreach($notes as $n) $n->print();
			?>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<h2>Sorted notes</h2>
			</div>
			<div class="col-sm-6 align-right">
				<input type="button" id="prev-date" value="&#xe801;" class="font"/>
				<input type="date" id="calendar" />
				<input type="button" id="next-date" value="&#xe802;" class="font"/>
			</div>
		</div>

		<div class="overflow">
			<div class="sorted">
				<div class="day"> 
					<div>Monday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[1] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Tuesday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[2] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Wednesday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[3] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Thursday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[4] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Friday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[5] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Saturday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[6] as $n) $n->print(); ?> 
				</div>
				<div class="day"> 
					<div>Sunday <div>0000-00-00</div></div>
					<?php foreach($notes_with_dates[0] as $n) $n->print(); ?> 
				</div>
			</div>
		</div>
	</div>

	<div class="overlay"></div>
	<div id="modify">
		<form>
			<h2>Add note:</h2>
			<div class="modify-row">
				<input type="button" value="Remove date" id="clear" />
				<input type="date" id="date" />
				<input type="button" value="&#xe803;" class="font" id="save" />
				<input type="button" value="&#xf1f8;" class="font" id="delete" />
			</div>
			<textarea>Your note goes here...</textarea>
		</form>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
	<script src="js/index.js"></script>
	<script src="js/dragging.js"></script>

</body>
</html>