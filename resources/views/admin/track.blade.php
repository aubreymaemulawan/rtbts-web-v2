@extends('layouts.app')
@section('title','Track Buses')

@section('modal')
    <!-- Viewing Modal --> 
        <div class="modal fade" id="view-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Viewing Form -->
                <form class="modal-content" id="viewing">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div class="button-wrapper">
                                <p id="update" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div class="mb-3 row">
                            <label for="view-bus_no" class="col-md-4 col-form-label">Bus Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-bus_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-bus_type" class="col-md-4 col-form-label">Bus Type</label>
                            <div class="col-md-8">
                                <select disabled class="form-control" id="view-bus_type" name="view-bus_type">
                                    <option value="1">Airconditioned</option>
                                    <option value="2">Non Airconditioned</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-plate_no" class="col-md-4 col-form-label">Plate Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-plate_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-chassis_no" class="col-md-4 col-form-label">Chassis Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-chassis_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-engine_no" class="col-md-4 col-form-label">Engine Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-engine_no" />
                            </div>
                        </div>
                        <div class="mb-0 row">
                            <label for="view-status" class="col-md-4 col-form-label">Bus Status</label>
                            <div class="col-md-8">
                                <select disabled class="form-control" id="view-status" name="view-status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Go to Edit / Delete Form -->
                    <div id="view-modal-footer" class="modal-footer">
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Viewing Modal -->

    <!-- Adding / Editing Modal -->
        <div class="modal fade" id="main-modal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Adding Form -->
                <form class="modal-content">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="main-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr class="hr-style-1">
                    <div class="modal-body">
                        <!-- Input Hidden ID -->
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->company_id}}">
                        <div class="row g-2">
                            <!-- Input Bus No. -->
                            <div class="col mb-3">
                                <label for="bus_no" class="form-label">Bus Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="number" id="bus_no" name="bus_no" class="form-control" placeholder="00000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_bus_no"></span>
                                </div>
                            </div>
                            <!-- Input Bus Type -->
                            <div class="col mb-3">
                                <label for="bus_type" class="form-label">Bus Type</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="bus_type" name="bus_type">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        <option value="1">Airconditioned</option>
                                        <option value="2">Non Airconditioned</option>
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_bus_type"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Plate No. -->
                            <div class="col mb-3">
                                <label for="plate_no" class="form-label">Plate Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="plate_no" name="plate_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_plate_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Chassis No. -->
                            <div class="col mb-3">
                                <label for="chassis_no" class="form-label">Chassis Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="chassis_no" name="chassis_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_chassis_no"></span>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <!-- Input Engine No. -->
                            <div class="col mb-3">
                                <label for="engine_no" class="form-label">Engine Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="engine_no" name="engine_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_engine_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Color -->
                            <div class="col mb-0">
                                <label for="color" class="form-label">Color (Map View)</label>
                                <div class="input-group input-group-merge">
                                    <input type="color" id="color" name="color" class="form-control"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_color"></span>
                                </div>
                            </div>
                        </div>
                        <div id="main-append" style="display:none"></div>
                    </div>
                    <!-- Submit Form -->
                    <div class="modal-footer">
                        <button id="main-close" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="main-submit" type="button" onclick="Save()" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Adding / Editing Modal -->
