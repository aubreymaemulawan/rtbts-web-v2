@extends('layouts.app')
@section('title','Manage Fare')

@section('modal')
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
                        <div class="row g-2">
                            <!-- Input Route Id -->
                            <div class="col mb-0">
                                <label for="route_id" class="form-label">Route</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="route_id" name="route_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach ($route as $rt)
                                            @if($rt->company_id == Auth::user()->company_id)
                                                <option value="{{ $rt->id }}">{{ $rt->from_to_location }}</option>
                                            @endif
                                        @endforeach
                                    </select> 
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_route_id"></span>
                                </div>
                            </div>
                            <!-- Input Bus Type -->
                            <div class="col mb-0">
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
                            <!-- Error Message -->
                            <div class="error-pad mt-0">
                                <span class="errorMsg_rt_error"></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <!-- Input Price -->
                            <div class="col mb-3">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-money"></i>
                                    </span>
                                    <input type="number" id="price" name="price" class="form-control" placeholder="₱ 000.00"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_price"></span>
                                </div>
                            </div>
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
            <span class="text-muted fw-light">Bus Vehicle /</span> Manage Fare
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Manage your fare information here. You can Add, Update, View, and Delete data.
        </div>
        <?php $crt = 0; ?>
        <!-- Bus Table -->
        <div class="card">
            <div class="card-header color">
                @foreach($route as $rs)
                    @if($rs->company_id == Auth::user()->company_id)
                      <?php $crt += 1;?>
                    @endif
                @endforeach
                @if($crt != 0)
                    <button onclick="Add()" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @else
                    <button onclick="Error()" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @endif
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>List No.</th>
                                <th>Route</th>
                                <th>Bus Type</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php $count = 1;?>
                            @foreach ($fare as $fr)
                                @if($fr->route->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- List No. -->
                                    <td><strong>{{$count++}}</strong></td>
                                    <!-- Route Column -->
                                    <td>{{$fr->route->from_to_location}}</td>
                                    <!-- Bus Type No. Column -->
                                    @if ($fr->bus_type == 1)
                                    <td>Airconditioned</td>
                                    @elseif ($fr->bus_type == 2)
                                    <td>Non Airconditioned</td>
                                    @endif
                                    <!-- Price Column -->
                                    <td>₱ {{$fr->price}}</td>
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Edit -->
                                                <button onclick="Edit({{ $fr->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                <!-- Delete -->
                                                <button onclick="Delete({{ $fr->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i>
                                                    Delete
                                                </button>
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
    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-admin-vehicle').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-fare').addClass('active')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })

        // Onclick Error Function
        function Error(){
            bootbox.confirm({
                title: "The route list is currently empty.",
                closeButton: false,
                message: "Go to manage route list?",
                buttons: {
                    cancel: {
                        label: 'No',
                        className : "btn btn-outline-secondary",
                    },
                    confirm: {
                        label: 'Yes',
                        className : "btn btn-primary",
                    }
                },
                centerVertical: true,
                callback: function(result){
                    if(result) {
                        location.href = './route';
                    }
                }
            })
        }

        // Onclick Add Function
        function Add(){
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML= "Create Fare Information";
            document.getElementById("main-submit").innerHTML= "Create";
            // Clear Input Fields
            $('#id').val('-1'),
            $('#route_id').val(''),
            $('#bus_type').val(''),
            $('#price').val(''),
            // Clear Error Messages
            $("#main-modal .errorMsg_route_id").html('');
            $("#main-modal .errorMsg_bus_type").html('');
            $("#main-modal .errorMsg_price").html('');
            $("#main-modal .errorMsg_rt_error").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Edit Function
        function Edit(id) {
            document.getElementById("main-modalTitle").innerHTML="Edit Fare Information";
            document.getElementById("main-submit").innerHTML= "Save";
            // Show Values in Modal
            Controller.Post('/api/fare/items', { 'id': id }).done(function(result) {
                // Clear Error Messages
                $("#main-modal .errorMsg_route_id").html('');
                $("#main-modal .errorMsg_bus_type").html('');
                $("#main-modal .errorMsg_price").html('');
                $("#main-modal .errorMsg_rt_error").html('');
                // Show ID values in Input Fields
                $('#id').val(result.id),
                $('#route_id').val(result.route_id),
                $('#bus_type').val(result.bus_type),
                $('#price').val(result.price),
                // Show Modal
                $('#main-modal').modal('show');
            });
        }

        // Onclick Save Function
        function Save() {
            $("#main-modal .errorMsg_route_id").html('');
            $("#main-modal .errorMsg_bus_type").html('');
            $("#main-modal .errorMsg_price").html('');
            $("#main-modal .errorMsg_rt_error").html('');
            // Get Values from input fields
            var data = {
            id: $('#id').val(),
            route_id: $('#route_id').val(),
            bus_type: $('#bus_type').val(),
            price: $('#price').val(),
            }
            // Add Data to Database
            if(data.id == -1) {
                Controller.Post('/api/fare/create', data)
                // If success, return message
                .done(function(result) {
                    // If route already registered, display error
                    if(result == 1){
                        let msg_rt_error = "<text>The route has already been taken for selected bus type.</text>";
                        $("#main-modal .errorMsg_rt_error").html(msg_rt_error).addClass('text-danger').fadeIn(1000);
                        $("#main-modal button").attr('disabled',false);
                    }
                    // Else display success message
                    else{
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
                    }

                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_route_id = "";
                    let error_bus_type = "";
                    let error_price = "";
                    for (const listKey in error1){
                        if(listKey == "route_id"){
                            error_route_id = ""+error1[listKey]+"";
                        }else if(listKey == "bus_type"){
                            error_bus_type = ""+error1[listKey]+"";
                        }else if(listKey == "price"){
                            error_price = ""+error1[listKey]+"";
                        }
                    }
                    let msg_route_id = "<text>"+error_route_id+"</text>";
                    let msg_bus_type = "<text>"+error_bus_type+"</text>";
                    let msg_price = "<text>"+error_price+"</text>";
                    $("#main-modal .errorMsg_route_id").html(msg_route_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_price").html(msg_price).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })
            }
            // Update Data to Database
            else if(data.id > 0) {
                Controller.Post('/api/fare/update', data)
                // If success, return message
                .done(function(result) {
                    // If route already registered, display error
                    if(result == 1){
                        let msg_rt_error = "<text>The route has already been taken for selected bus type.</text>";
                        $("#main-modal .errorMsg_rt_error").html(msg_rt_error).addClass('text-danger').fadeIn(1000);
                        $("#main-modal button").attr('disabled',false);
                    }// Else display success message
                    else{
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
                    }
                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_route_id = "";
                    let error_bus_type = "";
                    let error_price = "";
                    for (const listKey in error1){
                        if(listKey == "route_id"){
                            error_route_id = ""+error1[listKey]+"";
                        }else if(listKey == "bus_type"){
                            error_bus_type = ""+error1[listKey]+"";
                        }else if(listKey == "price"){
                            error_price = ""+error1[listKey]+"";
                        }
                    }
                    let msg_route_id = "<text>"+error_route_id+"</text>";
                    let msg_bus_type = "<text>"+error_bus_type+"</text>";
                    let msg_price = "<text>"+error_price+"</text>";
                    $("#main-modal .errorMsg_route_id").html(msg_route_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_price").html(msg_price).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })    
            }
        }

        // Onclick Delete Function
        function Delete(id) {
            bootbox.confirm({
                title: "Deleting Information",
                closeButton: false,
                message: "Are you sure you want to delete this item? This cannot be undone.",
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className : "btn btn-outline-secondary",
                    },
                    confirm: {
                        label: 'Confirm',
                        className : "btn btn-primary",
                    }
                },
                centerVertical: true,
                callback: function(result){
                    if(result) {
                        Controller.Post('/api/fare/delete', { 'id': id }).done(function(result) {
                            var dialog = bootbox.dialog({
                                centerVertical: true,
                                closeButton: false,
                                title: 'Deleting Information',
                                message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                            });
                            dialog.init(function(){
                                setTimeout(function(){
                                    dialog.find('.bootbox-body').html('Information Successfully deleted!');
                                    window.location.reload();
                                }, 1500);
                                
                            });
                        });
                    }
                }
            })
        }
    </script>
@endsection