// Set note to be draggable
$(".note").draggable({
	start: function(event) {
		// Make draggable note smaller
		$(".ui-draggable-dragging").css('width', $(this).width());
		$(".ui-draggable-dragging").height($(this).height());
	},
	stack: 'ui-front',
	helper: 'clone',
	cursor: 'move',
	revert: false
});

// Set day in calendar and masonry to be droppable
$(".day, .masonry").droppable({
	drop: function(event, ui) {
		event.preventDefault();
		$(this).removeClass("dragover");
	
		// Read data (basically id) from dropped element
		var data = "#"+ui.draggable.attr('id');

		// Insert dropped element into valid (sorted) position
		var id = $(this).children().first();

		$(this).children().slice(1).not(data).not(".ui-draggable-dragging").each(function(i, v) {
			if (parseInt($(data).attr('id').substring(1)) < parseInt($(v).attr('id').substring(1))) id = "#" + $(v).attr('id');
		});

		$(data).insertAfter(id);

		if (!$(this).hasClass("masonry"))
		{
			// Dragged to sorted so add data-time
			$(data).attr("data-time", $(this).children("div").children("div").attr("data-day-time"));
			$(data).addClass("noted");
		}
		else
		{
			// Dragged to unsorted so remove data-time
			$(data).removeAttr("data-time");
			$(data).removeClass("noted");
		}

		// Send this data to modify.php using POST request and jQuery AJAX
		var id = $(data).attr("id").substring(1);
		var dt = null;
		if ($(data).is("[data-time]")) dt = $(data).attr("data-time");

		$.post("php/modify.php", {
			id: id,
			date: dt
		});
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