
var lat;
var long;
var home;
var map;
var locations;
var markers = [];
var flightPath;
// Init google map
function initMap() {
	 directionsDisplay = new google.maps.DirectionsRenderer;
	 map = new google.maps.Map(document.getElementById('map'), {
		zoom: 6,
		center: {lat: -34.397, lng: 150.644}
	});
	var geocoder = new google.maps.Geocoder();

	document.getElementById('button').addEventListener('click', function() {
		geocodeAddress(geocoder, map);

	});

}


//Get addres from google maps geocode
 function geocodeAddress(geocoder, resultsMap) {
	 var address = document.getElementById('address').value;
	 geocoder.geocode({'address': address}, function (results, status) {
		 if (status === 'OK') {
			 resultsMap.setCenter(results[0].geometry.location);
			 lat = results[0].geometry.location.lat();//Latitude
			 long = results[0].geometry.location.lng();//longitude

			  markers.push( new google.maps.Marker({
				 map: resultsMap,
				 position: results[0].geometry.location
			 }));
			 home = results[0].formatted_address;
		 } else {
			 alert('Geocode was not successful for the following reason: ' + status);
		 }
	 });
 }


	$("#go").click(function respons() {

		$.post("/codeacademy/datadog/start.php",
			{
				home: home,
				lati: lat,
				longi: long,
				distance: $("#num").val()
			},
			function (data) {

				locations = data['brewery'];

				$('#distance').html('');
				$('#distance').html("Total distance Travelled: "+data.dist+" km");
				$('#beersColection').html('');
				$('#beersColection').html("Collected " + data.beers.length  +" beer types");
				$('.tname').html('');
				$('.tname').append("<h4>Breweries and distances</h4>");
				$('table').html('');
				$('table').append("<thead><tr><th>Id</th><th>Brewery</th><th>Latitude</th><th>Longitude</th><th>Distance</th></tr></thead><tbody></tbody>");
				$.each(data['brewery'], function (i, field) {
				$("tbody").append("<tr><td>" + field.brewery_id + "</td><td>" + field.name + "</td><td>" + field.latitude + "</td><td>" + field.longitude + "</td><td>" + field.distance + "Km</td></tr>");
				});
				$('#list1').html('');
				$('#list1').append("<li class='collection-header align'><h4>Beers types collection</h4></li>");
				$.each(data['beers'], function (i, field) {
					$("#list1").append("<li class='collection-item'><div>"+(i+1)+". "+field.name +"</div></li>");


				});

				var path = [];
				for(var i = 0; i < locations.length; i ++) {
					 path.push(new google.maps.LatLng(locations[i].latitude, locations[i].longitude))
				}

				flightPath = new google.maps.Polyline({
					path: path,
					geodesic: true,
					strokeColor: '#FF0000',
					strokeOpacity: 1.0,
					strokeWeight: 2
				});
				flightPath.setMap(map);


				for(var m = 0; m < locations.length; m ++){
					markers.push( new google.maps.Marker({
						position: new google.maps.LatLng(locations[m].latitude, locations[m].longitude),
						map: map
					}));
				}


			});
		$("#address").val('');
		$("#num").val('');

	});


function removeLine() {
	flightPath.setMap(null);
}


// Sets the map on all markers in the array.
function setMapOnAll(map) {
	for (var m = 0; m < markers.length; m++) {
		markers[m].setMap(map);
	}
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
	setMapOnAll(null);
}
// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
	clearMarkers();
	markers = [];
}

document.getElementById('button').addEventListener('click', function() {
	if(flightPath){
		removeLine();
	}
	deleteMarkers();
});
