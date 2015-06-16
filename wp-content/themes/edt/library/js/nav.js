// main nav

jQuery(document).ready(function($) {
	
	$('.menu-main-nav-container ul li').hover(function() {
		var svgName = $(this).find('svg').attr('rel');
		var defs =  document.querySelector('svg').querySelector('defs');
		//console.log(defs);
		var icon = document.getElementById(svgName);
		$('#'+svgName).find('path,circle').attr("class", "hover");
		$('#'+svgName).find('path,circle').attr("style", '-webkit-filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.5)); filter: drop-shadow(2px 2px 2px  rgba(0,0,0,0.5));');
		
	},function() {
		var svgName = $(this).find('svg').attr('rel');
		var defs =  document.querySelector('svg').querySelector('defs');
		//console.log(defs);
		var icon = document.getElementById(svgName);
		$('#'+svgName).find('path,circle').attr("class", "");
	});

});


function hasClass(ele,cls) {
  return ( (" " + ele.className + " ").replace(/[\n\t]/g, " ").indexOf(cls) > -1 )
}

function addClass(ele,cls) {
  if (!hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
  if (hasClass(ele,cls)) {
    var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
    ele.className=ele.className.replace(reg,' ');
  }
}