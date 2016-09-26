var marker;
var zoom = 16;
var message = 'Do you want to change your address?';
var map;

function initMapOpt(flag)
{
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: zoom,
		center: {lat: latitude, lng: longitude}
	});

	marker = new google.maps.Marker({
		map: map,
		draggable: flag,
		animation: google.maps.Animation.DROP,
		position: {lat: latitude, lng: longitude}
	});
}

function initMap() {
	initMapOpt(true);

	// Add event
	marker.addListener('click', toggleBounceClick);
	marker.addListener('mouseup', toggleBounceUp);

	// Animation Flag
	marker.setAnimation(google.maps.Animation.BOUNCE);
}

function initMapView() {
	initMapOpt(false);
}

// Set location
function toggleBounceClick() {
	marker.setAnimation(google.maps.Animation.BOUNCE);
	bootbox.confirm(message, function(flag) {
			if (flag) {
				if (checkLogin()) {
					marker.setAnimation(null);
				    // Get address
				    latitude = marker.getPosition().lat();
					longitude = marker.getPosition().lng();

					getAddress(latitude, longitude);
				} else {
					showNotification('Login to continue!');
				}
			}
		}
	);
}

function toggleBounceUp() {
	marker.setAnimation(google.maps.Animation.BOUNCE);
}

// Get address from latitude & longitude
function getAddress(lat, lng) {
	var request = new XMLHttpRequest();
	var method = 'GET';
	var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true';
	var async = true;

	request.open(method, url, async);
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200) {
			var data = JSON.parse(request.responseText);
			var address = data.results[0];
			
			$('#user_address').text(address.formatted_address);
			scope.user['address'] = address.formatted_address;

			// Update address
			ajaxJson('/ajax/update/address', {address : address.formatted_address}, 'POST');

			// Update map
			ajaxJson('/ajax/update/map', {map : lat + ',' + lng}, 'POST');

			mapCenter = map.getCenter();
		}
	};
	request.send();
}