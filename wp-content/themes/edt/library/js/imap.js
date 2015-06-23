//imap

var routeButtons = {};  // this should hav the jquery dom objs of the checkboxes and li's as well as a bool for each if visible
var mapTileButtons = {}; // this should hav the jquery dom objs of the map tile buttons and a bool for each if toggled
var localRoutes = ["20","30","40","60"];
var commuterRoutes = ["50x","c"];
var pageIsLoaded = false;

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function insertParam(key, value) {
	key = escape(key); value = escape(value);

	var kvp = document.location.search.substr(1).split('&');
	if (kvp == '') {

		var newPath =  '?' + key + '=' + value;
		history.replaceState(null,null, newPath);
	}
	else {

		var i = kvp.length; var x; while (i--) {
			x = kvp[i].split('=');

			if (x[0] == key) {
				x[1] = value;
				kvp[i] = x.join('=');
				break;
			}
		}

		if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

	   
		history.replaceState(null,null, '?'+kvp.join('&'));
	   
	}
}


function RouteLegendButton($_li) {
	this.toggled = false;
	this.$li = $_li;
	this.$checkbox = $_li.find('input:checkbox');
	
	var that = this;
	
	$_li.click(function(e) {
			
		if($(event.target).hasClass('home-legend-button')) {
			that.toggle();
		}
		
	});  
	
	this.$checkbox.click(function(e) {
		event.stopPropagation();
		e.preventDefault();
	});
	
	this.toggle = function() {
		
		this.toggled = !this.toggled;
		this.$li.toggleClass('toggled');
		this.$checkbox.prop("checked", !this.$checkbox.prop("checked"));
		this.update();
	}
	this.hide = function() {
		
		this.toggled = false;
		this.$li.removeClass('toggled');
		this.$checkbox.prop("checked", false);
		this.update();
	}
	this.show = function() {
		
		this.toggled = true;
		this.$li.addClass('toggled');
		this.$checkbox.prop("checked", true);
		this.update();
	}
	
	this.update = function() {
		updateRoutesShown();
	}
}

function TileButton($_a) {
	this.toggled = false;
	this.$a = $_a;
	
	var that = this;
	
	this.$a.click(function() {
		that.toggle();
	});  
	
	
	
	this.toggle = function() {
		
		this.toggled = !this.toggled;
		this.$a.toggleClass('toggled');
		this.update();
	}
	this.hide = function() {
		
		this.toggled = false;
		this.$a.removeClass('toggled');
		this.update();
	}
	this.show = function() {
		
		this.toggled = true;
		this.$a.addClass('toggled');
		this.update();
	}
	
	this.update = function() {
		updateTilesShown();
	}
}


function showRoutesByShortName(args) {
	
	args.forEach(function() {
		
	});
	
}

function showAllRoutes() {
	for (var key in routeButtons) {
		routeButtons[key].show();
	};
}

function hideAllRoutes() {
	for (var key in routeButtons) {
		routeButtons[key].hide();
	};
}

function showLocalRoutes() {
	
	localRoutes.forEach(function(v) {
		routeButtons[v].show();
	});
	
}



function showCommuterRoutes() {
	commuterRoutes.forEach(function(v) {
		routeButtons[v].show();
	});
}

function getCountOfToggledRoutes() {
	var count = 0;
	for (var key in routeButtons) {
		if(routeButtons[key].toggled == true) count ++;
	}
	return count;
	
}
function getCountOfToggledTiles() {
	var count = 0;
	for (var key in mapTileButtons) {
		if(mapTileButtons[key].toggled == true) count ++;
	}
	return count;
	
}

function updateRoutesShown() {
	var visibleRouteIds = [];
	if(pageIsLoaded) {
		var routeParam = '';
		var routeCount = 0;
		for (var key in routeButtons) {
			if(routeButtons[key].toggled) {
				routeParam += key;
				if(routeCount<getCountOfToggledRoutes()-1) routeParam += '+';
				routeCount += 1;
				visibleRouteIds.push(parseInt(routeButtons[key].$li.find('a').attr('rel')));
			}
			
		}
		insertParam('routes', routeParam);
		console.log(visibleRouteIds);
		document.getElementById("imap-holder").contentWindow.focus_routes(visibleRouteIds);
		
	}
}

function updateTilesShown() {
	if(pageIsLoaded) {
		var tilesParam = '';
		var tilesCount = 0;
		for (var key in mapTileButtons) {
			if(mapTileButtons[key].toggled) {
				tilesParam += key;
				if(tilesCount<getCountOfToggledTiles()-1) tilesParam += '+';
				tilesCount += 1;
			}
			
		}
		insertParam('tiles', tilesParam);
	}
}

jQuery(document).ready(function($) {

	if(getParameterByName('nooverlay') === '') {
		$('#ui-big-buttons').removeClass('exited');
	}
	
	


	
	//big button overlay behavior
	$('.ui-big-button').click(function() {
		if($(this).attr('id') === "commuter-large-ui-button" ) {
			showCommuterRoutes();
			$(this).parent().parent().addClass('exited');
		} else { // show local routes
			showLocalRoutes();
			$(this).parent().parent().addClass('exited');			
		}
		$('#ui-big-buttons').addClass('exited');
		insertParam('nooverlay','true');
	});	
	
	// get domobjs for the legend
	var $legendLis = $('#map-legend').find('li');
	$.each($legendLis, function(k, v) {
		var id = $(v).find('.home-legend-button').attr('id');
		routeButtons[id] = new RouteLegendButton($(v));
	});
	
	var $mapeTileAs = $('#map-toggle-tiles a');
	$.each($mapeTileAs, function(k, v) {
		var id = $(v).attr('id');
		mapTileButtons[id] = new TileButton($(v));
	});
	
	//toggle legend buttons from url
	if(getParameterByName('routes') !== '') {
		var routes = getParameterByName('routes').split(' ');
		routes.forEach(function(v) {
			console.log(v);
			routeButtons[v].show();
		});
	} 
	//toggle tile buttons from url
	if(getParameterByName('tiles') !== '') {
		var tiles = getParameterByName('tiles').split(' ');
		tiles.forEach(function(v) {
			console.log(v);
			mapTileButtons[v].show();
		});
	} 
	
	$('#show-all-routes-button').click(showAllRoutes);
	$('#hide-all-routes-button').click(hideAllRoutes);
	
	$('#hide-panel-button, #show-panel-button').click(function() {
		$('#map-ui-container').toggleClass('minimized');
		if($('#map-ui-container').hasClass('minimized')) {
			$('#map-ui-container span').text('Show Options');
		}
		else {
			$('#map-ui-container span').text('Hide Map Options');
		}
	});
	
	pageIsLoaded = true;

});


