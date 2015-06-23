// Trails base layer

// distance in meters to use for outerspatial query for trailheads
var max_distance_to_transit = 1000

// Outdoor layer
var outdoor_base = new L.tileLayer('http://{s}.tiles.mapbox.com/v3/trilliumtransit.i7jmn75e/{z}/{x}/{y}.png', {
    maxZoom: 16
});
var outdoor_labels = new L.tileLayer('http://{s}.tiles.mapbox.com/v3/trilliumtransit.5c3oium5/{z}/{x}/{y}.png', {
    maxZoom: 16
});

custom_tile_layers[4] = new GTFSMapLayer('outdoor', outdoor_base, outdoor_labels);


var trailheads = new Array();
var trailhead_layer_group = L.layerGroup();
var trailhead_markers = Array();

var trailheadIcon = L.icon({
    iconUrl: 'icons/trailhead_pin.png',
    iconSize: [36, 36], // size of the icon
    iconAnchor: [18, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
});

function load_trailheads() {
    console.log('trailheads.length: ' + trailheads.length);

    if (trailheads.length == 0) {
        load_trailheads_page(1);
    }
}

// it looks as though every time this is called, OuterSpatial is called again. to allow people to turn the layer on and off and explore, OuterSpatial should just be called when the trailhead_markers array is empty.
function load_trailheads_page(page) {
    _page = page || 1;
    var trailhead_marker = Array();

    var trailheads_object = query_trails_api('', 'trailheads?', 'transit_feed_name=' + gtfs_api_feed_name + '&max_distance_to_transit_stop=' + max_distance_to_transit + '&per_page=100');
    var paging = trailheads_object.paging;
    trailheads_object = trailheads_object.data;

    for (i = 0; i < trailheads_object.length; i++) {
        var trailhead_id = trailheads_object[i].id;
        trailheads[trailhead_id] = trailheads_object[i];
        console.log(trailheads[trailhead_id]);
    }

    var marker_i = 0;

    for (var trailhead_id in trailheads) {

        var trailhead = trailheads[trailhead_id];

        var LamMarker = new L.marker([trailhead.geometry.coordinates[1], trailhead.geometry.coordinates[0]], {
            icon: trailheadIcon
        }).bindPopup(trailhead.name);
        LamMarker.trailhead_id = trailhead.id;

        // below is duplicative -- inspect later
        LamMarker.trailhead_marker_id = trailhead.id;

        LamMarker.on('click', update_trailhead_info);



        trailhead_markers.push(LamMarker);
        trailhead_layer_group.addLayer(trailhead_markers[marker_i]);

        marker_i++;

    }

    if (paging.last_page) {
        trailhead_layer_group.addTo(map);
    } else {
        load_trailheads(_page + 1);
    }

}

var trip_routes_polylines = new Array();
var trail_polyline_options = {
    color: '#188534',
    weight: 8,
    opacity: 0.85
};


function get_trips(trailhead_id) {
    var trip_ids = trailheads[trailhead_id].trip_ids;
    return trip_ids;
}

function show_trips_for_trailhead(trailhead_id) {

    var trip_ids = get_trips(trailhead_id);

    for (var i in trip_ids) {
        var trip_id = trip_ids[i];

        if (typeof trip_routes_polylines[trip_id] == "undefined") {

            var trip_object = query_trails_api(trip_id, 'trips/');
            var trip_route_array = trip_object.geometry.coordinates.map(
                function(el) {
                    return [el[1], el[0]]
                });

            if ((typeof trip_routes_polylines[trip_id]) == "undefined") {
                trip_routes_polylines[trip_id] = L.polyline(trip_route_array, trail_polyline_options);
            }
        }
        if (typeof trip_routes_polylines[trip_id] != "undefined") {
            trip_routes_polylines[trip_id].addTo(map);
            active_trip_ids.push(trip_id);
        }
    }
}

var trips_details = new Array();

function get_trip_details(trip_id) {
    if (typeof trips_details[trip_id] == "undefined") {
        trips_details[trip_id] = query_trails_api(trip_id, 'trips/', '');
    }

    if (typeof trips_details[trip_id] != "undefined") {
        return trips_details[trip_id];
    }
}

var organization_details = new Array();

function get_organization_details(org_id) {
    if (typeof organization_details[org_id] == "undefined") {
        organization_details[org_id] = query_trails_api(org_id, 'organizations/', '');
    }

    if (typeof organization_details[org_id] != "undefined") {
        return organization_details[org_id];
    }
}

var trails_api_base_url = 'https://api.outerspatial.com/v0/';

function query_trails_api(variable, preceeding_parameter, subsequent_parameter) {
    if (typeof preceeding_parameter === 'undefined') {
        preceeding_parameter = '';
    }
    if (typeof subsequent_parameter === 'undefined') {
        subsequent_parameter = '';
    }

    var question_mark = '';

    if (preceeding_parameter.indexOf("?") == -1 && subsequent_parameter.indexOf("?") == -1) {
        question_mark = '?';
    }

    var api_query_url = trails_api_base_url + preceeding_parameter + variable + subsequent_parameter + question_mark;
    console.log('api_query_url:' + api_query_url);

    var proxy_script = 'php-simple-proxy-master/ba-simple-proxy.php';
    console.log(api_query_url);
    var api_query_url_proxy = proxy_script + '?url=' + encodeURIComponent(api_query_url) + '&trails_api=1';
    var result_object = load_data(api_query_url_proxy, 'json');
    var result_object_contents = result_object.contents;

    return result_object_contents;

}


function update_trailhead_info(e) {
    //    console.log(e);

    var trailhead_info = trailheads[e.target.trailhead_marker_id];
    var trailhead_id = trailhead_info.id;

    if (trailhead_info.park_name) {
        var main_header = trailhead_info.park_name;
        var sub_header = trailhead_info.name;
    } else {
        var main_header = trailhead_info.name;
    }

    var new_content = '<div style="padding:3px;margin:4px;border-bottom:1px solid;margin-bottom:3px;margin:0px;"><span style="font-weight:bold;font-size:18px;">' +
        main_header +
        '</span><br/>';

    if (sub_header) {
        new_content += '<strong>' + sub_header + '</strong><br/>';
    }

    new_content += '</div><div style="font-size:12px;">' + trailhead_info.description.trunc(500, true);

    new_content += ' <a href="http://www.outerspatial.com/trailheads/' + trailhead_id + '">More at OuterSpatial &gt;</a>';

    if (trailhead_info.organization_ids.length > 0) {
        org_details = get_organization_details(trailhead_info.organization_ids[0]);
        new_content += '<p>Managed by <strong>';
        if (org_details.website !== null) {
            new_content += '<a href="' + org_details.website + '">';
        }
        new_content += org_details.name;
        if (org_details.website !== '') {
            new_content += '</a>';
        }
        new_content += '</strong>.</p>';
    }


    var trip_ids = get_trips(trailhead_id);

    if (trip_ids.length > 0) {

        new_content += '<h4>Trips from this trailhead:</h4><ul>'

        for (var i in trip_ids) {
            var trip_id = trip_ids[i];
            new_content += '<li><a href="http://www.outerspatial.com/trips/' + trip_id + '">' + get_trip_details(trip_id).name + '</a></li>';
        }

        new_content += '</ul>';

    }

    new_content += '</div>';

    var trailhead_images_object = query_trails_api(e.target.trailhead_id, 'trailheads/', '/images/').data;

    if (trailhead_images_object.length > 0) {
        if (typeof trailhead_images_object[0].medium !== 'undefined' && trailhead_images_object[0].medium !== null) {
            var first_image_url = trailhead_images_object[0].medium.url;
            new_content += '<img width="300" src="' + first_image_url + '"/>';
        }
    }

    new_content += '</div>';

    new_content += '<div style="background-color: rgb(233, 246, 252);padding:10px;"><strong>Get transit directions here using Google Maps</strong><br/><form name="f" action="http://www.trilliumtransit.com/redirect/google_redirect.php"><input type="hidden" name="ie" value="UTF8"/><input type="hidden" name="f" value="d"/>Start: <input type="text" alt="Start address" style="width:15em" size="15" name="saddr" tabindex="1" maxlength="2048" id="saddr"/><br/> <font size="-2">e.g. 355 W Robles Ave</font><br/><input type="hidden" name="daddr" value="' + trailhead_info.geometry.coordinates[1] + ',' + trailhead_info.geometry.coordinates[0] + '"/><input type="hidden" name="sll" value="38.439979,-122.714939"/><br/> <input type="submit" value="Get Directions" tabindex="1"/><font size="-1"><input type="hidden" name="ttype" value="now"> <input type="hidden" value="175" name="agency"/> </form>   </div>';


    show_trips_for_trailhead(trailhead_info.id);

    e.target.setPopupContent(new_content);

}


// borrowed from http://stackoverflow.com/a/1199420

String.prototype.trunc =
    function(n, useWordBoundary) {
        var toLong = this.length > n,
            s_ = toLong ? this.substr(0, n - 1) : this;
        s_ = useWordBoundary && toLong ? s_.substr(0, s_.lastIndexOf(' ')) : s_;
        return toLong ? s_ + '&hellip;' : s_;
};

// borrowed from http://stackoverflow.com/a/5454297

function shorten_text(text_string, max_chars) {
    console.log('text_string: ' + text_string);
    console.log(typeof(text_string));
    console.log('this is shortening the text');
    var shortened_text = text_string.replace(new RegExp("^(.{" + max_chars + "}[^\s]*).*"), "$1");
    console.log('shortened_text: ' + shortened_text);
    return shortened_text;
}

map.on('popupclose', function() {
    console.log('remove_trips has been called.');
    for (var i in active_trip_ids) {
        var trip_id = active_trip_ids[i];
        console.log('trip_id to remove: ' + trip_id);
        remove_from_array(trip_id, active_trip_ids);
        map.removeLayer(trip_routes_polylines[trip_id]);
    }
});

var active_trip_ids = new Array();

function remove_trips() {
    for (var i in active_trip_ids) {
        var trip_id = trip_ids[i];
        console.log('trip_id to remove: ' + trip_id);
        remove_from_array(trip_id, active_trip_ids);
        map.removeLayer(trip_routes_polylines[trip_id]);
    }
}


function remove_trip(e) {

    var trailhead_id = e.target.trailhead_marker_id;
    var trip_ids = get_trips(trailhead_id);

    for (var i in trip_ids) {
        var trip_id = trip_ids[i];
        map.removeLayer(trip_routes_polylines[trip_id]);
    }

}




function toggle_trails_layer(checked) {

    if (checked) {
        load_trailheads();
    } else {
        remove_trailheads();

    }

}

function remove_trailheads() {
    map.removeLayer(trailhead_layer_group);
}