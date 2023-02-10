@extends('layouts.index')
@section('title','Track Bus')

@section('passenger_content')
    <!-- Main Content -->
    <main id="main" data-aos="fade-up">
        
        <!-- Header -->
        <section class="breadcrumbs track">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-dark">Real-Time <span>Bus Status</span> </h2>
                    <ol>
                        <li class="text-blue"><a href="/#home">Home</a></li>
                        <li class="text-dark">Track Bus</li>
                    </ol>
                </div>
                <h3>View the current bus location using Google Maps.</h3>
            </div>
        </section>

        <!-- Map -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div id="realtime_map_status">
                </div>
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div id="map" class="layout-container"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="portfolio-info">
                            <h3>Bus Trip Information</h3>
                            <ul>
                                <li><strong>Departure</strong>: <span id="ETD"></span></li>
                                <li><strong>Arrival</strong>: <span id="ETA"></span></li>
                                <li><strong>Duration</strong>: <span id="DURATION"></span></li>
                                <li><strong>Distance</strong>: <span id="DISTANCE"></span></li>
                                <li><strong>Current Location</strong>: <span id="LOCATION"></span></li>
                                <hr>
                                <li><strong>Trip Number</strong>: Trip {{$trip->trip_no}}</li>
                                <li><strong>Bus Company</strong>: {{$trip->personnel_schedule->schedule->company->company_name}}</li>
                                <li><strong>Bus Number</strong>: {{$trip->personnel_schedule->bus->bus_no}}</li>
                                <?php
                                $type = '';
                                if($trip->personnel_schedule->bus->bus_type == 1){
                                    $type = 'Airconditioned';
                                }else{
                                    $type = 'Non-Airconditioned';
                                }
                                ?>
                                <li><strong>Bus Type</strong>: {{$type}}</li>
                                <?php 
                                    $orig = ''; 
                                    $dest = '';
                                    $from_to_location = '';
                                    if($trip->inverse == 1){
                                        $from_to_location = $destination.' - '.$origin;
                                    }else if($trip->inverse == 0){
                                        $from_to_location = $origin.' - '.$destination;
                                    }
                                ?>
                                <li><strong>Route</strong>: {{$from_to_location}}</li>
                            </ul>
                        </div>
                        <div class="portfolio-info mt-4" >
                            <h3>Bus Status Legend</h3>
                            <ul><span class="badge bg-label-dark me-1">N/A</span> Status is not available or no status recorded yet.</ul>
                            <ul><span class="badge bg-label-secondary me-1">Break</span> Bus Trip is on break or on bus stop.</ul>
                            <ul><span class="badge bg-label-info me-1">Departed</span> Bus Trip has departed from its current location.</ul>
                            <ul><span class="badge bg-label-danger me-1">Cancelled</span> Bus Trip has been cancelled due to unforeseen problems.</ul>
                            <ul><span class="badge bg-label-success me-1">Arrived</span> Bus Trip has reached its destination and ended.</ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7heM-_bsE_CpTJCieZ5R3wkZqAzm5XG0&region=PH&language=EN&callback=initMap&v=weekly" async ></script>

    <script>
        let map;
        let marker;
        let directionsDisplay;
        let directionsService;
        let infowindow;

        // Initialize Map
        function initMap() {
            infowindow;
            marker;
            directionsDisplay;
            directionsService = new google.maps.DirectionsService();

            // GMaps First Position
            function initialize() {

                // Gmaps Direction Renderer
                directionsDisplay = new google.maps.DirectionsRenderer({
                    suppressMarkers: true
                });

                // Initial Coordinates
                var cdo = new google.maps.LatLng(@json($orig_latitude), @json($orig_longitude));
                var mapOptions = {
                    zoom: 7,
                    center: cdo,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: 'cooperative',
                    mapTypeControl: true,
                    scrollwheel: true,
                };
                
                // Gmaps Map
                map = new google.maps.Map(document.getElementById('map'), mapOptions);
                directionsDisplay.setMap(map);
                var start = new google.maps.LatLng(@json($orig_latitude), @json($orig_longitude));
                var end = new google.maps.LatLng(@json($dest_latitude), @json($dest_longitude));
                var request = {
                    origin: start,
                    destination: end,
                    avoidHighways: false,
                    avoidTolls: false,
                    travelMode: 'DRIVING',
                    unitSystem: google.maps.UnitSystem.METRIC,
                    drivingOptions: {
                        departureTime: new Date(Date.now() + 10000), 
                        trafficModel: 'bestguess'
                    },
                };

                // GMaps Response
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        ETD.textContent = @json($dep);
                        // GMaps Distance & Duration Display
                        var d = new Date((Date.now()+(response.routes[0].legs[0].duration_in_traffic.value)*1000));
                        ETA.textContent = formatAMPM(new Date(d));
                        
                     
                        
                        DURATION.textContent = response.routes[0].legs[0].duration_in_traffic.text;
                        DISTANCE.textContent = response.routes[0].legs[0].distance.text;
                        directionsDisplay.setDirections(response);
                        directionsDisplay.setMap(map);

                        // GMaps Marker Info
                        var startLocation = new Object();
                        var endLocation = new Object();
                        var legs = response.routes[0].legs;
                        for (i = 0; i < legs.length; i++) {
                            if (i == 0) {
                                startLocation.latlng = legs[i].start_location;
                                startLocation.address = legs[i].start_address;
                            }
                            if (i == legs.length - 1) {
                                endLocation.latlng = legs[i].end_location;
                                endLocation.address = legs[i].end_address;
                            }
                            var steps = legs[i].steps;
                        }

                        // Call CreateMarker Function
                        LOCATION.textContent = startLocation.address;
                        createMarker(endLocation.latlng, "Destination", endLocation.address, "http://www.google.com/mapfiles/markerB.png");
                        createMarker(startLocation.latlng, "Origin ("+response.routes[0].legs[0].duration_in_traffic.text+") ("+response.routes[0].legs[0].distance.text+")", startLocation.address, "http://www.google.com/mapfiles/marker_greenA.png");
                    
                    } else {
                        // Error Message for each Response Status
                        if (status == 'ZERO_RESULTS') {
                            alert('No route could be found between the origin and destination.');
                        } else if (status == 'UNKNOWN_ERROR') {
                            alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
                        } else if (status == 'REQUEST_DENIED') {
                            alert('This webpage is not allowed to use the directions service.');
                        } else if (status == 'OVER_QUERY_LIMIT') {
                            alert('The webpage has gone over the requests limit in too short a period of time.');
                        } else if (status == 'NOT_FOUND') {
                            alert('At least one of the origin, destination, or waypoints could not be geocoded.');
                        } else if (status == 'INVALID_REQUEST') {
                            alert('The Directions Request provided was invalid.');                   
                        } else {
                            alert("There was an unknown error in your request. Request Status: \n\n"+status);
                        }
                    }
                });
            }

            // CreateMarker Function
            function createMarker(latlng, label, html, url) {
                infowindow = new google.maps.InfoWindow({
                    disableAutoPan: false,
                    maxWidth: 180
                });
                var contentString = '<b>' + label + '</b><br>' + html;
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: url,
                    title: label,
                    zIndex: Math.round(latlng.lat() * -100000) << 5
                });
                infowindow.setContent(contentString);
                infowindow.open(map, marker);
            }

            // Load Window
            google.maps.event.addDomListener(window, 'load', initialize);
        }

        // GMaps Setting New Positon
        function updatePosition(newLat, newLng){

            // Remove Markers etc.
            marker.setMap(null);
            infowindow.setMap(null);
            directionsDisplay.setMap(null);

            // Gmaps Direction Renderer
            directionsDisplay = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            
            // Gmaps Map
            directionsDisplay.setMap(map);
            var start = new google.maps.LatLng(newLat, newLng);
            var end = new google.maps.LatLng(@json($dest_latitude), @json($dest_longitude));
            var request = {
                origin: start,
                destination: end,
                avoidHighways: false,
                avoidTolls: false,
                travelMode: 'DRIVING',
                unitSystem: google.maps.UnitSystem.METRIC,
                drivingOptions: {
                    departureTime: new Date(Date.now() + 10000), 
                    trafficModel: 'bestguess'
                },
            };

            // GMaps Response
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    Controller.Post('/api/trip/departure', { 'trip_id': @json($trip->id) }).done(function(res) {
                        ETD.textContent = res;
                    })
                        // GMaps Distance & Duration Display
                        var d = new Date((Date.now()+(response.routes[0].legs[0].duration_in_traffic.value)*1000));
                        ETA.textContent = formatAMPM(new Date(d));
                        
                        DURATION.textContent = response.routes[0].legs[0].duration_in_traffic.text;
                        DISTANCE.textContent = response.routes[0].legs[0].distance.text;
                        directionsDisplay.setDirections(response);
                        directionsDisplay.setMap(map);

                        // GMaps Marker Info
                        var startLocation = new Object();
                        var endLocation = new Object();
                        var legs = response.routes[0].legs;
                        for (i = 0; i < legs.length; i++) {
                            if (i == 0) {
                                startLocation.latlng = legs[i].start_location;
                                startLocation.address = legs[i].start_address;
                            }
                            if (i == legs.length - 1) {
                                endLocation.latlng = legs[i].end_location;
                                endLocation.address = legs[i].end_address;
                            }
                            var steps = legs[i].steps;
                        }

                        // Call CreateMarker Function
                        LOCATION.textContent = startLocation.address;
                        createMarker(endLocation.latlng, "Destination", endLocation.address, "http://www.google.com/mapfiles/markerB.png");
                        createMarker(startLocation.latlng, "Origin ("+response.routes[0].legs[0].duration_in_traffic.text+") ("+response.routes[0].legs[0].distance.text+")", startLocation.address, "http://www.google.com/mapfiles/marker_greenA.png");
                    
                } else {
                    // Error Message for each Response Status
                    if (status == 'ZERO_RESULTS') {
                        alert('No route could be found between the origin and destination.');
                    } else if (status == 'UNKNOWN_ERROR') {
                        alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
                    } else if (status == 'REQUEST_DENIED') {
                        alert('This webpage is not allowed to use the directions service.');
                    } else if (status == 'OVER_QUERY_LIMIT') {
                        alert('The webpage has gone over the requests limit in too short a period of time.');
                    } else if (status == 'NOT_FOUND') {
                        alert('At least one of the origin, destination, or waypoints could not be geocoded.');
                    } else if (status == 'INVALID_REQUEST') {
                        alert('The Directions Request provided was invalid.');                   
                    } else {
                        alert("There was an unknown error in your request. Request Status: \n\n"+status);
                    }
                }
            });

            // CreateMarker Function
            function createMarker(latlng, label, html, url) {  
                infowindow.setMap(null);                  
                infowindow = new google.maps.InfoWindow({
                    disableAutoPan: false,
                    maxWidth: 180
                });
                var contentString = '<b>' + label + '</b><br>' + html;
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: url,
                    title: label,
                    zIndex: Math.round(latlng.lat() * -100000) << 5
                });
                infowindow.setContent(contentString);
                infowindow.open(map, marker);
            }
        }

        // Echo
        Echo.channel('rtbtsWeb')
            .listen('GPSMoved', (e) => {
                if(@json($bus_id) == e.bus_id){
                    updatePosition(e.lat, e.lng);
                }
        });

        // Convert Date to Time AM/PM
        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        };

    </script>

    <script>
        function loadXMLDoc_Map() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_map_status").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "/tbl-map-status/"+@json($trip_id), true);
            xhttp.send();
        }
        setInterval(function(){
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            loadXMLDoc_Map();
        },1000);
        window.onload = loadXMLDoc_Map;
    </script>
@endsection