//Date functions(restrict people form picking past dates)
//

//Google Maps initialization, requesting location services from user
var map, infoWindow, marker = null, markerA = null, markerB = null;
var geocoder;
var directionsDisplay;
var directionsService;
var pointA = null, pointB = null;

function initMap() {
    geocoder = new google.maps.Geocoder();
    directionsDisplay = new google.maps.DirectionsRenderer();
    directionsService = new google.maps.DirectionsService();
    map = new google.maps.Map(document.getElementById('map'), {zoom: 17, center: {lat: 38.986918, lng: -76.942554}});
    marker = new google.maps.Marker({position: {lat: 38.986918, lng: -76.942554}, map: map});
    infoWindow = new google.maps.InfoWindow();
    directionsDisplay.setMap(map);
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
            
            infoWindow.setPosition(pos);
            map.setCenter(pos);
            marker.setPosition(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        handleLocationError(false, infoWindow, map.getCenter());
    }
    
    
    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center); 
     });
    google.maps.event.addDomListener(window, 'load', initMap);
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}
//Geocoding
function codeStart() {
    var address = document.getElementById("start").value;
    geocoder.geocode( {'address' : address}, function(results, status) {
        if (status == 'OK') {
            marker.setMap(null);
            if (markerA !== null) {
                markerA.setMap(null);
            }
            pointA = results[0].geometry.location;
            map.setCenter(results[0].geometry.location);
            document.getElementById("start").value = results[0].formatted_address;
            markerA = new google.maps.Marker({map: map, position: results[0].geometry.location});
            if (pointB !== null) {
                directions();
            }
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function codeDestination() {
    var address = document.getElementById("destination").value;
    geocoder.geocode( {'address' : address}, function(results, status) {
        if (status == 'OK') {
            marker.setMap(null);
            if (pointB !== null) {
                markerB.setMap(null);
            }
            pointB = results[0].geometry.location;
            map.setCenter(results[0].geometry.location);
            document.getElementById("destination").value = results[0].formatted_address;
            markerB = new google.maps.Marker({map: map, position: results[0].geometry.location});
            if (pointA !== null) {
                directions();
            }
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

//Showing directions

function directions() {
    var request = {
        origin: pointA,
        destination: pointB,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            markerA.setMap(null);
            markerB.setMap(null);
            directionsDisplay.setDirections(response);
        }
    });
}

//Autocomplete initialization
function initStartAutocomplete() {
    
}

//Verify data
function processData() {
    var date = document.getElementById("date");
    var startTime = document.getElementById("starttime");
    var arrivalTime = document.getElementById("arrivaltime");
    var today = new Date().toISOString().split('T')[0];
    console.log(date.value);
    console.log(startTime.value);
    console.log(arrivalTime.value);
    console.log(today);
    
    if (pointA === null) {
        document.getElementById("starterror").innerHTML = "&nbsp;&nbsp;Enter a starting location";
    } else {
        document.getElementById("starterror").innerHTML = "&nbsp;";
    }
    if (pointB === null) {
        document.getElementById("destinationerror").innerHTML = "&nbsp;&nbsp;Enter a destination location";
    } else {
        document.getElementById("destinationerror").innerHTML = "&nbsp;";
    }
    if (date.value === "") {
        document.getElementById("dateerror").innerHTML = "&nbsp;&nbsp;Enter a date";
    } else if(date.value < today) {
        document.getElementById("dateerror").innerHTML = "&nbsp;&nbsp;Invalid date";
    } else {
        document.getElementById("dateerror").innerHTML = "&nbsp;";
    }
    if (startTime.value === "" && arrivalTime.value === "") {
        document.getElementById("timeerror").innerHTML = "&nbsp;&nbsp;Please enter a start or arrival time";
    } else {
        document.getElementById("timeerror").innerHTML = "&nbsp;";
    }
    
}


document.getElementById("start").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        codeStart();
    }
});

document.getElementById("destination").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        codeDestination();
    }
});