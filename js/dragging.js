$(".note").draggable({
	start: function(event) {
		$(".ui-draggable-dragging").css('width', $(this).width());
		$(".ui-draggable-dragging").height($(this).height());
	},
	stack: 'ui-front',
	helper: 'clone',
	cursor: 'move',
	revert: false
});

$(".day, .masonry").droppable({
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

		// Send this data to modify.php
		var id = $("#"+data).attr("id").substring(1);
		var dt = null;
		if ($("#"+data).is("[data-time]")) dt = $("#"+data).attr("data-time");

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