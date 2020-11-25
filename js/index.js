// Set date
$(document).ready(function() {
	$("#calendar").attr("value", getDay(new Date()));
	changeCalendar();
});

// Update notes to show only those that user wants to see
function updateNotes(date) {
	// Show good ones
	var s = '';

	for (var i = 0; i < date.length; i++)
	{
		s += '[data-time="'+date[i]+'"]';
		if (i + 1 != date.length) s += ',';
	}

	$('.noted').filter(s).removeClass('hidden');
	$('.noted').filter(':not('+s+')').addClass('hidden');

	// Change dates in calendar
	// also show if date is today
	$(".sorted > div").each(function(index) {
		var s = date[index];
		$(this).children("div").children("div").attr("data-day-time", s);
		if (date[index] == getDay(new Date())) s += " (Today)";
		$(this).children("div").children("div").text(s);
	});
}

// Returns full week from date
function getWeek(date)
{
	let week = [];

	for (let i = 1; i <= 7; i++) 
	{
		let sday = (date.getUTCDay() == 0) ? 7 : date.getUTCDay();
		let first = (date.getUTCDate() - sday + i);
		let day = new Date(date.setDate(first)).toISOString().slice(0, 10);
		week.push(day);
	}

	return week;
}

// Returns one day from date
function getDay(date)
{
	day = date.getUTCDate();
	if (day < 10) day = '0' + day;

	month = date.getUTCMonth() + 1;
	if (month < 10) month = '0' + month;

	year = date.getUTCFullYear();

	return [year, month, day].join('-');
}

// Update notes on calendar change
function changeCalendar()
{
	var date = new Date($('#calendar').val());

	// Highlight selected day
	$(".sorted > div > div").removeClass("highlight");
	$(".sorted > div:nth-child("+((date.getUTCDay() == 0) ? 7 : date.getUTCDay())+") > div:first-child").addClass("highlight");

	updateNotes(getWeek(date));
}

$('#calendar').change(function() {
	changeCalendar();
});
