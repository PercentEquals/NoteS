// Set date
$(document).ready(function() {
	// Read date from cookie if set (this helps when user refreshes website so they don't need to scroll calendar)
	var date = Cookies.get('date');
	if (typeof date === 'undefined') date = getDay(new Date())

	// Change attr of calendar input and change calendar GUI
	$("#calendar").attr("value", date);
	changeCalendar();
});

// Update notes to show only those that user wants to see
function updateNotes(date) {
	// Filter only those from whole week (by using "array" of css selectors)
	var s = '';

	for (var i = 0; i < date.length; i++)
	{
		s += '[data-time="'+date[i]+'"]';
		if (i + 1 != date.length) s += ',';
	}

	$('.noted').filter(s).removeClass('hidden');
	$('.noted').filter(':not('+s+')').addClass('hidden');

	// Change dates in calendar, also show if date is today
	$(".day").each(function(index) {
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
		let sday = (date.getDay() == 0) ? 7 : date.getDay();
		let first = (date.getDate() - sday + i);
		let day = new Date(date.setDate(first)).toISOString().slice(0, 10);
		week.push(day);
	}

	return week;
}

// Returns one day from date
function getDay(date)
{
	day = date.getDate();
	if (day < 10) day = '0' + day;

	month = date.getMonth() + 1;
	if (month < 10) month = '0' + month;

	year = date.getFullYear();

	return [year, month, day].join('-');
}

// Update notes on calendar change
function changeCalendar(offset = 0)
{
	var date = new Date($('#calendar').val());
	
	// Add offset to date (when using prev and next "arrow" buttons)
	if (offset != 0)
	{
		date.setDate(date.getDate() + offset);
		$("#calendar").attr("value", getDay(date));
	}

	// Set cookie with last chosen date for 30 minutes
	Cookies.remove('date');
	Cookies.set('date', getDay(date), { expires: 1/48 });

	// Highlight selected day
	$(".day > div").removeClass("highlight");
	$(".day:nth-child("+((date.getDay() == 0) ? 7 : date.getDay())+") > div:first-child").addClass("highlight");

	// Update notes to show only those from selected week
	updateNotes(getWeek(date));
}

$('#calendar').change(function() {
	changeCalendar();
});

$('#prev-date').click(function() {
	changeCalendar(-1);
});

$('#next-date').click(function() {
	changeCalendar(1);
});