@endsection

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Records /</span> Track Buses
        </h4>
        <div class="card">            
            <div id="map" class="layout-container"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7heM-_bsE_CpTJCieZ5R3wkZqAzm5XG0&language=EN&callback=initMap&v=weekly" async ></script>

    <script>
        let map;
        let marker;
        let geocoder;
        let i;
        let bounds;
        var locations = @json($ongoing_trip);

        // Initialize Map
        function initMap(){

            // Initialize
            geocoder = new google.maps.Geocoder();
            bounds = new google.maps.LatLngBounds();
            infowindow = new google.maps.InfoWindow();

            // GMaps First Position
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(8.489911409520484, 124.65757082549597),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            
            // Multiple Markers
            for (i = 0; i < locations.length; i++) {  

                // Marker Color
                const svgMarker = {
                    path: "M13 18H7v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-1a2 2 0 0 1-2-2V2c0-1.1.9-2 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1zM4 5v6h5V5H4zm7 0v6h5V5h-5zM5 2v1h10V2H5zm.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm9 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z",
                    fillColor: locations[i][6],
                    fillOpacity: 1,
                    strokeWeight: 0,
                    rotation: 0,
                    scale: 1.6,
                    anchor: new google.maps.Point(0, 20),
                };

                // Set Marker on Map
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    icon: svgMarker,
                    map: map
                });

                // Bound to Map
                bounds.extend(marker.position);

                // Infowindow on Click
                google.maps.event.addListener(marker, 'click', (function(marker, i) {

                    // Get Address from Marker
                    geocoder.geocode({
                        latLng: marker.getPosition()}, 
                        function(responses) {
                        if (responses && responses.length > 0) {
                        marker.formatted_address = responses[0].formatted_address;
                        } else {
                        marker.formatted_address = 'Cannot determine address at this location.';
                        }
                    });

                    // Return Infowindow
                    return function() {
                        var contentString = '<b>' + locations[i][4] + ' - ' + locations[i][5] + '</b><br>Route: ' + locations[i][0]+ '<br> Trip No. ' + locations[i][8]+ '<br> Status: ' + locations[i][9]+ '<br>Current Location: ' + marker.formatted_address;
                        infowindow.setContent(contentString);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }

            // Fit to Map
            map.fitBounds(bounds);
        }

        // GMaps Setting New Positon
        function updatePosition(newLat, newLng, bus_id){

            // Remove Markers etc.
            marker.setMap(null);
            infowindow.setMap(null);

            // Initialize
            geocoder = new google.maps.Geocoder();
            bounds = new google.maps.LatLngBounds();
            infowindow = new google.maps.InfoWindow();

            // GMaps First Position
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(8.489911409520484, 124.65757082549597),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            
            // Update New Locations
            Controller.Post('/api/track/track_position', { 'company_id': '{{Auth::user()->company_id}}' }).done(function(company, ongoing_trip) {
                var new_locations = ongoing_trip;
            
                // Multiple Markers
                for (i = 0; i < new_locations.length; i++) {  

                    // Marker Color
                    const svgMarker = {
                        path: "M13 18H7v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-1a2 2 0 0 1-2-2V2c0-1.1.9-2 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1zM4 5v6h5V5H4zm7 0v6h5V5h-5zM5 2v1h10V2H5zm.5 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm9 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z",
                        fillColor: locations[i][6],
                        fillOpacity: 1,
                        strokeWeight: 0,
                        rotation: 0,
                        scale: 2,
                        anchor: new google.maps.Point(0, 20),
                    };

                    // Set Marker on Map if New Geolocation
                    if(bus_id == locations[i][3]){
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(newLat, newLng),
                            icon: svgMarker,
                            map: map
                        });
                    }

                    // Set same Marker on Map
                    else{
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            icon: svgMarker,
                            map: map
                        });
                    }

                    // Bound to Map
                    bounds.extend(marker.position);

                    // Infowindow on Click
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {

                        // Get Address from Marker
                        geocoder.geocode({
                            latLng: marker.getPosition()}, 
                            function(responses) {
                            if (responses && responses.length > 0) {
                            marker.formatted_address = responses[0].formatted_address;
                            } else {
                            marker.formatted_address = 'Cannot determine address at this location.';
                            }
                        });

                        // Return Infowindow
                        return function() {
                            var contentString = '<b>' + locations[i][4] + ' - ' + locations[i][5] + '</b><br>Route: ' + locations[i][0]+ '<br> Trip No. ' + locations[i][8]+ '<br> Status: ' + locations[i][9]+ '<br>Current Location: ' + marker.formatted_address;
                            infowindow.setContent(contentString);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    
                }

                // Fit to Map
                map.fitBounds(bounds);
            });
        }

        // Echo
        Echo.channel('rtbtsWeb')
            .listen('GPSMoved', (e) => {
                updatePosition(e.lat, e.lng, e.bus_id);
        });
    </script>

    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-admin-tracking').addClass('active open')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })
    </script>
@endsection