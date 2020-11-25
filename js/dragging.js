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