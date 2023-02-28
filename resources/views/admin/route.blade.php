@extends('layouts.app')
@section('title','Manage Route')

@section('modal') 
    <style>
        .pac-container { z-index: 10000 !important; } 
    </style>
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
                    <hr class="hr-style-1 mb-2">
                    <div class="modal-body">
                        <!-- Input Hidden ID -->
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->company_id}}">
                        
                        <!-- Origin -->
                        <div class="row mb-3">
                            <!-- Address Input -->
                            <div class="col mb-0">
                                <label for="orig_address" class="form-label">Origin</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-map"></i>
                                    </span>
                                    <input type="text" id="orig_address" name="orig_address" class="form-control" placeholder="Type address..."/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_orig_address"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Route Name -->
                        <div class="row mb-3">
                            <!-- Origin Route Input -->
                            <div class="col mb-0">
                                <label for="origin" class="form-label">Name Origin Route</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-trip"></i>
                                    </span>
                                    <input type="text" id="origin" name="origin" class="form-control" placeholder="Route Name"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_origin"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Origin Coordinates -->
                        <div class="row g-2 mb-3">
                            <!-- Latitude -->
                            <div class="col mb-3">
                                <label for="orig_latitude" class="form-label">Latitude</label>
                                <div class="input-group input-group-merge">
                                    <input disabled type="text" id="orig_latitude" name="orig_latitude" class="form-control"/>
                                </div>
                            </div>
                            <!-- Longitude -->
                            <div class="col mb-0">
                                <label for="orig_longitude" class="form-label">Longitude</label>
                                <div class="input-group input-group-merge">
                                    <input disabled type="text" id="orig_longitude" name="orig_longitude" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4 mt-4">
                        <!-- Destination -->
                        <div class="row mb-3">
                            <!-- Input Origin -->
                            <div class="col mb-0">
                                <label for="dest_address" class="form-label">Destination</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-map"></i>
                                    </span>
                                    <input type="text" id="dest_address" name="dest_address" class="form-control" placeholder="Type address..."/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_dest_address"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Route Name -->
                        <div class="row mb-3">
                            <!-- Destination Route Input -->
                            <div class="col mb-0">
                                <label for="destination" class="form-label">Name Destination Route</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-trip"></i>
                                    </span>
                                    <input type="text" id="destination" name="destination" class="form-control" placeholder="Route Name"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_destination"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Destination Coordinates -->
                        <div class="row g-2 mb-3">
                            <!-- Latitude -->
                            <div class="col mb-3">
                                <label for="dest_latitude" class="form-label">Latitude</label>
                                <div class="input-group input-group-merge">
                                    <input disabled type="text" id="dest_latitude" name="dest_latitude" class="form-control"/>
                                </div>
                            </div>
                            <!-- Longitude -->
                            <div class="col mb-0">
                                <label for="dest_longitude" class="form-label">Longitude</label>
                                <div class="input-group input-group-merge">
                                    <input disabled type="text" id="dest_longitude" name="dest_longitude" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div class="error-pad mt-0">
                            <span class="errorMsg_from_to_location"></span>
                        </div>
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
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Vehicle /</span> Manage Route
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Manage your route information here. You can Add, and View data.
        </div>
        <!-- Bus Table -->
        <div class="card">
            <div class="card-header color">
                <button onclick="Add()" type="button" class="btn rounded-pill btn-primary">Add New</button>
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive ">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>No.</th>
                                <th>Route Name</th>
                                <th>Origin Address</th>
                                <th>Destination Address</th>
                                <!-- <th>(Vice Versa)</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php $count = 1; ?>
                            @foreach ($route as $rt)
                                @if($rt->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- List No. Column -->
                                    <td><strong>{{$count++}}</strong></td>
                                    <!-- Route Column -->
                                    <td>{{$rt->from_to_location}}</td>
                                    <td>{{$rt->orig_address}}</td>
                                    <td>{{$rt->dest_address}}</td>
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Edit -->
                                                <button onclick="Edit({{ $rt->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                <!-- Delete -->
                                                <!-- <button onclick="Delete({{ $rt->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i>
                                                    Delete
                                                </button> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7heM-_bsE_CpTJCieZ5R3wkZqAzm5XG0&libraries=places"></script>
    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-admin-vehicle').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-route').addClass('active')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
            // origin == vice-destination
            // $("select[name=origin]").on('change', function () {
            //     $('#vice-destination').val($(this).find('option:selected').text());
            // });
            // vice-origin == destination
            // $("select[name=destination]").on('change', function () {
            //     $('#vice-origin').val($(this).find('option:selected').text());
            // });

            // Origin Address
            var orig_autocomplete;
            orig_autocomplete = new google.maps.places.Autocomplete((document.getElementById('orig_address')), {
                componentRestrictions: {country: 'ph'},
            });
            google.maps.event.addListener(orig_autocomplete, 'place_changed', function () {
                var near_place = orig_autocomplete.getPlace();
                $('#orig_latitude').val(near_place.geometry.location.lat());
                $('#orig_longitude').val(near_place.geometry.location.lng());
            });

            // Destination Address
            var dest_autocomplete;
            dest_autocomplete = new google.maps.places.Autocomplete((document.getElementById('dest_address')), {
                componentRestrictions: {country: 'ph'},
            });
            google.maps.event.addListener(dest_autocomplete, 'place_changed', function () {
                var near_place = dest_autocomplete.getPlace();
                $('#dest_latitude').val(near_place.geometry.location.lat());
                $('#dest_longitude').val(near_place.geometry.location.lng());
            });
        });

        // Origin Clear When Changed
        $(document).on('change', '#orig_address', function () {
            $('#orig_latitude').html('');
            $('#orig_longitude').html('');
        });

        // Destinstion Clear When Changed
        $(document).on('change', '#dest_address', function () {
            $('#dest_latitude').html('');
            $('#dest_longitude').html('');
        });

        // Onclick Add Function
        function Add(){
            document.getElementById("main-modalTitle").innerHTML= "Create Route Information";
            document.getElementById("main-submit").innerHTML= "Create";
            // Clear Input Fields
            $('#id').val('-1'),
            $('#origin').val(''),
            $('#destination').val(''),
            $('#orig_address').val(''),
            $('#orig_latitude').val(''),
            $('#orig_longitude').val(''),
            $('#dest_address').val(''),
            $('#dest_latitude').val(''),
            $('#dest_longitude').val(''),
            // Clear Error Messages
            $("#main-modal .errorMsg_origin").html('');
            $("#main-modal .errorMsg_destination").html('');
            $("#main-modal .errorMsg_from_to_location").html('');
            $("#main-modal .errorMsg_orig_address").html('');
            $("#main-modal .errorMsg_orig_latitude").html('');
            $("#main-modal .errorMsg_orig_longitude").html('');
            $("#main-modal .errorMsg_dest_address").html('');
            $("#main-modal .errorMsg_dest_latitude").html('');
            $("#main-modal .errorMsg_dest_longitude").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Edit Function
        function Edit(id) {
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML="Edit Bus Information";
            document.getElementById("main-submit").innerHTML= "Save";
            // Show Values in Modal
            Controller.Post('/api/route/items', { 'id': id }).done(function(result) {
                var text = result.from_to_location;
                var locationArray = text.split(" - ");
                // Clear Error Messages
                $("#main-modal .errorMsg_origin").html('');
                $("#main-modal .errorMsg_destination").html('');
                $("#main-modal .errorMsg_from_to_location").html('');
                $("#main-modal .errorMsg_orig_address").html('');
                $("#main-modal .errorMsg_orig_latitude").html('');
                $("#main-modal .errorMsg_orig_longitude").html('');
                $("#main-modal .errorMsg_dest_address").html('');
                $("#main-modal .errorMsg_dest_latitude").html('');
                $("#main-modal .errorMsg_dest_longitude").html('');
                // Show ID values in Input Fields
                $('#id').val(result.id),
                $('#origin').val(locationArray[0]),
                $('#destination').val(locationArray[1]),
                $('#orig_address').val(result.orig_address),
                $('#orig_latitude').val(result.orig_latitude),
                $('#orig_longitude').val(result.orig_longitude),
                $('#dest_address').val(result.dest_address),
                $('#dest_latitude').val(result.dest_latitude),
                $('#dest_longitude').val(result.dest_longitude),
                // Show Modal
                $('#main-modal').modal('show');
            });
        }

        // Onclick Save Function
        function Save() {
            var orig_location = $('#origin').val();
            var dest_location = $('#destination').val();
            $("#main-modal .errorMsg_origin").html('');
            $("#main-modal .errorMsg_destination").html('');
            $("#main-modal .errorMsg_from_to_location").html('');
            $("#main-modal .errorMsg_orig_address").html('');
            $("#main-modal .errorMsg_orig_latitude").html('');
            $("#main-modal .errorMsg_orig_longitude").html('');
            $("#main-modal .errorMsg_dest_address").html('');
            $("#main-modal .errorMsg_dest_latitude").html('');
            $("#main-modal .errorMsg_dest_longitude").html('');
            // Error messages
            // if(orig_location == null){
            //     let msg_origin = "<text>The origin selection is required.</text>";
            //     $("#main-modal .errorMsg_origin").html(msg_origin).addClass('text-danger').fadeIn(1000);
            //     $("#main-modal button").attr('disabled',false);
            // }
            // if(dest_location == null){
            //     let msg_destination = "<text>The destination selection is required.</text>";
            //     $("#main-modal .errorMsg_destination").html(msg_destination).addClass('text-danger').fadeIn(1000);
            //     $("#main-modal button").attr('disabled',false);
            // }
            // if(orig_location == dest_location){
            //     let msg_from_to_location = "<text>The selection is invalid.</text>";
            //     $("#main-modal .errorMsg_from_to_location").html(msg_from_to_location).addClass('text-danger').fadeIn(1000);
            //     $("#main-modal button").attr('disabled',false);
            // }
            // else{
                // Get Values from input fields
                var data = {
                id: $('#id').val(),
                company_id: $('#company_id').val(),
                from_to_location: orig_location+' - '+dest_location,
                origin: $('#origin').val(),
                destination: $('#destination').val(),
                orig_address: $('#orig_address').val(),
                orig_latitude: $('#orig_latitude').val(),
                orig_longitude: $('#orig_longitude').val(),
                dest_address: $('#dest_address').val(),
                dest_latitude: $('#dest_latitude').val(),
                dest_longitude: $('#dest_longitude').val(),
                }
                // Add Data to Database
                if(data.id == -1) {
                    Controller.Post('/api/route/create', data)
                    // If success, return message
                    .done(function(result) {
                        var dialog = bootbox.dialog({
                        centerVertical: true,
                        closeButton: false,
                        title: 'Saving Information',
                        message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                        });
                        $('#main-modal').modal('hide');
                        dialog.init(function(){
                            setTimeout(function(){
                                dialog.find('.bootbox-body').html('Information Successfully saved!');
                                window.location.reload();
                            }, 1500);
                        });
                    })
                    // If fail, show errors
                    .fail(function (error) {
                        const error1 = error.responseJSON.errors;
                        let error_from_to_location = "";
                        let error_origin = "";
                        let error_destination = "";
                        let error_orig_address = "";
                        let error_orig_latitude = "";
                        let error_orig_longitude = "";
                        let error_dest_address = "";
                        let error_dest_latitude = "";
                        let error_dest_longitude = "";
                        for (const listKey in error1){
                            if(listKey == "from_to_location"){
                                error_from_to_location = ""+error1[listKey]+"";
                            }else if(listKey == "origin"){
                                error_origin = ""+error1[listKey]+"";
                            }else if(listKey == "destination"){
                                error_destination = ""+error1[listKey]+"";
                            }else if(listKey == "orig_address"){
                                error_orig_address = ""+error1[listKey]+"";
                            }else if(listKey == "orig_latitude"){
                                error_orig_latitude = ""+error1[listKey]+"";
                            }else if(listKey == "orig_longitude"){
                                error_orig_longitude = ""+error1[listKey]+"";
                            }else if(listKey == "dest_address"){
                                error_dest_address = ""+error1[listKey]+"";
                            }else if(listKey == "dest_latitude"){
                                error_dest_latitude = ""+error1[listKey]+"";
                            }else if(listKey == "dest_longitude"){
                                error_dest_longitude = ""+error1[listKey]+"";
                            }
                        }
                        let msg_from_to_location = "<text>"+error_from_to_location+"</text>";
                        let msg_origin = "<text>"+error_origin+"</text>";
                        let msg_destination = "<text>"+error_destination+"</text>";
                        let msg_orig_address = "<text>"+error_orig_address+"</text>";
                        let msg_orig_latitude = "<text>"+error_orig_latitude+"</text>";
                        let msg_orig_longitude = "<text>"+error_orig_longitude+"</text>";
                        let msg_dest_address = "<text>"+error_dest_address+"</text>";
                        let msg_dest_latitude = "<text>"+error_dest_latitude+"</text>";
                        let msg_dest_longitude = "<text>"+error_dest_longitude+"</text>";
                        $("#main-modal .errorMsg_from_to_location").html(msg_from_to_location).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_origin").html(msg_origin).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_destination").html(msg_destination).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_address").html(msg_orig_address).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_latitude").html(msg_orig_latitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_longitude").html(msg_orig_longitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_address").html(msg_dest_address).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_latitude").html(msg_dest_latitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_longitude").html(msg_dest_longitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal button").attr('disabled',false);
                    })
                }else if(data.id > 0) {
                    Controller.Post('/api/route/update', data)
                    // If success, return message
                    .done(function(result) {
                            var dialog = bootbox.dialog({
                        centerVertical: true,
                        closeButton: false,
                        title: 'Updating Information',
                        message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                        });
                        $('#main-modal').modal('hide');
                        dialog.init(function(){
                            setTimeout(function(){
                                dialog.find('.bootbox-body').html('Information Successfully updated!');
                                window.location.reload();
                            }, 1500);
                        });
                    })
                    // If fail, show errors
                    .fail(function (error) {
                        const error1 = error.responseJSON.errors;
                        let error_from_to_location = "";
                        let error_origin = "";
                        let error_destination = "";
                        let error_orig_address = "";
                        let error_orig_latitude = "";
                        let error_orig_longitude = "";
                        let error_dest_address = "";
                        let error_dest_latitude = "";
                        let error_dest_longitude = "";
                        for (const listKey in error1){
                            if(listKey == "from_to_location"){
                                error_from_to_location = ""+error1[listKey]+"";
                            }else if(listKey == "origin"){
                                error_origin = ""+error1[listKey]+"";
                            }else if(listKey == "destination"){
                                error_destination = ""+error1[listKey]+"";
                            }else if(listKey == "orig_address"){
                                error_orig_address = ""+error1[listKey]+"";
                            }else if(listKey == "orig_latitude"){
                                error_orig_latitude = ""+error1[listKey]+"";
                            }else if(listKey == "orig_longitude"){
                                error_orig_longitude = ""+error1[listKey]+"";
                            }else if(listKey == "dest_address"){
                                error_dest_address = ""+error1[listKey]+"";
                            }else if(listKey == "dest_latitude"){
                                error_dest_latitude = ""+error1[listKey]+"";
                            }else if(listKey == "dest_longitude"){
                                error_dest_longitude = ""+error1[listKey]+"";
                            }
                        }
                        let msg_from_to_location = "<text>"+error_from_to_location+"</text>";
                        let msg_origin = "<text>"+error_origin+"</text>";
                        let msg_destination = "<text>"+error_destination+"</text>";
                        let msg_orig_address = "<text>"+error_orig_address+"</text>";
                        let msg_orig_latitude = "<text>"+error_orig_latitude+"</text>";
                        let msg_orig_longitude = "<text>"+error_orig_longitude+"</text>";
                        let msg_dest_address = "<text>"+error_dest_address+"</text>";
                        let msg_dest_latitude = "<text>"+error_dest_latitude+"</text>";
                        let msg_dest_longitude = "<text>"+error_dest_longitude+"</text>";
                        $("#main-modal .errorMsg_from_to_location").html(msg_from_to_location).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_origin").html(msg_origin).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_destination").html(msg_destination).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_address").html(msg_orig_address).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_latitude").html(msg_orig_latitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_orig_longitude").html(msg_orig_longitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_address").html(msg_dest_address).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_latitude").html(msg_dest_latitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal .errorMsg_dest_longitude").html(msg_dest_longitude).addClass('text-danger').fadeIn(1000);
                        $("#main-modal button").attr('disabled',false);
                    })
                }
            // }
        }

        // Onclick Delete Function
        // function Delete(id) {
        //     $('#view-modal').modal('hide');
        //     bootbox.confirm({
        //         title: "Deleting Information",
        //         closeButton: false,
        //         message: "Are you sure you want to delete this item? This cannot be undone.",
        //         buttons: {
        //             cancel: {
        //                 label: 'Cancel',
        //                 className : "btn btn-outline-secondary",
        //             },
        //             confirm: {
        //                 label: 'Confirm',
        //                 className : "btn btn-primary",
        //             }
        //         },
        //         centerVertical: true,
        //         callback: function(result){
        //             if(result) {
        //                 Controller.Post('/api/route/delete', { 'id': id }).done(function(result) {
        //                     if(result == 1){
        //                         bootbox.confirm({
        //                             title: "Oops! There is a schedule with this route.",
        //                             closeButton: false,
        //                             message: "Go to schedules list?",
        //                             buttons: {
        //                                 cancel: {
        //                                     label: 'No',
        //                                     className : "btn btn-outline-secondary",
        //                                 },
        //                                 confirm: {
        //                                     label: 'Yes',
        //                                     className : "btn btn-primary",
        //                                 }
        //                             },
        //                             centerVertical: true,
        //                             callback: function(result){
        //                                 if(result) {
        //                                     location.href = './schedule';
        //                                 }
        //                             }
        //                             })
        //                     }
        //                     else{
        //                         var dialog = bootbox.dialog({
        //                         centerVertical: true,
        //                         closeButton: false,
        //                         title: 'Deleting Information',
        //                         message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //                         });
        //                         dialog.init(function(){
        //                             setTimeout(function(){
        //                                 dialog.find('.bootbox-body').html('Information Successfully deleted!');
        //                                 window.location.reload();
        //                             }, 1500);
                                    
        //                         });
        //                     }
                            
        //                 });
        //             }
        //         }
        //     })
        // }
    </script>
@endsection