function initialize() {

var defaultBounds = new google.maps.LatLngBounds(
	new google.maps.LatLng(38.660592,-120.995730)
	);

var origin_input = document.getElementById('saddr');
var destination_input = document.getElementById('daddr');


var options = {
	bounds: defaultBounds,
	componentRestrictions: {country: 'us'}
};


var autocomplete_origin = new google.maps.places.Autocomplete(origin_input, options);    
var autocomplete_destination = new google.maps.places.Autocomplete(destination_input, options);
}

google.maps.event.addDomListener(window, 'load', initialize);



jQuery(document).ready(function($) {

	$('#expand-planner-button').on('click touchend', openPlanner);
	$('#saddr').on('click touchstart', openPlanner);
	
		

	
});

function openPlanner() {
	 $('#expand-planner-button').parent().addClass('expanded');
	$('#home-map-inner').addClass('moved-down');
	$('.expanded #expand-planner-button').on('click touchend', closePlanner);
};
function closePlanner() {
	 $('#expand-planner-button').parent().removeClass('expanded');
	$('#home-map-inner').removeClass('moved-down');
	$('#expand-planner-button').on('click touchend', openPlanner);
};




function parseTime(time, format, step) {
	
	var hour, minute, stepMinute,
		defaultFormat = 'g:ia',
		pm = time.match(/p/i) !== null,
		num = time.replace(/[^0-9]/g, '');
	
	// Parse for hour and minute
	switch(num.length) {
		case 4:
			hour = parseInt(num[0] + num[1], 10);
			minute = parseInt(num[2] + num[3], 10);
			break;
		case 3:
			hour = parseInt(num[0], 10);
			minute = parseInt(num[1] + num[2], 10);
			break;
		case 2:
		case 1:
			hour = parseInt(num[0] + (num[1] || ''), 10);
			minute = 0;
			break;
		default:
			return '';
	}
	
	if( pm === true && hour > 0 && hour < 12 ) hour += 12;
	
	if( hour >= 13 && hour <= 23 ) pm = true;
	
	if( step ) {
		if( step === 0 ) step = 60;
		stepMinute = (Math.round(minute / step) * step) % 60;
		if( stepMinute === 0 && minute >= 30 ) {
			hour++;
			if( hour === 12 || hour === 24 ) pm = !pm;
		}
		minute = stepMinute;
	}
	
	if( hour <= 0 || hour >= 24 ) hour = 0;
	if( minute < 0 || minute > 59 ) minute = 0;
 
	return (format || defaultFormat)
        .replace(/g/g, hour === 0 ? '12' : 'g')
		.replace(/g/g, hour > 12 ? hour - 12 : hour)
		.replace(/G/g, hour)
		.replace(/h/g, hour.toString().length > 1 ? (hour > 12 ? hour - 12 : hour) : '0' + (hour > 12 ? hour - 12 : hour))
		.replace(/H/g, hour.toString().length > 1 ? hour : '0' + hour)
		.replace(/i/g, minute.toString().length > 1 ? minute : '0' + minute)
		.replace(/s/g, '00')
		.replace(/a/g, pm ? 'pm' : 'am')
		.replace(/A/g, pm ? 'PM' : 'AM');
	
}


function update() {
    $('#ftime').val(parseTime($('#ftime').val(), format, step));   
}

$(document).ready( function() {
		if($('body').hasClass('home')) {
		$('#ftime').blur(update);

		$(function() {
		$( "#fdate" ).datepicker({dateFormat: "mm/dd/yy"});
	  });
  
  
	  var thisdate = new Date();
 
	function formatDate(date) { 
	var d = new Date(date); 
	var hh = d.getHours(); 
	var m = d.getMinutes(); 
	var dd = "AM"; 
	var h = hh; 
	if (h >= 12) { 
	h = hh-12; 
	dd = "PM"; 
	} 
	if (h == 0) { 
	h = 12; 
	} 
	m = m<10?"0"+m:m; 
 
	return h+':'+m+' '+dd 
	}
 
	document.getElementById('ftime').value=formatDate(thisdate); 

	var d = new Date(),
	month = d.getMonth() + 1,
	day = d.getDate(),
	year = d.getFullYear();

	document.getElementById('fdate').value = month + '/' + day + '/' +  year ;

	var format = 'g:i A';
	var step = 1;
	
	}
});
	