/*
$(".sorted > div, .masonry").on("dragenter", function(event)
{
	event.preventDefault();
	$(this).addClass("dragover");
});

// Add highlight on dragover
$(".sorted > div, .masonry").on("dragover", function(event)
{
	event.preventDefault();
	if (!$(this).hasClass("dragover")) $(this).addClass("dragover");
});

// Remove highlight on dragover
$(".sorted > div, .masonry").on("dragleave", function(event)
{
	event.preventDefault();
	$(this).removeClass("dragover");
});

// Drop to sorted
$(".sorted > div").on("drop", function(event)
{
	event.preventDefault();
	$(this).removeClass("dragover");

	var data = event.originalEvent.dataTransfer.getData("id");
	$("#"+data).appendTo(this);
	$("#"+data).attr("data-time", $(this).children("div").children("div").attr("data-day-time"));

	$("#"+data).addClass("noted");

	// TODO: send this data to modify.php
});

// Drop to unsorted
$(".masonry").on("drop", function(event)
{
	event.preventDefault();
	$(this).removeClass("dragover");

	var data = event.originalEvent.dataTransfer.getData("id");
	$("#"+data).appendTo(this);

	$("#"+data).removeAttr("data-time");
	$("#"+data).removeClass("noted");

	// TODO: send this data to modify.php
});

// Drag note event - "send" note id
$(".note").on("dragstart", function(event) {
	event.originalEvent.dataTransfer.setData("id", $(this).attr("id"));
});
*/

// https://www.elated.com/drag-and-drop-with-jquery-your-essential-guide/

$(".note").draggable({
	start: function(event) {
		$(".ui-draggable-dragging").css('width', $(this).width());
	},
	stack: 'ui-front',
	helper: 'clone',
	cursor: 'move',
	revert: false
});

// https://stackoverflow.com/questions/394491/passing-data-to-a-jquery-ui-dialog
// You can access the dragged element using using ui.draggable.attr('id') inside your drop function.
// https://jsfiddle.net/c3TpU/

$(".sorted > div, .masonry").droppable({
	drop: function(event, ui) {
		event.preventDefault();
		$(this).removeClass("dragover");
	
		var data = ui.draggable.attr('id');
		$("#"+data).appendTo(this);

		if (!$(this).hasClass("masonry"))
		{
			// Dragged to sorted so add data-time
			$("#"+data).attr("data-time", $(this).children("div").children("div").attr("data-day-time"));
			$("#"+data).addClass("noted");
		}
		else
		{
			// Dragged to unsorted so remove data-time
			$("#"+data).removeAttr("data-time");
			$("#"+data).removeClass("noted");
		}

		// TODO: send this data to modify.php
	},
	over: function(event, ui) {
		event.preventDefault();
		if (!$(this).hasClass("dragover")) $(this).addClass("dragover");
	},
	out: function(event, ui) {
		event.preventDefault();
		$(this).removeClass("dragover");
	},
	tolerance: 'pointer'
});