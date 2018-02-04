
var lat;
var long;
var home;
var map;
var locations;
var markers = [];
// Init google map
function initMap() {
	var directionsDisplay = new google.maps.DirectionsRenderer;
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

			 //Put marker in the map
			 var marker = new google.maps.Marker({
				 map: resultsMap,
				 position: results[0].geometry.location
			 });
			 home = results[0].formatted_address;
		 } else {
			 alert('Geocode was not successful for the following reason: ' + status);
		 }
	 });
 }

// 	 function calculateAndDisplayRoute(directionsService, directionsDisplay) {
// 		 directionsService.route({
// 			 origin: document.getElementById('start').value,
// 			 destination: document.getElementById('end').value,
// 			 travelMode: 'DRIVING'
// 		 }, function(response, status) {
// 			 if (status === 'OK') {
// 				 directionsDisplay.setDirections(response);
// 			 } else {
// 				 window.alert('Directions request failed due to ' + status);
// 			 }
// 		 });
// }

	$("#go").click(function respons() {

		$.post("/codeacademy/datadog/start.php",
			{
				home: home,
				lati: lat,
				longi: long,
				dist: $("#num").val()
			},
			function (data, status, xhr) {
				console.log(data);
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
				$("tbody").append("<tr><td>" + field.brewery_id + "</td><td>" + field.name + "</td><td>" + field.latitude + "</td><td>" + field.longitude + "</td><td>" + field.dist + "Km</td></tr>");
				});
				$('#list1').html('');
				$('#list1').append("<li class='collection-header align'><h4>Beers types collection</h4></li>");
				$.each(data['beers'], function (i, field) {
					$("#list1").append("<li class='collection-item'><div>"+(i+1)+". "+field.name +"</div></li>");


				});




				directionsService = new google.maps.DirectionsService;
				directionsDisplay = new google.maps.DirectionsRenderer;


				// Put marker in the map

				// function clearMarkers() {
				// 	for (var i = 0; i < locations.length; i++) {
				// 		markers[i].setMap(null);
				// 	}
				// 	markers = [];
				// }

				for(var i = 0; i < locations.length; i ++){
					// clearMarkers();
					markers = new google.maps.Marker({
						position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
						map: map
					});
				}

				var waypoints = [];

				for(i = 1; i < locations.length -1; i ++){
					waypoints.push({
						location:(locations[i].latitude+', '+locations[i].longitude),
						stopover: false
					})
				}


				directionsDisplay.setMap(null);
				directionsDisplay = new google.maps.DirectionsRenderer();
				directionsDisplay.setMap(map);

				var start = locations[0].latitude +','+ locations[0].longitude;
				var end = locations[locations.length-1].latitude +','+ locations[locations.length-1].longitude;

				drawPath(directionsService, directionsDisplay, start, end, waypoints);



			});
		$("#address").val('');
		$("#num").val('');

	});

function drawPath(directionsService, directionsDisplay,start,end,waypoints) {
	directionsService.route({
		origin: start,
		destination: end,
		waypoints: waypoints,
		optimizeWaypoints: true,
		travelMode: 'WALKING'
	}, function(response, status) {
		if (status === 'OK') {
			directionsDisplay.setDirections(response);
		} else {
			window.alert('Problem in showing direction due to ' + status);
		}
	});
}



