window.onsubmit=processData;

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
    marker = new google.maps.Marker({map: map});
    infoWindow = new google.maps.InfoWindow();
    directionsDisplay.setMap(map);
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
            
            geocoder.geocode({'latLng': pos}, function (results, status) {
                if (status == 'OK') {
                    pointA = results[0].geometry.location;
                    document.getElementById("start").value = results[0].formatted_address.replace(", USA", "");
                    markerA = new google.maps.Marker({map: map, position: results[0].geometry.location});
                    if (pointB !== null) {
                        directions();
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
            
            infoWindow.setPosition(pos);
            map.setCenter(pos);
            markerA.setPosition(pos);
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

/*function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    //infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}*/

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
            document.getElementById("start").value = results[0].formatted_address.replace(", USA", "");
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
            document.getElementById("destination").value = results[0].formatted_address.replace(", USA", "");
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
    
    let isValid = true;
    if (pointA === null) {
        document.getElementById("starterror").innerHTML = "&nbsp;&nbsp;Enter a starting location";
        isValid = false;
    } else {
        document.getElementById("starterror").innerHTML = "&nbsp;";
    }
    if (pointB === null) {
        document.getElementById("destinationerror").innerHTML = "&nbsp;&nbsp;Enter a destination location";
        isValid = false;
    } else {
        document.getElementById("destinationerror").innerHTML = "&nbsp;";
    }
    if (date.value === "") {
        document.getElementById("dateerror").innerHTML = "&nbsp;&nbsp;Enter a date";
        isValid = false;
    } else if(date.value < today) {
        document.getElementById("dateerror").innerHTML = "&nbsp;&nbsp;Invalid date";
        isValid = false;
    } else {
        document.getElementById("dateerror").innerHTML = "&nbsp;";
    }
    if (startTime.value === "" && arrivalTime.value === "") {
        document.getElementById("timeerror").innerHTML = "&nbsp;&nbsp;Please enter a start or arrival time";
        isValid = false;
    } else {
        document.getElementById("timeerror").innerHTML = "&nbsp;";
    }
    
    if (!isValid) {
        return false;
    } else {
        addRowHandlers();
        return true;
    }
}
        
$(function(){ // this will be called when the DOM is ready
    document.getElementById("list").addEventListener("click", function(e) {
        if (e.target && e.target.nodeName == "LI") {
            let id = "start"+e.target.id;
            document.getElementById("start").value = document.getElementById(id).innerHTML;
            document.getElementById("destination").value = document.getElementById("destination"+e.target.id).innerHTML;
            codeStart();
            codeDestination();
        } else if (e.target && e.target.nodeName == "INPUT") {
            let carpoolid = e.target.id.replace("join", "");
            window.location.href = ("search_riders.php?carpoolid=" + carpoolid);
        }
    });
});

$(function(){ // this will be called when the DOM is ready
    document.getElementById("start").addEventListener("keydown", function(event) {
        if (event.keyCode == 13 || event.keyCode == 9) {
            codeStart();
        }
    });
});

$(function(){ // this will be called when the DOM is ready
    document.getElementById("destination").addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode == 13 || event.keyCode == 9) {
            codeDestination();
        }
    });
});